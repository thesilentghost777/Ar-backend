<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\ParrainageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ParrainageController extends Controller
{
    public function __construct(private ParrainageService $parrainageService) {}

    public function index(Request $request): JsonResponse
    {
        $result = $this->parrainageService->getInfoParrainage($request->user('api'));
        return response()->json($result);
    }

    public function getListeFilleuls(Request $request): JsonResponse
    {
        $result = $this->parrainageService->getListeFilleuls($request->user('api'));
        return response()->json($result);
    }

    public function getMessagePartage(Request $request): JsonResponse
    {
        $result = $this->parrainageService->getMessagePartage($request->user('api'));
        return response()->json($result);
    }

    public function getArbre(Request $request): JsonResponse
    {
        $profondeur = $request->input('profondeur', 3);
        $result = $this->parrainageService->getArbreParrainage($request->user('api'), $profondeur);
        return response()->json($result);
    }
}