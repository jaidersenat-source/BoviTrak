<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                  ->constrained('animals')
                  ->cascadeOnDelete();

            // ── Sección 1: Lavado Antiparasitario ─────────────────
            $table->date('fecha_lavado')->nullable();
            $table->string('producto_lavado')->nullable();

            // ── Sección 2: Purgas ──────────────────────────────────
            $table->date('fecha_purga')->nullable();
            $table->string('tipo_purgante')->nullable();

            // ── Generales ──────────────────────────────────────────
            $table->text('observaciones')->nullable();
            $table->foreignId('aplicado_por')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_health_records');
    }
};