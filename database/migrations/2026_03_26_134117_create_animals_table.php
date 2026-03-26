<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->enum('proposito', ['carne', 'leche', 'doble_proposito'])->nullable();
            $table->enum('estado', ['activo', 'vendido', 'muerto'])->default('activo');
            $table->date('fecha_ingreso_hato')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn(['proposito', 'estado', 'fecha_ingreso_hato']);
        });
    }
};