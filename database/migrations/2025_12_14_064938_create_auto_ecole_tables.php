<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        // Configuration générale
        Schema::create('config_paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('frais_formation', 10, 2)->default(40000);
            $table->decimal('frais_inscription', 10, 2)->default(10000);
            $table->decimal('frais_examen_blanc', 10, 2)->default(12500);
            $table->decimal('frais_examen', 10, 2)->default(30000);
            $table->decimal('depot_minimum', 10, 2)->default(10000);
            $table->string('code_parrainage_defaut')->nullable();
            $table->string('whatsapp_support')->nullable();
            $table->string('lien_telechargement_app')->nullable();
            $table->timestamps();
        });

        // Sessions d'examen
        Schema::create('sessions1', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->date('date_communication_enregistrement')->nullable();
            $table->date('date_enregistrement_vague1')->nullable();
            $table->date('date_enregistrement_vague2')->nullable();
            $table->date('date_transfert_reconduction')->nullable();
            $table->date('date_depot_departemental')->nullable();
            $table->date('date_depot_regional')->nullable();
            $table->date('date_examen_theorique')->nullable();
            $table->date('date_examen_pratique')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Centres d'examen
        Schema::create('centres_examen', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Lieux de pratique
        Schema::create('lieux_pratique', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Jours de pratique disponibles
        Schema::create('jours_pratique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lieu_pratique_id')->constrained('lieux_pratique')->onDelete('cascade');
            $table->enum('jour', ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Utilisateurs auto-école
        Schema::create('auto_ecole_users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone')->unique();
            $table->string('password');
            $table->date('date_naissance')->nullable();
            $table->string('quartier')->nullable();
            $table->enum('type_permis', ['permis_a', 'permis_b', 'permis_t'])->default('permis_b');
            $table->enum('type_cours', ['en_ligne', 'presentiel', 'les_deux'])->default('en_ligne');
            $table->enum('vague', ['1', '2'])->default('1');
            $table->foreignId('session_id')->nullable()->constrained('sessions1')->nullOnDelete();
            $table->foreignId('centre_examen_id')->nullable()->constrained('centres_examen')->nullOnDelete();
            $table->string('code_parrainage')->unique();
            $table->foreignId('parrain_id')->nullable()->constrained('auto_ecole_users')->nullOnDelete();
            $table->integer('niveau_parrainage')->default(-1); // -1 = pas encore de niveau
            $table->decimal('solde', 12, 2)->default(0);
            $table->boolean('validated')->default(false);
            $table->boolean('cours_debloques')->default(false);

            // Status des paiements
            $table->enum('status_frais_formation', ['non_paye', 'paye', 'dispense'])->default('non_paye');
            $table->enum('status_frais_inscription', ['non_paye', 'paye', 'dispense'])->default('non_paye');
            $table->enum('status_examen_blanc', ['non_paye', 'paye', 'dispense'])->default('non_paye');
            $table->enum('status_frais_examen', ['non_paye', 'paye', 'dispense'])->default('non_paye');

            $table->text('description_paiement_formation')->nullable();
            $table->text('description_paiement_inscription')->nullable();
            $table->text('description_paiement_examen_blanc')->nullable();
            $table->text('description_paiement_examen')->nullable();

            $table->timestamp('premier_depot_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Dans votre migration, remplacer la table user_jours_pratique par :
        Schema::create('user_lieux_pratique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('auto_ecole_users')->onDelete('cascade');
            $table->foreignId('lieu_pratique_id')->constrained('lieux_pratique')->onDelete('cascade');
            $table->timestamps();
        });

        // Filleuls (pour traçabilité)
        Schema::create('filleuls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parrain_id')->constrained('auto_ecole_users')->onDelete('cascade');
            $table->foreignId('filleul_id')->constrained('auto_ecole_users')->onDelete('cascade');
            $table->integer('niveau_parrain_lors_ajout')->default(0);
            $table->timestamps();
        });

        // Modules de cours
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->enum('type', ['theorique', 'pratique']);
            $table->enum('type_permis', ['permis_a', 'permis_b', 'tous'])->default('tous');
            $table->integer('ordre')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Chapitres
        Schema::create('chapitres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('nom');
            $table->text('description')->nullable();
            $table->integer('ordre')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Leçons
        Schema::create('lecons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapitre_id')->constrained('chapitres')->onDelete('cascade');
            $table->string('titre');
            $table->text('contenu_texte')->nullable();
            $table->string('url_web')->nullable(); // Pour cours théorique (webview)
            $table->string('url_video')->nullable(); // Pour cours pratique
            $table->integer('ordre')->default(0);
            $table->integer('duree_minutes')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Quiz
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapitre_id')->constrained('chapitres')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('note_passage')->default(12); // sur 20
            $table->integer('duree_minutes')->default(30);
            $table->integer('ordre')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Questions de quiz
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quiz')->onDelete('cascade');
            $table->text('enonce');
            $table->string('image_url')->nullable();
            $table->enum('type', ['qcm', 'vrai_faux']);
            $table->text('explication')->nullable(); // Pour la correction
            $table->integer('ordre')->default(0);
            $table->integer('points')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Réponses aux questions
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('texte');
            $table->boolean('est_correcte')->default(false);
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });

        // Progression des leçons par utilisateur
        Schema::create('progression_lecons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('auto_ecole_users')->onDelete('cascade');
            $table->foreignId('lecon_id')->constrained('lecons')->onDelete('cascade');
            $table->boolean('completee')->default(false);
            $table->timestamp('date_completion')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'lecon_id']);
        });

        // Résultats des quiz
        Schema::create('resultats_quiz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('auto_ecole_users')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quiz')->onDelete('cascade');
            $table->decimal('note', 5, 2);
            $table->integer('total_questions');
            $table->integer('bonnes_reponses');
            $table->boolean('reussi')->default(false);
            $table->json('reponses_utilisateur')->nullable();
            $table->integer('tentative')->default(1);
            $table->timestamps();
        });

        // Paiements
