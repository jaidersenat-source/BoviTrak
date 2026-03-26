<?php
// database/migrations/xxxx_xx_xx_create_animal_weights_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')
                  ->constrained('animals')
                  ->cascadeOnDelete();
            $table->decimal('peso', 6, 2);
            $table->date('measured_at');
            $table->foreignId('recorded_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->index('animal_id');
            $table->index('measured_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_weights');
    }
};