<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\CentreExamen;
use App\Models\LieuPratique;
use App\Models\JourPratique;
use Illuminate\Http\JsonResponse;

class SessionController extends Controller
{
    /**
     * Récupère toutes les sessions actives.
     */
    public function index(): JsonResponse
    {
        $sessions = Session::where('active', true)->get();
        return response()->json([
            'success' => true,
            'sessions' => $sessions
        ]);
    }

    /**
     * Récupère tous les centres d'examen actifs.
     */
    public function centresExamen(): JsonResponse
    {
        $centres = CentreExamen::where('active', true)->get();
        return response()->json([
            'success' => true,
            'centres_examen' => $centres
        ]);
    }

    /**
     * Récupère tous les jours de pratique actifs.
     */
    public function joursPratique(): JsonResponse
    {
        $jours = JourPratique::where('active', true)->with('lieuPratique')->get();
        return response()->json([
            'success' => true,
            'jours_pratique' => $jours
        ]);
    }

    /**
     * Récupère tous les lieux de pratique actifs.
     */
    public function lieuxPratique(): JsonResponse
    {
        $lieux = LieuPratique::where('active', true)->get();
        return response()->json([
            'success' => true,
            'lieux_pratique' => $lieux
        ]);
    }
}
