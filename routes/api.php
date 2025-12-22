<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutoEcole\AuthController;
use App\Http\Controllers\Api\AutoEcole\PaiementController;
use App\Http\Controllers\Api\AutoEcole\CoursController;
use App\Http\Controllers\Api\AutoEcole\ParrainageController;
use App\Http\Controllers\Api\AutoEcole\SessionController;
use App\Http\Controllers\Api\AutoEcole\DashboardController;

//test
Route::get('/test', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'API fonctionne correctement 🚀',
        'timestamp' => now(),
    ]);
});
// Routes publiques
Route::post('/inscription', [AuthController::class, 'inscription']);
Route::post('/connexion', [AuthController::class, 'connexion']);

Route::get('/sessions', [SessionController::class, 'index']);
Route::get('/centres-examen', [SessionController::class, 'centresExamen']);
Route::get('/jours-pratique', [SessionController::class, 'joursPratique']);
// Ajout dans le fichier de routes (par exemple, api.php ou un fichier routes dédié)
Route::get('/lieux-pratique', [SessionController::class, 'lieuxPratique']);

// Code de parrainage par défaut
Route::get('/code-parrainage-defaut', [AuthController::class, 'codeParrainageDefaut']);

// Configuration générale
Route::get('/configuration', [AuthController::class, 'configuration']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/deconnexion', [AuthController::class, 'deconnexion']);
    // Profil
    Route::get('/profil', [AuthController::class, 'profil']);
    Route::put('/profil/update', [AuthController::class, 'mettreAJourProfil']);
    Route::get('/dashboard', [DashboardController::class, 'index']);


    // =============================
    // DÉPÔTS
    // =============================

    // Dépôt via Mobile Money
    Route::post('/depot/mobile', [PaiementController::class, 'deposerViaMobile']);
    // body: { montant, numero_payeur }

    // Dépôt via Code Caisse
    Route::post('/depot/code-caisse', [PaiementController::class, 'deposerViaCodeCaisse']);
    // body: { code }

    // =============================
    // TRANSFERTS
    // =============================

    // Rechercher un destinataire par téléphone
    Route::get('/transfert/rechercher', [PaiementController::class, 'rechercherDestinataire']);
    // query: ?telephone=6XXXXXXXX

    // Effectuer un transfert
    Route::post('/transfert', [PaiementController::class, 'transferer']);
    // body: { telephone, montant }

    // =============================
    // PAIEMENT DES FRAIS
    // =============================

    // Payer un type de frais (formation, inscription, examen_blanc, examen)
    Route::post('/frais/payer', [PaiementController::class, 'payerFrais']);
    // body: { type_frais }

    // Obtenir le statut des frais
    Route::get('/frais/status', [PaiementController::class, 'getStatusFrais']);

    // =============================
    // HISTORIQUE
    // =============================

    // Historique des paiements
    Route::get('/historique', [PaiementController::class, 'getHistorique']);
    // query optionnel: ?limit=20


// Cours théoriques
Route::get('/cours/theorique', [CoursController::class, 'getCoursTheorique']);

// Cours pratiques
Route::get('/cours/pratique', [CoursController::class, 'getCoursPratique']);

// Détail d'une leçon
Route::get('/cours/lecon/{id}', [CoursController::class, 'getLecon']);

// Marquer une leçon comme terminée
Route::post('/cours/lecon/{id}/terminer', [CoursController::class, 'marquerLeconTerminee']);

// Récupérer un quiz lié à un chapitre
Route::get('/cours/chapitre/{id}/quiz', [CoursController::class, 'getQuiz']);

// Soumettre un quiz
Route::post('/cours/chapitre/{id}/quiz', [CoursController::class, 'soumettreQuiz']);

// Progression globale (théorique + pratique + examen)
Route::get('/cours/progression', [CoursController::class, 'getProgression']);

     // Infos générales du parrainage (code, gains, stats, etc.)
    Route::get('/parrainage', [ParrainageController::class, 'index']);

    // Liste des filleuls directs
    Route::get('/parrainage/filleuls', [ParrainageController::class, 'getListeFilleuls']);

    // Message à partager (WhatsApp, SMS, réseaux sociaux…)
    Route::get('/parrainage/message', [ParrainageController::class, 'getMessagePartage']);

    // Arbre de parrainage (avec profondeur optionnelle)
    // Exemple : /parrainage/arbre?profondeur=4
    Route::get('/parrainage/arbre', [ParrainageController::class, 'getArbre']);

});
