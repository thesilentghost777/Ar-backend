<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->dashboardService->getDashboard($request->user());
            
            // Nettoyer les données avant l'encodage JSON
            $cleanResult = $this->sanitizeUtf8($result);
            
            return response()->json($cleanResult);
            
        } catch (\Exception $e) {
            \Log::error('Dashboard error', [
                'message' => $e->getMessage(),
                'user_id' => $request->user()?->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement du tableau de bord'
            ], 500);
        }
    }
    
    /**
     * Nettoie récursivement toutes les chaînes pour garantir un UTF-8 valide
     */
    private function sanitizeUtf8($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitizeUtf8($value);
            }
            return $data;
        }
        
        if (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = $this->sanitizeUtf8($value);
            }
            return $data;
        }
        
        if (is_string($data)) {
            // Vérifier si la chaîne est déjà en UTF-8 valide
            if (!mb_check_encoding($data, 'UTF-8')) {
                // Tenter de convertir depuis d'autres encodages
                $data = mb_convert_encoding($data, 'UTF-8', 'auto');
            }
            
            // Supprimer les caractères de contrôle invalides
            $data = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $data);
            
            return $data;
        }
        
        return $data;
    }
}