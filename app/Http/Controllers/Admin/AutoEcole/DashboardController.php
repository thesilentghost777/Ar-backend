<?php

namespace App\Http\Controllers\Admin\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\AutoEcoleUser;
use App\Models\AutoEcolePaiement;
use App\Models\Module;
use App\Models\Session;
use App\Models\ResultatQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_utilisateurs' => AutoEcoleUser::count(),
            'utilisateurs_mois' => AutoEcoleUser::whereMonth('created_at', now()->month)->count(),
            'total_depots' => AutoEcolePaiement::where('type', 'depot')->where('status', 'valide')->sum('montant'),
            'depots_mois' => AutoEcolePaiement::where('type', 'depot')
                ->where('status', 'valide')
                ->whereMonth('created_at', now()->month)
                ->sum('montant'),
            'total_modules' => Module::count(),
            'sessions_actives' => Session::where('active', true)->count(),
            'quiz_passes' => ResultatQuiz::where('reussi', true)->count(),
        ];

        $utilisateursRecents = AutoEcoleUser::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $paiementsRecents = AutoEcolePaiement::with('user')
            ->where('status', 'valide')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $repartitionNiveaux = AutoEcoleUser::select('niveau_parrainage', DB::raw('count(*) as total'))
            ->groupBy('niveau_parrainage')
            ->get();


            // Données pour le graphique d'évolution des inscriptions (groupées par mois)
$inscriptions = AutoEcoleUser::select(
    DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
    DB::raw('COUNT(*) as count')
)
    ->groupBy('month')
    ->orderBy('month')
    ->get();

$inscriptionsLabels = $inscriptions->pluck('month');
$inscriptionsData = $inscriptions->pluck('count');  // Note: This matches the variable name used in the Blade file for values

        return view('admin.auto-ecole.dashboard', compact(
    'stats',
    'utilisateursRecents',
    'paiementsRecents',
    'repartitionNiveaux',
    'inscriptionsLabels',
    'inscriptionsData'
));
    }
}
