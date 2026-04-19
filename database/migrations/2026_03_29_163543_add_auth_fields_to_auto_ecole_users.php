<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── Étape 1 : rendre telephone nullable ──────────────────────
        Schema::table('auto_ecole_users', function (Blueprint $table) {
            $table->string('telephone')->nullable()->change();
        });

        // ── Étape 2 : ajouter les nouvelles colonnes ─────────────────
        Schema::table('auto_ecole_users', function (Blueprint $table) {
            $table->enum('auth_provider', ['telephone', 'email', 'google', 'apple'])
                  ->default('telephone')
                  ->after('password');

            $table->string('firebase_uid')->nullable()->unique()->after('auth_provider');

            $table->string('email')->nullable()->unique()->after('firebase_uid');

            $table->boolean('email_verified')->default(false)->after('email');
            $table->timestamp('email_verified_at')->nullable()->after('email_verified');

            $table->boolean('telephone_verified')->default(false)->after('email_verified_at');
            $table->timestamp('telephone_verified_at')->nullable()->after('telephone_verified');

            $table->boolean('profil_complet')->default(false)->after('telephone_verified_at');
        });

        // ── Étape 3 : corriger les données existantes ─────────────────
        DB::statement("
            UPDATE auto_ecole_users
            SET
                profil_complet        = true,
                telephone_verified    = true,
                telephone_verified_at = COALESCE(created_at, CURRENT_TIMESTAMP)
            WHERE
                telephone IS NOT NULL
                AND deleted_at IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('auto_ecole_users', function (Blueprint $table) {
            $table->dropColumn([
                'auth_provider',
                'firebase_uid',
                'email',
                'email_verified',
                'email_verified_at',
                'telephone_verified',
                'telephone_verified_at',
                'profil_complet',
            ]);
        });

        Schema::table('auto_ecole_users', function (Blueprint $table) {
            $table->string('telephone')->nullable(false)->change();
        });
    }
};