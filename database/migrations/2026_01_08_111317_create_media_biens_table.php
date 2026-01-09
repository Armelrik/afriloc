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
        Schema::create('media_biens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_id')->constrained('biens')->onDelete('cascade');
            $table->enum('type_media', ['IMAGE', 'VIDEO'])->default('IMAGE');
            $table->string('url_media');
            $table->text('description')->nullable();
            $table->integer('ordre')->default(0);
            $table->date('date_ajout');
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('bien_id');
            $table->index('type_media');
            $table->index('ordre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_biens');
    }
};
