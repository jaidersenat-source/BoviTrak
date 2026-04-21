<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('animal_descendances', function (Blueprint $table) {
            $table->string('padre_nombre')->nullable()->after('padre_id');
            $table->string('padre_raza')->nullable()->after('padre_nombre');
            $table->string('madre_nombre')->nullable()->after('madre_id');
            $table->string('madre_raza')->nullable()->after('madre_nombre');
        });
    }

    public function down()
    {
        Schema::table('animal_descendances', function (Blueprint $table) {
            $table->dropColumn(['padre_nombre','padre_raza','madre_nombre','madre_raza']);
        });
    }
};
