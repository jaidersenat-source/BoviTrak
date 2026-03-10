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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('public_token')->unique();
            $table->string('codigo_nfc')->unique();
            $table->string('nombre')->nullable();
            $table->string('raza');
            $table->enum('sexo', ['macho', 'hembra']);
            $table->date('fecha_nacimiento')->nullable();
            $table->decimal('peso_aproximado', 8, 2)->nullable();
            $table->string('color')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('foto_boca')->nullable();
            $table->string('foto_general')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
