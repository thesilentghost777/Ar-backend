<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\AutoEcolePaiement;
use App\Models\AutoEcoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = AutoEcolePaiement::with(['user', 'destinataire']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('methode')) {
            $query->where('methode', $request->methode);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $paiements = $query->orderBy('created_at', 'desc')->paginate(30);

        $stats = [
            'total_depots' => AutoEcolePaiement::where('type', 'depot')->where('status', 'valide')->sum('montant'),
            'total_transferts' => AutoEcolePaiement::where('type', 'transfert_sortant')->where('status', 'valide')->sum('montant'),
            'total_frais' => AutoEcolePaiement::where('type', 'paiement_frais')->where('status', 'valide')->sum('montant'),
            'depots_jour' => AutoEcolePaiement::where('type', 'depot')
                ->where('status', 'valide')
                ->whereDate('created_at', today())
                ->sum('montant'),
        ];

        return view('admin.auto-ecole.paiements.index', compact('paiements', 'stats'));
    }

    public function show(AutoEcolePaiement $paiement)
    {
        $paiement->load(['user', 'destinataire']);
        return view('admin.auto-ecole.paiements.show', compact('paiement'));
    }

    public function rapportMensuel(Request $request)
    {
        $mois = $request->input('mois', now()->month);
        $annee = $request->input('annee', now()->year);

        $depots = AutoEcolePaiement::where('type', 'depot')
            ->where('status', 'valide')
            ->whereMonth('created_at', $mois)
            ->whereYear('created_at', $annee)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(montant) as total'),
                DB::raw('COUNT(*) as nombre')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $fraisPayes = AutoEcolePaiement::where('type', 'paiement_frais')
            ->where('status', 'valide')
            ->whereMonth('created_at', $mois)
            ->whereYear('created_at', $annee)
            ->select('frais_type', DB::raw('SUM(montant) as total'), DB::raw('COUNT(*) as nombre'))
            ->groupBy('frais_type')
            ->get();

        $totalMois = AutoEcolePaiement::where('type', 'depot')
            ->where('status', 'valide')
            ->whereMonth('created_at', $mois)
            ->whereYear('created_at', $annee)
            ->sum('montant');

        return view('admin.auto-ecole.paiements.rapport', compact('depots', 'fraisPayes', 'totalMois', 'mois', 'annee'));
    }

    public function ajouterDepotManuel(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:auto_ecole_users,id',
            'montant' => 'required|numeric|min:1',
            'description' => 'nullable|string'
        ]);

        $user = AutoEcoleUser::findOrFail($validated['user_id']);
        $soldeAvant = $user->solde;
        $soldeApres = $soldeAvant + $validated['montant'];

        AutoEcolePaiement::create([
            'user_id' => $user->id,
            'type' => 'depot',
            'methode' => 'systeme',
            'montant' => $validated['montant'],
            'solde_avant' => $soldeAvant,
            'solde_apres' => $soldeApres,
            'reference' => AutoEcolePaiement::genererReference(),
            'description' => $validated['description'] ?? 'Dépôt manuel par admin',
            'status' => 'valide'
        ]);

        $user->solde = $soldeApres;

        if (is_null($user->premier_depot_at)) {
            $user->premier_depot_at = now();
            $user->cours_debloques = true;
        }

        $user->save();

        return redirect()->back()->with('success', 'Dépôt effectué avec succès');
    }
}
