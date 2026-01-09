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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->unique()->constrained('reservations')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->enum('methode_paiement', ['MOBILE_MONEY', 'CARTE', 'ESPECES', 'VIREMENT'])->default('MOBILE_MONEY');
            $table->enum('statut', ['EN_ATTENTE', 'EN_COURS', 'VALIDE', 'ECHOUE', 'REMBOURSE'])->default('EN_ATTENTE');
            $table->timestamp('date_paiement')->nullable();
            $table->string('reference_transaction')->unique()->nullable();
            $table->string('numero_recu')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('reservation_id');
            $table->index('statut');
            $table->index('reference_transaction');
            $table->index('date_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
