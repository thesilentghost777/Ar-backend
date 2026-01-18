<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Services\AutoEcole\CoursService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CoursController extends Controller
{
    public function __construct(private CoursService $coursService) {}

    public function getCoursTheorique(Request $request): JsonResponse
    {
        // ✅ Toujours retourner 200 car la structure est toujours accessible
        $result = $this->coursService->getStructureCours($request->user(), 'theorique');
        return response()->json($result, 200);
    }

    public function getCoursPratique(Request $request): JsonResponse
    {
        // ✅ Toujours retourner 200 car la structure est toujours accessible
        $result = $this->coursService->getStructureCours($request->user(), 'pratique');
        return response()->json($result, 200);
    }

    public function getLecon(Request $request, int $id): JsonResponse
    {
        $result = $this->coursService->getLecon($request->user(), $id);
        return response()->json($result, $result['success'] ? 200 : 403);
    }

    public function marquerLeconTerminee(Request $request, int $id): JsonResponse
    {
        $result = $this->coursService->marquerLeconTerminee($request->user(), $id);
        return response()->json($result, $result['success'] ? 200 : 403);
    }

    public function getQuiz(Request $request, int $id): JsonResponse
    {
        $result = $this->coursService->getQuiz($request->user(), $id);
        return response()->json($result, $result['success'] ? 200 : 403);
    }

    public function soumettreQuiz(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'reponses' => 'required|array'
        ]);

        $result = $this->coursService->soumettreQuiz(
            $request->user(),
            $id,
            $validated['reponses']
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function getProgression(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'theorique' => $this->coursService->calculerProgression($user, 'theorique'),
            'pratique' => $this->coursService->calculerProgression($user, 'pratique'),
            'pret_pour_examen' => $this->coursService->estPretPourExamen($user)
        ]);
    }

    public function getQuizByChapitre(Request $request, int $chapitreId): JsonResponse
{
    // Trouver le quiz actif du chapitre
    $quiz = \App\Models\Quiz::where('chapitre_id', $chapitreId)
                ->where('active', true)
                ->first();
    
    if (!$quiz) {
        return response()->json([
            'success' => false,
            'message' => 'Quiz non trouvé pour ce chapitre'
        ], 404);
    }
    
    // Utiliser le service existant avec l'ID du quiz
    $result = $this->coursService->getQuiz($request->user(), $quiz->id);
    return response()->json($result, $result['success'] ? 200 : 403);
}

public function soumettreQuizByChapitre(Request $request, int $chapitreId): JsonResponse
{
    // Trouver le quiz actif du chapitre
    $quiz = \App\Models\Quiz::where('chapitre_id', $chapitreId)
                ->where('active', true)
                ->first();
    
    if (!$quiz) {
        return response()->json([
            'success' => false,
            'message' => 'Quiz non trouvé pour ce chapitre'
        ], 404);
    }
    
    // Valider les réponses
    $validated = $request->validate([
        'reponses' => 'required|array'
    ]);
    
    // Utiliser le service existant avec l'ID du quiz
    $result = $this->coursService->soumettreQuiz(
        $request->user(),
        $quiz->id,
        $validated['reponses']
    );
    
    return response()->json($result, $result['success'] ? 200 : 422);
}

}