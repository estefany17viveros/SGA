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
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unique(); // 2026, 2027, etc.
            $table->enum('calendar', ['A', 'B']); // Calendario A o B
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('periods'); // Número de periodos académicos
            $table->enum('status', ['activo', 'cerrado'])
                  ->default('activo'); // Por defecto activo cuando se crea el primero
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};