<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutoEcole\AuthController;
use App\Http\Controllers\Api\AutoEcole\PaiementController;
use App\Http\Controllers\Api\AutoEcole\CoursController;
use App\Http\Controllers\Api\AutoEcole\ParrainageController;
use App\Http\Controllers\Api\AutoEcole\SessionController;
use App\Http\Controllers\Api\AutoEcole\DashboardController;
use App\Http\Controllers\Api\AutoEcole\CniController;
use App\Http\Controllers\Admin\CniController2;


Route::get('/sessions', [SessionController::class, 'index']);
Route::get('/centres-examen', [SessionController::class, 'centresExamen']);
Route::get('/jours-pratique', [SessionController::class, 'joursPratique']);
Route::get('/lieux-pratique', [SessionController::class, 'lieuxPratique']);


//test
Route::get('/test', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'API fonctionne correctement 🚀',
        'timestamp' => now(),
    ]);
});


Route::post('/otp/email/envoyer',  [AuthController::class, 'envoyerOtpEmail']);
Route::post('/otp/email/verifier', [AuthController::class, 'verifierOtpEmail']);

// Routes publiques
Route::post('/inscription', [AuthController::class, 'inscription']);
Route::post('/connexion', [AuthController::class, 'connexion']);

 // OTP Twilio (NOUVEAU)
Route::post('/otp/envoyer',  [AuthController::class, 'envoyerOtp']);
Route::post('/otp/verifier', [AuthController::class, 'verifierOtp']);

// Social login Firebase (NOUVEAU)
Route::post('/social-login', [AuthController::class, 'socialLogin']);


// Code de parrainage par défaut
Route::get('/code-parrainage-defaut', [AuthController::class, 'codeParrainageDefaut']);

// Configuration générale
Route::get('/configuration', [AuthController::class, 'configuration']);

// routes/api.php (ajoutez ces lignes à la fin ou dans le groupe approprié)
Route::post('/webhook/payment', [PaiementController::class, 'webhook']);
Route::get('/end_payment', [PaiementController::class, 'endPayment']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/deconnexion',            [AuthController::class, 'deconnexion']);
        Route::get('/profil',                  [AuthController::class, 'profil']);
        Route::put('/profil',                  [AuthController::class, 'mettreAJourProfil']);
        Route::post('/profil/completer',       [AuthController::class, 'completerProfilSocial']); // NOUVEAU
        Route::get('/dashboard', [DashboardController::class, 'index']);


    // Statut CNI de l'utilisateur
Route::get('/cni', [CniController::class, 'index']);

// Upload recto ou verso (multipart/form-data: face, image)
Route::post('/cni/upload', [CniController::class, 'upload']);

// Supprimer une face
Route::delete('/cni/{face}', [CniController::class, 'supprimer']);


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

Route::get('/cours/chapitre/{chapitreId}/quiz', [CoursController::class, 'getQuizByChapitre']);
Route::post('/cours/chapitre/{chapitreId}/quiz', [CoursController::class, 'soumettreQuizByChapitre']);


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


    Route::delete('/compte/supprimer', [AuthController::class, 'supprimerCompte']);
    
});


