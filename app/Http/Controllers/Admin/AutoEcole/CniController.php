<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\UserCni;
use App\Models\AutoEcoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CniController extends Controller
{
    /**
     * Liste de tous les utilisateurs avec leur statut CNI.
     */
    public function index(Request $request)
    {
        $query = AutoEcoleUser::with('cni')
            ->orderBy('created_at', 'desc');

        // Filtrer par statut CNI
        if ($request->filled('statut')) {
            $statut = $request->statut;
            $query->whereHas('cni', function ($q) use ($statut) {
                $q->where('statut', $statut);
            });

            // Cas spécial : "sans_cni" = pas encore soumis
            if ($statut === 'sans_cni') {
                $query = AutoEcoleUser::with('cni')
                    ->whereDoesntHave('cni')
                    ->orderBy('created_at', 'desc');
            }
        }

        // Recherche par nom, prénom ou téléphone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $utilisateurs = $query->paginate(20)->withQueryString();

        $stats = [
            'total'      => AutoEcoleUser::count(),
            'en_attente' => UserCni::where('statut', 'en_attente')->count(),
            'valide'     => UserCni::where('statut', 'valide')->count(),
            'rejete'     => UserCni::where('statut', 'rejete')->count(),
            'sans_cni'   => AutoEcoleUser::whereDoesntHave('cni')->count(),
        ];

        return view('admin.auto-ecole.cni.index', compact('utilisateurs', 'stats'));
    }

    /**
     * Afficher le détail CNI d'un utilisateur.
     */
    public function show(AutoEcoleUser $user)
    {
        $cni = $user->cni;
        return view('admin.auto-ecole.cni.show', compact('user', 'cni'));
    }

    /**
     * Valider la CNI d'un utilisateur.
     */
    public function valider(AutoEcoleUser $user)
    {
        $cni = $user->cni;

        if (!$cni) {
            return back()->with('error', 'Aucune CNI soumise pour cet utilisateur.');
        }

        $cni->update([
            'statut'      => 'valide',
            'motif_rejet' => null,
            'traite_at'   => now(),
            'traite_par'  => Auth::id(),
        ]);

        return back()->with('success', "La CNI de {$user->prenom} {$user->nom} a été validée.");
    }

    /**
     * Rejeter la CNI d'un utilisateur avec un motif.
     */
    public function rejeter(Request $request, AutoEcoleUser $user)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500',
        ], [
            'motif_rejet.required' => 'Le motif de rejet est obligatoire.',
        ]);

        $cni = $user->cni;

        if (!$cni) {
            return back()->with('error', 'Aucune CNI soumise pour cet utilisateur.');
        }

        $cni->update([
            'statut'      => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'traite_at'   => now(),
            'traite_par'  => Auth::id(),
        ]);

        return back()->with('success', "La CNI de {$user->prenom} {$user->nom} a été rejetée.");
    }

    /**
     * Remettre la CNI en attente (réinitialiser le statut).
     */
    public function enAttente(AutoEcoleUser $user)
    {
        $cni = $user->cni;

        if (!$cni) {
            return back()->with('error', 'Aucune CNI soumise pour cet utilisateur.');
        }

        $cni->update([
            'statut'      => 'en_attente',
            'motif_rejet' => null,
            'traite_at'   => null,
            'traite_par'  => null,
        ]);

        return back()->with('success', "La CNI de {$user->prenom} {$user->nom} a été remise en attente.");
    }

    /**
     * Changer le statut en AJAX (optionnel).
     */
    public function updateStatut(Request $request, AutoEcoleUser $user)
    {
        $request->validate([
            'statut'      => 'required|in:en_attente,valide,rejete',
            'motif_rejet' => 'required_if:statut,rejete|nullable|string|max:500',
        ]);

        $cni = $user->cni;

        if (!$cni) {
            return response()->json(['message' => 'Aucune CNI soumise.'], 404);
        }

        $cni->update([
            'statut'      => $request->statut,
            'motif_rejet' => $request->statut === 'rejete' ? $request->motif_rejet : null,
            'traite_at'   => now(),
            'traite_par'  => Auth::id(),
        ]);

        return response()->json(['message' => 'Statut mis à jour avec succès.', 'statut' => $cni->statut]);
    }
}