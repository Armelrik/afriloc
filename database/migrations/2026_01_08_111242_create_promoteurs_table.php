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
        Schema::create('promoteurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            
            // Informations professionnelles
            $table->string('raison_sociale')->nullable();
            $table->string('type_structure')->nullable(); // Entreprise individuelle, SARL, SA, etc.
            $table->string('numero_siret')->unique()->nullable();
            $table->text('adresse_professionnelle')->nullable();
            $table->string('ville')->nullable();
            $table->text('description')->nullable();
            
            // Statut de validation
            $table->enum('statut', ['EN_ATTENTE', 'VALIDE', 'INCOMPLET', 'REJETE', 'SUSPENDU'])->default('EN_ATTENTE');
            $table->date('date_inscription')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->foreignId('valide_par')->nullable()->constrained('users')->onDelete('set null');
            $table->text('motif_rejet')->nullable();
            $table->text('commentaires_validation')->nullable();
            
            // Documents obligatoires (URLs vers fichiers stockés)
            $table->string('cnib_recto')->nullable();
            $table->string('cnib_verso')->nullable();
            $table->string('photo_promoteur')->nullable();
            $table->string('justificatif_domicile')->nullable();
            $table->string('registre_commerce')->nullable();
            $table->string('attestation_fiscale')->nullable();
            
            // Documents optionnels
            $table->string('certificat_propriete')->nullable();
            $table->string('assurance_rc')->nullable();
            
            // Statuts de vérification des documents
            $table->boolean('cnib_recto_verifie')->default(false);
            $table->boolean('cnib_verso_verifie')->default(false);
            $table->boolean('photo_verifiee')->default(false);
            $table->boolean('justificatif_verifie')->default(false);
            $table->boolean('registre_verifie')->default(false);
            $table->boolean('attestation_verifiee')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('user_id');
            $table->index('statut');
            $table->index('numero_siret');
            $table->index('date_inscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoteurs');
    }
};
