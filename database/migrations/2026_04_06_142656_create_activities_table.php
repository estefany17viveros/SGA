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
        Schema::create('activities', function (Blueprint $table) {
    $table->id();

    $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
    $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
    $table->foreignId('group_id')->constrained()->cascadeOnDelete();
    $table->foreignId('period_id')->constrained()->cascadeOnDelete();

    $table->enum('type', ['saber', 'hacer', 'ser']); // 🔥 FIJO

    $table->string('description'); // examen, taller, quiz
    $table->decimal('percentage', 5, 2); // peso (ej: 30%)

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
