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
        Schema::create('animal_descendances', function (Blueprint $table) {
            $table->id();

            // hijo
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade');

            // padres (toro y vaca)
            $table->foreignId('padre_id')->constrained('animals')->onDelete('restrict');
            $table->foreignId('madre_id')->constrained('animals')->onDelete('restrict');

            $table->date('fecha_nacimiento')->nullable();
            $table->text('observaciones')->nullable();

            // usuario que registró
            $table->foreignId('registrado_por')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_descendances');
    }
};
