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
    Schema::create('groups', function (Blueprint $table) {
    $table->id();

    $table->string('name'); // Ej: A, B, 01
    $table->integer('capacity')->default(0); // Cupos disponibles

    $table->enum('status', ['activo', 'cerrado'])
          ->default('activo');

    $table->foreignId('grade_id')
          ->constrained()
          ->onDelete('cascade');

    $table->unique(['name', 'grade_id']);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
