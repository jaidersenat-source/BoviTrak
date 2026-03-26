<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_reproductive_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                  ->constrained('animals')
                  ->cascadeOnDelete();

            // ── Palpación ──────────────────────────────────────────
            $table->boolean('palpacion')->default(false);
            $table->date('fecha_palpacion')->nullable();
            $table->text('observaciones_palpacion')->nullable();

            // ── Dosis Reproductiva ─────────────────────────────────
            $table->string('dosis_reproductiva')->nullable();
            $table->date('fecha_dosis')->nullable();

            // ── Proceso Reproductivo ───────────────────────────────
            $table->enum('tipo_proceso', ['embrion', 'inseminacion', 'monta_natural'])->nullable();
            $table->date('fecha_prenez')->nullable();

            // ── Nacimiento ─────────────────────────────────────────
            $table->date('fecha_estimada_parto')->nullable();

            // ── Generales ──────────────────────────────────────────
            $table->text('observaciones')->nullable();
            $table->foreignId('registrado_por')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_reproductive_records');
    }
};