<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
        $table->enum('type_transaction', ['Vente', 'Distribution']);
        $table->date('date_transaction');
        $table->float('quantite');
        $table->float('prix_unitaire')->nullable(); // Obligatoire uniquement pour les ventes
        $table->string('destinataire'); // Acheteur ou bénéficiaire
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
