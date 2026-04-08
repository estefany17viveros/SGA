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
        Schema::create('scores', function (Blueprint $table) {
    $table->id();

    // 🔗 RELACIONES
    $table->foreignId('student_id')->constrained()->cascadeOnDelete();
    $table->foreignId('teacher_subject_id')->constrained()->cascadeOnDelete();

    // 🧠 NOTAS
    $table->decimal('saber', 5, 2)->nullable();
    $table->decimal('hacer', 5, 2)->nullable();
    $table->decimal('ser', 5, 2)->nullable();

    // 💬 COMENTARIO
    $table->text('comment')->nullable();

    $table->timestamps();

    // 🔒 UN SOLO REGISTRO POR ESTUDIANTE
    $table->unique(['student_id', 'teacher_subject_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
