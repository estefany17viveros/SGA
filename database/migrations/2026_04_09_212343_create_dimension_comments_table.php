<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dimension_comments', function (Blueprint $table) {
            $table->id();

            // 🔗 Relaciones clave
            $table->foreignId('teacher_subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grade_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
$table->foreignId('academic_year_id')
      ->constrained()
      ->cascadeOnDelete();
               
            // 📊 Dimensión
            $table->enum('dimension', ['saber', 'hacer', 'ser']);

            // 📝 Comentario
            $table->text('comment');

            $table->timestamps();

            // ✅ CORREGIDO (incluye period_id)
            $table->unique([
                'teacher_subject_id',
                'grade_id',
                'period_id',
                'academic_year_id',
                'dimension'
            ], 'dimension_comments_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimension_comments');
    }
};