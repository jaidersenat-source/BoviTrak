<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajusta el enum `proposito` para incluir 'levante' y 'ceba'
        // Usamos DB::statement para soportar MySQL/ MariaDB
        DB::statement("ALTER TABLE animals MODIFY proposito ENUM('carne','leche','doble_proposito','levante','ceba') NULL;");
    }

    public function down(): void
    {
        // Revertir al enum anterior (sin levante/ceba)
        DB::statement("ALTER TABLE animals MODIFY proposito ENUM('carne','leche','doble_proposito') NULL;");
    }
};
