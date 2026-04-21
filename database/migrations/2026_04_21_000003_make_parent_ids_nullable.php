<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('animal_descendances', function (Blueprint $table) {
            // Drop existing foreign keys if present
            try {
                $table->dropForeign(['padre_id']);
            } catch (\Exception $e) {
                // ignore if not exists
            }
            try {
                $table->dropForeign(['madre_id']);
            } catch (\Exception $e) {
                // ignore if not exists
            }
        });

        // Alter columns to be nullable using raw statements (compatible without doctrine/dbal)
        DB::statement('ALTER TABLE `animal_descendances` MODIFY `padre_id` BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE `animal_descendances` MODIFY `madre_id` BIGINT UNSIGNED NULL');

        // Recreate foreign keys
        Schema::table('animal_descendances', function (Blueprint $table) {
            $table->foreign('padre_id')->references('id')->on('animals')->onDelete('restrict');
            $table->foreign('madre_id')->references('id')->on('animals')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop foreign keys
        Schema::table('animal_descendances', function (Blueprint $table) {
            try {
                $table->dropForeign(['padre_id']);
            } catch (\Exception $e) {
            }
            try {
                $table->dropForeign(['madre_id']);
            } catch (\Exception $e) {
            }
        });

        // set columns back to NOT NULL
        DB::statement('ALTER TABLE `animal_descendances` MODIFY `padre_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE `animal_descendances` MODIFY `madre_id` BIGINT UNSIGNED NOT NULL');

        // recreate foreign keys
        Schema::table('animal_descendances', function (Blueprint $table) {
            $table->foreign('padre_id')->references('id')->on('animals')->onDelete('restrict');
            $table->foreign('madre_id')->references('id')->on('animals')->onDelete('restrict');
        });
    }
};
