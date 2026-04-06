<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('milk_productions', function (Blueprint $table) {
            $table->boolean('coagulos')->default(false)->after('mastitis');
            $table->boolean('nipple_damage')->default(false)->after('coagulos');
            $table->text('nipple_damage_notes')->nullable()->after('nipple_damage');
            $table->boolean('duct_blockage')->default(false)->after('nipple_damage_notes');

            $table->string('treatment_dose')->nullable()->after('duct_blockage');
            $table->date('treatment_date')->nullable()->after('treatment_dose');
            $table->date('treatment_next_date')->nullable()->after('treatment_date');
            $table->integer('treatment_estimated_days')->nullable()->after('treatment_next_date');
        });
    }

    public function down(): void
    {
        Schema::table('milk_productions', function (Blueprint $table) {
            $table->dropColumn([
                'coagulos', 'nipple_damage', 'nipple_damage_notes', 'duct_blockage',
                'treatment_dose', 'treatment_date', 'treatment_next_date', 'treatment_estimated_days'
            ]);
        });
    }
};
