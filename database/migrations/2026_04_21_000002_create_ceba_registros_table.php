<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ceba_registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ceba_id')->index();
            $table->dateTime('medido_el')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('tipo_alimento')->nullable();
            $table->decimal('cantidad_alimento', 8, 2)->nullable()->comment('kg suministrados');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('ceba_id')->references('id')->on('cebas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ceba_registros');
    }
};
