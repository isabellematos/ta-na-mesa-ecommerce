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
        // Adiciona a coluna 'imagemPerfil'
        Schema::table('users', function (Blueprint $table) {
            // Define a coluna 'imagemPerfil' como uma string que pode ser nula
            // pois nem todo usuário pode ter uma imagem de perfil imediatamente.
            $table->string('imagemPerfil')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a coluna 'imagemPerfil' em caso de rollback
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('imagemPerfil');
        });
    }
};
