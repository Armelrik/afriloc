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
        Schema::create('historique_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoteur_id')->constrained('promoteurs')->onDelete('cascade');
            $table->foreignId('effectue_par_id')->constrained('users')->onDelete('cascade');
            $table->enum('action', ['SOUMIS', 'APPROUVE', 'REJETE', 'COMPLEMENT_DEMANDE', 'SUSPENDU', 'REACTIVE']);
            $table->timestamp('date_action');
            $table->text('details')->nullable();
            $table->string('ancien_statut')->nullable();
            $table->string('nouveau_statut')->nullable();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('promoteur_id');
            $table->index('date_action');
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_validations');
    }
};
