<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\PaiementService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    public function __construct(private PaiementService $paiementService) {}

    public function deposerViaMobile(Request $request): JsonResponse
    {
        Log::info('deposerViaMobile called', ['user_id' => $request->user()->id, 'payload' => $request->all()]);
        
        $validated = $request->validate([
            'montant' => 'required|numeric|min:10000',
            'numero_payeur' => 'required|string'
        ]);

        $result = $this->paiementService->deposerViaMobile(
            $request->user(),
            $validated['montant'],
            $validated['numero_payeur']
        );

        Log::info('deposerViaMobile result', ['result' => $result]);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function deposerViaCodeCaisse(Request $request): JsonResponse
    {
        Log::info('deposerViaCodeCaisse called', ['user_id' => $request->user()->id, 'payload' => $request->all()]);

        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        $result = $this->paiementService->deposerViaCodeCaisse(
            $request->user(),
            $validated['code']
        );

        Log::info('deposerViaCodeCaisse result', ['result' => $result]);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function transferer(Request $request): JsonResponse
    {
        Log::info('transferer called', ['user_id' => $request->user()->id, 'payload' => $request->all()]);

        $validated = $request->validate([
            'telephone_destinataire' => 'required|string',
            'montant' => 'required|numeric|min:1'
        ]);

        $result = $this->paiementService->transferer(
            $request->user(),
            $validated['telephone_destinataire'],
            $validated['montant']
        );

        Log::info('transferer result', ['result' => $result]);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function rechercherDestinataire(Request $request): JsonResponse
    {
        Log::info('rechercherDestinataire called', ['payload' => $request->all()]);

        $validated = $request->validate([
            'telephone' => 'required|string'
        ]);

        $result = $this->paiementService->rechercherDestinataire($validated['telephone']);

        Log::info('rechercherDestinataire result', ['result' => $result]);

        return response()->json($result, $result['success'] ? 200 : 404);
    }

    public function payerFrais(Request $request): JsonResponse
    {
        Log::info('payerFrais called', ['user_id' => $request->user()->id, 'payload' => $request->all()]);

        $validated = $request->validate([
            'type_frais' => 'required|in:formation,inscription,examen_blanc,examen'
        ]);

        $result = $this->paiementService->payerFrais(
            $request->user(),
            $validated['type_frais']
        );

        Log::info('payerFrais result', ['result' => $result]);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function getStatusFrais(Request $request): JsonResponse
    {
        Log::info('getStatusFrais called', ['user_id' => $request->user()->id]);

        $result = $this->paiementService->getStatusFrais($request->user());

        Log::info('getStatusFrais result', ['result' => $result]);

        return response()->json($result);
    }

    public function getHistorique(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 20);

        Log::info('getHistorique called', ['user_id' => $request->user()->id, 'limit' => $limit]);

        $result = $this->paiementService->getHistorique($request->user(), $limit);

        Log::info('getHistorique result', ['result_count' => count($result)]);

        return response()->json($result);
    }

    public function webhook(Request $request): JsonResponse
    {
        $data = $request->all();
        Log::info('webhook called', ['payload' => $data]);

        $result = $this->paiementService->handleWebhook($data);

        Log::info('webhook result', ['result' => $result]);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    public function endPayment()
    {
        Log::info('endPayment view accessed');
        return view('end_payment');
    }
}
