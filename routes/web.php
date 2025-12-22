<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AutoEcole\DashboardController;
use App\Http\Controllers\Admin\AutoEcole\UserController;
use App\Http\Controllers\Admin\AutoEcole\SessionController;
use App\Http\Controllers\Admin\AutoEcole\ModuleController;
use App\Http\Controllers\Admin\AutoEcole\ChapitreController;
use App\Http\Controllers\Admin\AutoEcole\LeconController;
use App\Http\Controllers\Admin\AutoEcole\QuizController;
use App\Http\Controllers\Admin\AutoEcole\PaiementController;
use App\Http\Controllers\Admin\AutoEcole\CodeCaisseController;
use App\Http\Controllers\Admin\AutoEcole\ConfigController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

// Mise à jour des informations du profil
Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

// Suppression du compte utilisateur
Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

Route::prefix('admin/auto-ecole')->name('admin.auto-ecole.')->middleware(['web', 'auth'])->group(function () {

    // Utilisateurs
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/frais-status', [UserController::class, 'updateFraisStatus'])->name('users.frais-status');
    Route::post('users/{user}/solde', [UserController::class, 'updateSolde'])->name('users.solde');

    // Sessions
    Route::resource('sessions', SessionController::class);
    Route::post('sessions/{session}/toggle-active', [SessionController::class, 'toggleActive'])->name('sessions.toggle-active');

    // Modules
    Route::resource('modules', ModuleController::class);
    Route::post('modules/reorder', [ModuleController::class, 'reorder'])->name('modules.reorder');

    // Chapitres
    Route::resource('chapitres', ChapitreController::class);

    // Leçons
    Route::resource('lecons', LeconController::class);

    // Quiz
    Route::resource('quiz', QuizController::class);
    Route::post('quiz/{quiz}/questions', [QuizController::class, 'addQuestion'])->name('quiz.add-question');
    Route::get('quiz/questions/{question}/edit', [QuizController::class, 'editQuestion'])->name('questions.edit');
    Route::put('quiz/questions/{question}', [QuizController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('quiz/questions/{question}', [QuizController::class, 'deleteQuestion'])->name('questions.delete');
    Route::post('quiz/{quiz}/duplicate', [QuizController::class, 'duplicate'])
            ->name('quiz.duplicate');
    // Paiements
    Route::get('paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::get('paiements/rapport', [PaiementController::class, 'rapportMensuel'])->name('paiements.rapport');
    Route::get('paiements/{paiement}', [PaiementController::class, 'show'])->name('paiements.show');
    Route::post('paiements/depot-manuel', [PaiementController::class, 'ajouterDepotManuel'])->name('paiements.depot-manuel');

    // Codes caisse
    Route::resource('codes-caisse', CodeCaisseController::class)->except(['edit', 'update']);
    Route::post('codes-caisse/generer-masse', [CodeCaisseController::class, 'genererEnMasse'])->name('codes-caisse.generer-masse');
    Route::get('codes-caisse-export', [CodeCaisseController::class, 'export'])->name('codes-caisse.export');

    // Configuration
    Route::get('config', [ConfigController::class, 'index'])->name('config.index');
    Route::post('config/frais', [ConfigController::class, 'updateFrais'])->name('config.frais');
    Route::post('config/general', [ConfigController::class, 'updateGeneral'])->name('config.general');

    // Centres d'examen - ROUTES CORRIGÉES
    Route::post('config/centres-examen', [ConfigController::class, 'storeCentreExamen'])->name('config.store-centre-examen');
    Route::put('config/centres-examen/{centreExamen}', [ConfigController::class, 'updateCentreExamen'])->name('config.update-centre-examen');
    Route::delete('config/centres-examen/{centreExamen}', [ConfigController::class, 'destroyCentreExamen'])->name('config.destroy-centre-examen');

    // Lieux de pratique - ROUTES CORRIGÉES
    Route::post('config/lieux-pratique', [ConfigController::class, 'storeLieuPratique'])->name('config.store-lieu-pratique');
    Route::put('config/lieux-pratique/{lieuPratique}', [ConfigController::class, 'updateLieuPratique'])->name('config.update-lieu-pratique');
    Route::delete('config/lieux-pratique/{lieuPratique}', [ConfigController::class, 'destroyLieuPratique'])->name('config.destroy-lieu-pratique');

    // Jours de pratique - ROUTES CORRIGÉES
    Route::post('config/jours-pratique', [ConfigController::class, 'storeJourPratique'])->name('config.store-jour-pratique');
    Route::put('config/jours-pratique/{jourPratique}', [ConfigController::class, 'updateJourPratique'])->name('config.update-jour-pratique');
    Route::delete('config/jours-pratique/{jourPratique}', [ConfigController::class, 'destroyJourPratique'])->name('config.destroy-jour-pratique');
});

require __DIR__.'/auth.php';
