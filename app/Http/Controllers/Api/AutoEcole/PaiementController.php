<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\PaiementService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaiementController extends Controller
{
    public function __construct(private PaiementService $paiementService) {}

    public function deposerViaMobile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:10000',
            'numero_payeur' => 'required|string'
        ]);

        $result = $this->paiementService->deposerViaMobile(
            $request->user(),
            $validated['montant'],
            $validated['numero_payeur']
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function deposerViaCodeCaisse(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        $result = $this->paiementService->deposerViaCodeCaisse(
            $request->user(),
            $validated['code']
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function transferer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'telephone_destinataire' => 'required|string',
            'montant' => 'required|numeric|min:1'
        ]);

        $result = $this->paiementService->transferer(
            $request->user(),
            $validated['telephone_destinataire'],
            $validated['montant']
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function rechercherDestinataire(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'telephone' => 'required|string'
        ]);

        $result = $this->paiementService->rechercherDestinataire($validated['telephone']);
        return response()->json($result, $result['success'] ? 200 : 404);
    }

    public function payerFrais(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type_frais' => 'required|in:formation,inscription,examen_blanc,examen'
        ]);

        $result = $this->paiementService->payerFrais(
            $request->user(),
            $validated['type_frais']
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function getStatusFrais(Request $request): JsonResponse
    {
        $result = $this->paiementService->getStatusFrais($request->user());
        return response()->json($result);
    }

    public function getHistorique(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 20);
        $result = $this->paiementService->getHistorique($request->user(), $limit);
        return response()->json($result);
    }
}
