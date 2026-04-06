<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->date('fecha_roceria')->nullable()->after('observaciones');
            $table->date('fecha_inicio_ocupacion')->nullable()->after('fecha_roceria');
            $table->integer('jornales')->nullable()->after('fecha_inicio_ocupacion');
        });
    }

    public function down()
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropColumn(['fecha_roceria', 'fecha_inicio_ocupacion', 'jornales']);
        });
    }
};
