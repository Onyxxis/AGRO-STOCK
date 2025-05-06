<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modifier la valeur par défaut de la colonne 'role'
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'agriculteur'");

        // Mettre à jour tous les utilisateurs ayant 'user' comme rôle
        DB::table('users')
            ->where('role', 'user')
            ->update(['role' => 'agriculteur']);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Remettre la valeur par défaut à 'user'
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");

        // Si tu veux revenir à 'user' pour ceux qui ont 'agriculteur'
        DB::table('users')
            ->where('role', 'agriculteur')
            ->update(['role' => 'user']);
    }
};
