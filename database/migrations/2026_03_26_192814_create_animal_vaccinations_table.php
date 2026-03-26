<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                  ->constrained('animals')
                  ->cascadeOnDelete();
            $table->string('vacuna');
            $table->string('dosis');
            $table->date('fecha_vacunacion');
            $table->string('lote')->nullable();
            $table->foreignId('aplicado_por')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->text('nota')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_vaccinations');
    }
};