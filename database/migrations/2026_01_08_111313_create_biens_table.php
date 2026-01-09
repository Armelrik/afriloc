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
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoteur_id')->constrained('promoteurs')->onDelete('cascade');
            
            // Informations générales
            $table->string('titre');
            $table->text('description');
            $table->enum('type_bien', ['maison', 'appartement', 'terrain', 'bureau', 'local_commercial'])->default('appartement');
            $table->string('adresse');
            $table->string('ville');
            $table->string('quartier')->nullable();
            
            // Caractéristiques
            $table->decimal('superficie', 10, 2)->nullable();
            $table->integer('nombre_pieces')->nullable();
            $table->integer('nombre_chambres')->nullable();
            $table->integer('nombre_salles_bain')->nullable();
            
            // Prix
            $table->decimal('prix_location', 10, 2);
            $table->enum('frequence_location', ['quotidien', 'hebdomadaire', 'mensuel', 'annuel'])->default('mensuel');
            $table->decimal('depot_garantie', 10, 2)->default(0);
            $table->decimal('avance', 10, 2)->default(0);
            
            // Statut
            $table->enum('disponibilite', ['disponible', 'loue', 'reserve', 'indisponible'])->default('disponible');
            $table->enum('statut', ['brouillon', 'en_attente', 'publie', 'archive'])->default('brouillon');
            $table->boolean('est_publie')->default(false);
            
            // Dates
            $table->date('date_ajout');
            $table->timestamp('date_publication')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('promoteur_id');
            $table->index('type_bien');
            $table->index('ville');
            $table->index('disponibilite');
            $table->index('est_publie');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
