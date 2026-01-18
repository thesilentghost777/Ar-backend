<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\AuthService;
use App\Services\AutoEcole\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;
    protected $dashboardService;

    public function __construct(AuthService $authService, DashboardService $dashboardService)
    {
        $this->authService = $authService;
        $this->dashboardService = $dashboardService;
    }

    public function inscription(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|unique:auto_ecole_users,telephone',
            'password' => 'required|string|min:6|confirmed',
            'date_naissance' => 'nullable|date',
            'quartier' => 'nullable|string',
            'type_permis' => 'required|in:permis_a,permis_b,permis_t',
            'type_cours' => 'required|in:en_ligne,presentiel,les_deux',
            'vague' => 'required|in:1,2',
            'session_id' => 'nullable|exists:sessions1,id',
            'centre_examen_id' => 'nullable|exists:centres_examen,id',
            'code_parrainage' => 'nullable|string',
            'lieux_pratique' => 'nullable|array',
            'lieux_pratique.*' => 'exists:lieux_pratique,id'
        ]);

        $result = $this->authService->inscription($validated);

        return response()->json($result, $result['success'] ? 201 : 422);
    }

    public function connexion(Request $request): JsonResponse
{
    Log::info('=== TENTATIVE DE CONNEXION ===', [
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent()
    ]);

    $validated = $request->validate([
        'telephone' => 'required|string',
        'password' => 'required|string'
    ]);

    Log::info('Données de connexion reçues', [
        'telephone' => $validated['telephone'],
        'password_length' => strlen($validated['password']),
        'password_empty' => empty($validated['password'])
    ]);

    try {
        $result = $this->authService->connexion(
            $validated['telephone'], 
            $validated['password']
        );

        if ($result['success']) {
            Log::info('✓ Connexion réussie', [
                'telephone' => $validated['telephone'],
                'user_id' => $result['user']['id'] ?? 'N/A'
            ]);
        } else {
            Log::warning('✗ Échec de connexion', [
                'telephone' => $validated['telephone'],
                'raison' => $result['message'] ?? 'Inconnue',
                'details' => $result
            ]);
        }

        return response()->json($result, $result['success'] ? 200 : 401);

    } catch (\Exception $e) {
        Log::error('ERREUR lors de la connexion', [
            'telephone' => $validated['telephone'],
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Erreur serveur lors de la connexion'
        ], 500);
    }
}

    public function deconnexion(Request $request): JsonResponse
    {
        $user = $request->user('api'); // Spécifie le guard
        Log::info('Déconnexion user:', ['user' => $user]);

        $result = $this->authService->deconnexion($user);

        return response()->json($result);
    }

    public function profil(Request $request): JsonResponse
    {
        $user = $request->user('api'); // Spécifie le guard
        Log::info('Profil user:', ['user' => $user]);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $result = $this->authService->profil($user);

        return response()->json($result);
    }

    public function mettreAJourProfil(Request $request): JsonResponse
    {
        $user = $request->user('api'); // Spécifie le guard

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|unique:auto_ecole_users,telephone,' . $user->id,
            'quartier' => 'nullable|string',
            'type_cours' => 'sometimes|in:en_ligne,presentiel,les_deux',
            'password' => 'nullable|string|min:6',
            'lieux_pratique' => 'nullable|array',
            'lieux_pratique.*' => 'exists:lieux_pratique,id'
        ]);

        $result = $this->authService->mettreAJourProfil($user, $validated);

        return response()->json($result);
    }

    public function codeParrainageDefaut(): JsonResponse
    {
        $result = $this->authService->getCodeParrainageDefaut();

        return response()->json($result);
    }

    public function configuration(): JsonResponse
    {
        $result = $this->dashboardService->getConfiguration();

        return response()->json($result);
    }
}