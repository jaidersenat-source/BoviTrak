<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('animal_health_records', function (Blueprint $table) {
            $table->string('producto_lavado_secundario')->nullable()->after('producto_lavado');
        });
    }

    public function down()
    {
        Schema::table('animal_health_records', function (Blueprint $table) {
            $table->dropColumn('producto_lavado_secundario');
        });
    }
};
