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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', [
                'VALIDATION',
                'RESERVATION',
                'PAIEMENT',
                'REJET',
                'COMPLEMENT_DEMANDE',
                'CONFIRMATION',
                'ANNULATION',
                'AUTRE'
            ])->default('AUTRE');
            $table->enum('canal', ['EMAIL', 'SMS', 'IN_APP'])->default('IN_APP');
            $table->text('contenu');
            $table->enum('priorite', ['BASSE', 'NORMALE', 'HAUTE', 'URGENTE'])->default('NORMALE');
            $table->timestamp('date_envoi')->useCurrent();
            $table->boolean('est_lue')->default(false);
            $table->timestamp('date_lecture')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('utilisateur_id');
            $table->index('type');
            $table->index('est_lue');
            $table->index('date_envoi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
