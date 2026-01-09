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
        Schema::create('paiements_carte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paiement_id')->unique()->constrained('paiements')->onDelete('cascade');
            $table->string('numero_carte_masque')->comment('Ex: 1234****5678');
            $table->enum('type_carte', ['VISA', 'MASTERCARD', 'AMEX', 'AUTRE'])->default('VISA');
            $table->text('token_paiement')->nullable()->comment('Token chiffré pour le paiement');
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('paiement_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements_carte');
    }
};
