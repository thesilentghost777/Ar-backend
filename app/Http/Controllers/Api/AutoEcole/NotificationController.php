<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function index(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 50);
        $result = $this->notificationService->getNotifications($request->user(), $limit);
        return response()->json($result);
    }

    public function marquerCommeLue(Request $request, int $id): JsonResponse
    {
        $result = $this->notificationService->marquerCommeLue($request->user(), $id);
        return response()->json($result, $result['success'] ? 200 : 404);
    }

    public function marquerToutesCommeLues(Request $request): JsonResponse
    {
        $result = $this->notificationService->marquerToutesCommeLues($request->user());
        return response()->json($result);
    }

    public function supprimer(Request $request, int $id): JsonResponse
    {
        $result = $this->notificationService->supprimer($request->user(), $id);
        return response()->json($result, $result['success'] ? 200 : 404);
    }

    public function compterNonLues(Request $request): JsonResponse
    {
        $result = $this->notificationService->compterNonLues($request->user());
        return response()->json($result);
    }
}
