<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cebas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('animal_id')->index();
            $table->date('fecha_ingreso')->nullable();
            $table->decimal('peso_inicial', 8, 2)->nullable();
            $table->decimal('peso_objetivo', 8, 2)->nullable();
            $table->string('destino_lote')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cebas');
    }
};
