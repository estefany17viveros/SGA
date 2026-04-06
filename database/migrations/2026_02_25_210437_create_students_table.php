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
        Schema::create('students', function (Blueprint $table) {

            $table->id();

            // 📷 Foto (opcional)
            $table->string('photo')->nullable();

            // 👤 Datos personales
            $table->string('first_name');
            $table->string('last_name');

            $table->enum('gender', [
                'masculino',
                'femenino'
            ]);

            $table->date('birth_date');

            // 🆔 Documento
            $table->enum('identification_type', [
                'registro_civil',
                'tarjeta_identidad',
                'cedula_ciudadania',
                'cedula_extranjeria',
                'pasaporte',
                'permiso_proteccion_temporal'
            ]);

            $table->string('identification_number')->unique();

            // 📍 Expedición
            $table->date('expedition_date');
            $table->string('expedition_department');
            $table->string('expedition_municipality');

            // 🏠 Dirección
            $table->string('address');

            // 🏥 Salud
            $table->string('eps');

            $table->enum('blood_type', [
                'A+','A-',
                'B+','B-',
                'AB+','AB-',
                'O+','O-'
            ]);

            // 📝 Información adicional
            $table->text('medical_conditions')->nullable();
            $table->text('observations')->nullable();

            // 📄 Certificado general
            $table->string('certificate_file')->nullable();

            // 🌎 Tipo de población
            $table->enum('population_type', [
                'ninguno',
                'afro',
                'indigena',
                'desplazado'
            ])->default('ninguno');

            // 📄 Certificado de población
            $table->string('population_certificate')->nullable();

            // ⏱️ Control del sistema
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};