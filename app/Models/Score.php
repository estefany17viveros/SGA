<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_subject_id',
        'period_id',
        'saber',
        'hacer',
        'ser',
        'total'
    ];

    // 👇 IMPORTANTE para poder usarlo directo en las vistas
    protected $appends = ['nivel', 'nivel_nombre', 'nivel_frase'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function period()
{
    return $this->belongsTo(Period::class);
}

    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class);
    }

    // 🔥 LÓGICA DEL NIVEL SEGÚN LA NOTA TOTAL
    public function getNivelAttribute()
    {
        $nota = $this->total; // usamos la nota final

        if ($nota >= 45) {
            return [
                'nivel' => 'Superior',
                'frase' => 'siempre'
            ];
        } elseif ($nota >= 40) {
            return [
                'nivel' => 'Alto',
                'frase' => 'casi siempre'
            ];
        } elseif ($nota >= 30) {
            return [
                'nivel' => 'Básico',
                'frase' => 'Algunas veces'
            ];
        } else {
            return [
                'nivel' => 'Bajo',
                'frase' => 'Con dificultad'
            ];
        }
    }

    // 👇 Para usar más fácil en Blade
    public function getNivelNombreAttribute()
    {
        return $this->nivel['nivel'];
    }

    public function getNivelFraseAttribute()
    {
        return $this->nivel['frase'];
    }
}