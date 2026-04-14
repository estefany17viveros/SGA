
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {

            $table->id();

            // 🔗 RELACIONES
            $table->foreignId('student_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('teacher_subject_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 📅 PERIODO (CLAVE)
            $table->foreignId('period_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 📊 NOTAS
            $table->decimal('saber', 5, 4)->nullable();
            $table->decimal('hacer', 5, 4)->nullable();
            $table->decimal('ser', 5, 4)->nullable();

            // 🔥 TOTAL (PROMEDIO)
            $table->decimal('total', 5, 4)->nullable();

            $table->timestamps();

            // 🔒 UN REGISTRO POR PERIODO
            $table->unique([
                'student_id',
                'teacher_subject_id',
                'period_id'
            ], 'unique_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};