<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('animal_reproductive_records', function (Blueprint $table) {
            $table->date('fecha_insercion')->nullable()->after('tipo_proceso');
            $table->boolean('repalpacion')->default(false)->after('fecha_estimada_parto');
            $table->date('fecha_repalpacion')->nullable()->after('repalpacion');
            $table->boolean('repalpacion_efectiva')->nullable()->after('fecha_repalpacion');
        });
    }

    public function down()
    {
        Schema::table('animal_reproductive_records', function (Blueprint $table) {
            $table->dropColumn(['fecha_insercion', 'repalpacion', 'fecha_repalpacion', 'repalpacion_efectiva']);
        });
    }
};
