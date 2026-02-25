<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_cni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('auto_ecole_users')
                  ->cascadeOnDelete();

            // Images CNI
            $table->string('cni_recto_path')->nullable();
            $table->string('cni_verso_path')->nullable();

            // Statut de validation
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->text('motif_rejet')->nullable();

            // Dates
            $table->timestamp('soumis_at')->nullable();
            $table->timestamp('traite_at')->nullable();
            $table->foreignId('traite_par')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cni');
    }
};