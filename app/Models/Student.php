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
        'photo',
        'first_name',
        'last_name',
        'gender',
        'birth_date',

        'identification_type',
        'identification_number',
        'expedition_date',

        'expedition_department',
        'expedition_municipality',

        'address',

        'eps',
        'blood_type',
        'medical_conditions',

        'population_type',
        'population_certificate',

        'certificate_file',

        'observations'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'expedition_date' => 'date',
    ];

    /*
    |---------------------------------
    | RELACIONES
    |---------------------------------
    */

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function guardians()
    {
        return $this->hasMany(Guardian::class);
    }

    /**
     * Matrícula actual (año activo)
     */
    public function currentEnrollment()
    {
        return $this->hasOne(Enrollment::class)
            ->whereHas('academicYear', function ($query) {
                $query->where('status', 'activo');
            });
    }

    /**
     * Grado actual (CORRECTO)
     */
    public function grade()
    {
        return $this->hasOneThrough(
            \App\Models\Grade::class,
            \App\Models\Enrollment::class,
            'student_id',
            'id',
            'id',
            'grade_id'
        );
    }

    /*
    |---------------------------------
    | ACCESORES
    |---------------------------------
    */

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }
}