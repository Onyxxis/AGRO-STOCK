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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable(false);
            $table->string('type')->nullable(false);
            $table->float('quantite_recoltee')->nullable(false);
            $table->date('date_recolte')->nullable(false);
            $table->enum('statut', ['Stocké', 'Vendu', 'Distribué'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
