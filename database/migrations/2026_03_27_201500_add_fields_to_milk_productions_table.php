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
        Schema::table('milk_productions', function (Blueprint $table) {
            $table->string('shift', 20)->nullable()->after('liters');
            $table->integer('somatic_cells')->nullable()->after('shift');
            $table->boolean('mastitis')->default(false)->after('somatic_cells');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('milk_productions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['shift', 'somatic_cells', 'mastitis', 'user_id']);
        });
    }
};
