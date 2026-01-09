<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes_validation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoteur_id')->unique()->constrained('promoteurs')->onDelete('cascade');
            $table->enum('statut', ['EN_ATTENTE', 'VALIDE', 'INCOMPLET', 'REJETE'])->default('EN_ATTENTE');
            $table->date('date_demande');
            $table->timestamp('date_traitement')->nullable();
            $table->foreignId('traite_par_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('commentaires')->nullable();
            $table->text('motif_rejet')->nullable();
            $table->integer('score_completude')->default(0)->comment('Score de complétude du dossier (0-100)');
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('promoteur_id');
            $table->index('statut');
            $table->index('date_demande');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_validation');
    }
};
