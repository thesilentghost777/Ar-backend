<?php

namespace App\Http\Controllers\Api\AutoEcole;

use App\Http\Controllers\Controller;
use App\Models\UserCni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CniController extends Controller
{
    /**
     * GET /cni
     * Retourne le statut CNI de l'utilisateur connecté.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $cni  = UserCni::where('user_id', $user->id)->first();

        if (!$cni) {
            return response()->json([
                'success'       => true,
                'cni'           => null,
                'statut'        => 'non_soumis',
                'cni_recto_url' => null,
                'cni_verso_url' => null,
            ]);
        }

        return response()->json([
            'success'       => true,
            'cni'           => [
                'id'            => $cni->id,
                'statut'        => $cni->statut,
                'motif_rejet'   => $cni->motif_rejet,
                'cni_recto_url' => $cni->cni_recto_url,
                'cni_verso_url' => $cni->cni_verso_url,
                'soumis_at'     => $cni->soumis_at?->toIso8601String(),
                'traite_at'     => $cni->traite_at?->toIso8601String(),
                'complet'       => $cni->estComplet(),
            ],
        ]);
    }

    /**
     * POST /cni/upload
     * Upload d'une image CNI (recto ou verso).
     *
     * Body multipart/form-data:
     *   - face  : 'recto' | 'verso'
     *   - image : fichier image
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'face'  => 'required|in:recto,verso',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240', // max 10 Mo
        ], [
            'face.required'   => 'Veuillez préciser la face (recto ou verso).',
            'face.in'         => 'La face doit être "recto" ou "verso".',
            'image.required'  => 'Veuillez fournir une image.',
            'image.image'     => 'Le fichier doit être une image.',
            'image.mimes'     => 'Formats acceptés : jpeg, jpg, png, webp.',
            'image.max'       => 'La taille maximale est 10 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        $face = $request->input('face'); // 'recto' ou 'verso'

        // Récupère ou crée l'entrée CNI
        $cni = UserCni::firstOrNew(['user_id' => $user->id]);

        $column = "cni_{$face}_path"; // cni_recto_path ou cni_verso_path

        // Supprime l'ancienne image si elle existe
        if (!empty($cni->$column)) {
            Storage::disk('public')->delete($cni->$column);
        }

        // Sauvegarde la nouvelle image
        $path = $request->file('image')->store("cni/{$user->id}", 'public');

        $cni->$column = $path;

        // Si les deux faces sont présentes, marquer comme soumis
        if ($cni->estComplet() && is_null($cni->soumis_at)) {
            $cni->soumis_at = now();
            $cni->statut    = 'en_attente';
        }

        $cni->save();

        $urlAttribute = "cni_{$face}_url";

        return response()->json([
            'success' => true,
            'message' => ucfirst($face) . ' CNI enregistré avec succès.',
            'url'     => $cni->$urlAttribute,
            'complet' => $cni->estComplet(),
            'statut'  => $cni->statut,
        ]);
    }

    /**
     * DELETE /cni/{face}
     * Supprime l'image recto ou verso (uniquement si pas encore validé).
     */
    public function supprimer(Request $request, string $face): JsonResponse
    {
        if (!in_array($face, ['recto', 'verso'])) {
            return response()->json(['success' => false, 'message' => 'Face invalide.'], 422);
        }

        $user = Auth::user();
        $cni  = UserCni::where('user_id', $user->id)->first();

        if (!$cni) {
            return response()->json(['success' => false, 'message' => 'Aucun document CNI trouvé.'], 404);
        }

        if ($cni->statut === 'valide') {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer un document déjà validé.',
            ], 403);
        }

        $column = "cni_{$face}_path";

        if (!empty($cni->$column)) {
            Storage::disk('public')->delete($cni->$column);
            $cni->$column  = null;
            $cni->statut   = 'en_attente';
            $cni->soumis_at = null;
            $cni->save();
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst($face) . ' supprimé avec succès.',
        ]);
    }
}