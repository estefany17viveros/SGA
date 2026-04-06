<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('teacher_subjects', function (Blueprint $table) {
        $table->id();

        // 🔗 RELACIONES PRINCIPALES
        $table->foreignId('teacher_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('subject_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('grade_id')
              ->constrained()
              ->cascadeOnDelete();

        // 👇 OPCIONAL (como tú lo necesitas)
        $table->foreignId('group_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        // 👇 AÑO (NO lo elige el usuario, pero sí se guarda)
        $table->foreignId('academic_year_id')
              ->constrained('academic_years') // ⚠️ explícito para evitar errores
              ->cascadeOnDelete();

        // 🔒 EVITAR DUPLICADOS (CLAVE PROFESIONAL)
        $table->unique([
            'teacher_id',
            'subject_id',
            'grade_id',
            'group_id',
            'academic_year_id'
        ], 'unique_assignment');

        // 🔄 CONTROL
        $table->boolean('status')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subjects');
    }
};