Schema::create('auto_ecole_paiements', function (Blueprint $table) {
    $table->id();

    // Relations
    $table->foreignId('user_id')
        ->constrained('auto_ecole_users')
        ->cascadeOnDelete();

    $table->foreignId('destinataire_id')
        ->nullable()
        ->constrained('auto_ecole_users')
        ->nullOnDelete();

    // Types & méthodes
    $table->string('type')->nullable(); // depot, retrait, transfert_entrant, transfert_sortant, paiement_frais
    $table->string('type_paiement')->nullable(); // duplication volontaire (compatibilité logique)
    $table->string('methode')->nullable(); // mobile_money, code_caisse, transfert, systeme
    $table->string('methode_paiement')->nullable();

    // Montants & soldes
    $table->decimal('montant', 12, 2);
    $table->decimal('solde_avant', 12, 2)->default(0);
    $table->decimal('solde_apres', 12, 2)->default(0);

    // Références & transactions
    $table->string('transaction_id')->nullable()->index();
    $table->string('reference')->unique();
    $table->string('transaction_externe')->nullable();
    $table->string('token_pay')->nullable();

    // Tranches & frais
    $table->string('tranche')->nullable();
    $table->string('frais_type')->nullable(); // formation, inscription, examen_blanc, examen

    // Statuts (double gestion pour compatibilité)
    $table->string('statut')->nullable();
    $table->string('status')->default('en_attente');

    // Informations diverses
    $table->text('description')->nullable();
    $table->text('notes')->nullable();
    $table->dateTime('date_paiement')->nullable();

    $table->timestamps();
});


        // Codes caisse
        Schema::create('codes_caisse', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('montant', 12, 2);
            $table->foreignId('user_id')->nullable()->constrained('auto_ecole_users')->nullOnDelete();
            $table->boolean('utilise')->default(false);
            $table->timestamp('utilise_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->foreignId('cree_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Notifications
        Schema::create('auto_ecole_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('auto_ecole_users')->onDelete('cascade');
            $table->string('titre');
            $table->text('message');
            $table->enum('type', ['info', 'succes', 'alerte', 'paiement', 'cours', 'parrainage']);
            $table->boolean('lu')->default(false);
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auto_ecole_notifications');
        Schema::dropIfExists('codes_caisse');
        Schema::dropIfExists('auto_ecole_paiements');
        Schema::dropIfExists('resultats_quiz');
        Schema::dropIfExists('progression_lecons');
        Schema::dropIfExists('reponses');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quiz');
        Schema::dropIfExists('lecons');
        Schema::dropIfExists('chapitres');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('filleuls');
        Schema::dropIfExists('user_lieux_pratique');
        Schema::dropIfExists('auto_ecole_users');
        Schema::dropIfExists('jours_pratique');
        Schema::dropIfExists('lieux_pratique');
        Schema::dropIfExists('centres_examen');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('config_paiements');
    }
};
