<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con usuario
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 👤 Datos básicos
            $table->string('first_name');
            $table->string('last_name');

            // 📞 Contacto
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // 🎓 Extra
            $table->string('specialty')->nullable();

            // 📸 Foto
            $table->string('photo')->nullable();

            // 📅 Fechas laborales
            $table->date('start_date'); // ingreso
            $table->date('end_date')->nullable(); // fin

            // 🧍 Información personal
            $table->enum('gender', ['masculino', 'femenino', 'otro']);

            $table->enum('document_type', [
                'cc',
                'ti',
                'ce',
                'pasaporte'
            ]);

            $table->string('document_number')->unique();

            $table->string('expedition_department');
            $table->string('expedition_municipality');

            $table->date('birth_date');

            // 📄 Hoja de vida
            $table->string('cv')->nullable();

            // 🔘 Estado
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};