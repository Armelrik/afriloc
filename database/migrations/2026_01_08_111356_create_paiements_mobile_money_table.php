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
        Schema::create('paiements_mobile_money', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paiement_id')->unique()->constrained('paiements')->onDelete('cascade');
            $table->enum('operateur', ['MOOV', 'ORANGE', 'MTN', 'TELECEL', 'AUTRE'])->default('MOOV');
            $table->string('numero_telephone');
            $table->string('code_transaction')->unique()->nullable();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('paiement_id');
            $table->index('code_transaction');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements_mobile_money');
    }
};
