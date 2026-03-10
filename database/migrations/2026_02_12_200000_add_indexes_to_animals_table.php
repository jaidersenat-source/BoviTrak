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
        Schema::table('animals', function (Blueprint $table) {
            // Índices para mejorar el rendimiento de búsquedas
            $table->index('codigo_nfc', 'idx_animals_codigo_nfc');
            $table->index('raza', 'idx_animals_raza');
            $table->index('nombre', 'idx_animals_nombre');
            $table->index('public_token', 'idx_animals_public_token');
            $table->index('created_at', 'idx_animals_created_at');
            
            // Índice compuesto para búsquedas múltiples
            $table->index(['raza', 'sexo'], 'idx_animals_raza_sexo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropIndex('idx_animals_codigo_nfc');
            $table->dropIndex('idx_animals_raza');
            $table->dropIndex('idx_animals_nombre');
            $table->dropIndex('idx_animals_public_token');
            $table->dropIndex('idx_animals_created_at');
            $table->dropIndex('idx_animals_raza_sexo');
        });
    }
};
