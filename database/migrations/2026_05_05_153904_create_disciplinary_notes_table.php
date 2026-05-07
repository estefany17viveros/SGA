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
    Schema::create('disciplinary_notes', function (Blueprint $table) {
        $table->id();

        $table->foreignId('student_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('grade_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('teacher_id')
              ->constrained()
              ->cascadeOnDelete();

        // 🔥 NOTA TIPO BOLETÍN
        $table->decimal('note', 3, 1); // ej: 4.5

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_notes');
    }
};
