<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [

        /*
        |---------------------------------
        | Datos personales
        |---------------------------------
        */
        'photo',
        'first_name',
        'last_name',
        'gender',
        'birth_date',

        /*
        |---------------------------------
        | Documento
        |---------------------------------
        */
        'identification_type',
        'identification_number',
        'expedition_date',

        /*
        |---------------------------------
        | Lugar de expedición
        |---------------------------------
        */
        'expedition_department',
        'expedition_municipality',

        /*
        |---------------------------------
        | Dirección
        |---------------------------------
        */
        'address',

        /*
        |---------------------------------
        | Salud
        |---------------------------------
        */
        'eps',
        'blood_type',
        'medical_conditions',

         /*
        |---------------------------------
        | Población Especial
        |---------------------------------
        */
        'population_type',
        'population_certificate',

         /*
        |---------------------------------
        | Documentos
        |---------------------------------
        */
        'certificate_file',

        /*
        |---------------------------------
        | Observaciones
        |---------------------------------
        */
        'observations'
    ];

    /*
    |------------------------------------------------------------------
    | CASTS (Laravel tratará estas columnas como fechas)
    |------------------------------------------------------------------
    */

    protected $casts = [
        'birth_date' => 'date',
        'expedition_date' => 'date',
    ];

    /*
    |------------------------------------------------------------------
    | RELACIONES
    |------------------------------------------------------------------
    */

    /**
     * Matrículas del estudiante
     * Un estudiante puede tener muchas matrículas
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

   public function guardians()
{
    return $this->hasMany(Guardian::class);
}

    /**
     * Matrícula actual (del año activo)
     */
    public function currentEnrollment()
    {
        return $this->hasOne(Enrollment::class)
            ->whereHas('academicYear', function ($query) {
                $query->where('is_active', 1);
            });
    }

    /*
    |------------------------------------------------------------------
    | ACCESORES
    |------------------------------------------------------------------
    */

    /**
     * Nombre completo
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Edad automática calculada desde la fecha de nacimiento
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

}