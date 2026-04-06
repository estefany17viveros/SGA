<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con año académico
            $table->foreignId('academic_year_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 📊 Datos del periodo
            $table->integer('number'); // Periodo 1, 2, 3, 4
            $table->string('name')->nullable(); // Ej: "Primer periodo"

            // 📅 Fechas
            $table->date('start_date');
            $table->date('end_date');

            // 🔄 Estado
            $table->enum('status', ['activo', 'cerrado'])
                  ->default('activo');
            $table->decimal('percentage', 5, 2)->default(25);
            $table->timestamps();

            // Evita duplicados (Periodo 1 dos veces en mismo año)
            $table->unique(['academic_year_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
  
