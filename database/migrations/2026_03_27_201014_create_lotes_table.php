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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();

            $table->string('codigo')->unique();
            $table->string('nombre_pastura')->nullable();
            $table->text('banco_nutricional')->nullable();
            $table->integer('tiempo_ocupacion_dias')->nullable();
            $table->integer('tiempo_descanso_dias')->nullable();
            $table->text('aplicacion_abonos')->nullable();
            $table->decimal('area_ha', 8, 2)->nullable();
            $table->text('observaciones')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['codigo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
