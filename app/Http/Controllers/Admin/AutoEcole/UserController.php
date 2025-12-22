<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\AutoEcoleUser;
use App\Models\Session;
use App\Models\CentreExamen;
use App\Models\LieuPratique;
use App\Models\ResultatQuiz;
use App\Models\ProgressionLecon;
use App\Models\Filleul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = AutoEcoleUser::with(['session', 'centreExamen', 'parrain', 'lieuxPratique']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('code_parrainage', 'like', "%{$search}%");
            });
        }

        if ($request->filled('niveau')) {
            $query->where('niveau_parrainage', $request->niveau);
        }

        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        $utilisateurs = $query->orderBy('created_at', 'desc')->paginate(20);
        $sessions = Session::where('active', true)->get();

        return view('admin.auto-ecole.users.index', compact('utilisateurs', 'sessions'));
    }

    public function show(AutoEcoleUser $user)
    {
        // Chargement des relations
        $user->loadMissing(['session', 'centreExamen', 'parrain', 'lieuxPratique']);

        $filleuls = Filleul::where('parrain_id', $user->id)
            ->with('filleul')
            ->get();

        $resultatsQuiz = ResultatQuiz::where('user_id', $user->id)
            ->with('quiz.chapitre.module')
            ->orderBy('created_at', 'desc')
            ->get();

        $progressionLecons = ProgressionLecon::where('user_id', $user->id)
            ->where('completee', true)
            ->with('lecon.chapitre.module')
            ->get();

        return view('admin.auto-ecole.users.show', compact(
            'user',
            'filleuls',
            'resultatsQuiz',
            'progressionLecons'
        ));
    }

    public function edit(AutoEcoleUser $user)
    {
        $sessions = Session::where('active', true)->get();
        $centresExamen = CentreExamen::where('active', true)->get();
        $lieuxPratique = LieuPratique::where('active', true)->get();

        return view('admin.auto-ecole.users.edit', compact('user', 'sessions', 'centresExamen', 'lieuxPratique'));
    }

    public function update(Request $request, AutoEcoleUser $user)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|unique:auto_ecole_users,telephone,' . $user->id,
            'quartier' => 'nullable|string',
            'type_permis' => 'required|in:permis_a,permis_b,permis_t',
            'type_cours' => 'required|in:en_ligne,presentiel,les_deux',
            'session_id' => 'nullable|exists:sessions1,id',
            'centre_examen_id' => 'nullable|exists:centres_examen,id',
            'vague' => 'required|in:1,2',
            'validated' => 'boolean',
            'lieux_pratique' => 'nullable|array',
            'lieux_pratique.*' => 'exists:lieux_pratique,id'
        ]);

        // Mettre à jour les informations de base
        $user->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'quartier' => $validated['quartier'] ?? null,
            'type_permis' => $validated['type_permis'],
            'type_cours' => $validated['type_cours'],
            'session_id' => $validated['session_id'] ?? null,
            'centre_examen_id' => $validated['centre_examen_id'] ?? null,
            'vague' => $validated['vague'],
            'validated' => $request->has('validated') ? true : false,
        ]);

        // Synchroniser les lieux de pratique
        if (isset($validated['lieux_pratique'])) {
            $user->lieuxPratique()->sync($validated['lieux_pratique']);
        } else {
            $user->lieuxPratique()->detach();
        }

        return redirect()->route('admin.auto-ecole.users.show', $user)
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function resetPassword(Request $request, AutoEcoleUser $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'Mot de passe réinitialisé avec succès');
    }

    public function updateFraisStatus(Request $request, AutoEcoleUser $user)
    {
        $validated = $request->validate([
            'type' => 'required|in:formation,inscription,examen_blanc,examen',
            'status' => 'required|in:non_paye,paye,dispense'
        ]);

        $statusField = match ($validated['type']) {
            'formation' => 'status_frais_formation',
            'inscription' => 'status_frais_inscription',
            'examen_blanc' => 'status_examen_blanc',
            'examen' => 'status_frais_examen'
        };

        $descriptionField = match ($validated['type']) {
            'formation' => 'description_paiement_formation',
            'inscription' => 'description_paiement_inscription',
            'examen_blanc' => 'description_paiement_examen_blanc',
            'examen' => 'description_paiement_examen'
        };

        $user->{$statusField} = $validated['status'];
        $user->{$descriptionField} = 'Modifié par admin le ' . now()->format('d/m/Y à H:i');
        $user->save();

        return redirect()->back()->with('success', 'Status des frais mis à jour');
    }

    public function updateSolde(Request $request, AutoEcoleUser $user)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0',
            'operation' => 'required|in:ajouter,retirer'
        ]);

        $montant = $validated['montant'];

        if ($validated['operation'] === 'ajouter') {
            $user->solde += $montant;
        } else {
            if ($user->solde < $montant) {
                return redirect()->back()->withErrors(['montant' => 'Solde insuffisant']);
            }
            $user->solde -= $montant;
        }

        $user->save();

        return redirect()->back()->with('success', 'Solde mis à jour avec succès');
    }

    public function destroy(AutoEcoleUser $user)
    {
        $user->delete();
        return redirect()->route('admin.auto-ecole.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }
}
