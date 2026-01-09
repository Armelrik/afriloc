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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paiement_id')->unique()->constrained('paiements')->onDelete('cascade');
            $table->foreignId('promoteur_id')->constrained('promoteurs')->onDelete('cascade');
            $table->decimal('pourcentage_plateforme', 5, 2)->default(10.00);
            $table->decimal('montant_commission', 10, 2);
            $table->decimal('montant_promoteur', 10, 2);
            $table->date('date_calcul');
            $table->boolean('est_transfere')->default(false);
            $table->timestamp('date_transfert')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('paiement_id');
            $table->index('promoteur_id');
            $table->index('est_transfere');
            $table->index('date_calcul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
