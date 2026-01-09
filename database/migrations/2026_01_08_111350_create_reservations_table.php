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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bien_id')->constrained('biens')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nombre_personnes')->default(1);
            $table->decimal('montant_total', 10, 2);
            $table->enum('statut', ['EN_ATTENTE', 'CONFIRME', 'ANNULE', 'TERMINE'])->default('EN_ATTENTE');
            $table->text('commentaires')->nullable();
            $table->timestamp('date_reservation')->useCurrent();
            $table->timestamp('date_confirmation')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('client_id');
            $table->index('bien_id');
            $table->index('statut');
            $table->index('date_debut');
            $table->index('date_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
