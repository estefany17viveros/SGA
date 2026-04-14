<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DimensionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_subject_id',
        'grade_id',
        'period_id',
        'dimension',
        'comment'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * 🔗 Asignatura del profesor (materia + docente + grado)
     */
    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class);
    }

    /**
     * 🎓 Grado
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
 public function period()
    {
        return $this->belongsTo(Period::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES (OPCIONAL PERO ÚTIL)
    |--------------------------------------------------------------------------
    */

    /**
     * Filtrar por dimensión
     */
    public function scopeDimension($query, $dimension)
    {
        return $query->where('dimension', $dimension);
    }

    /**
     * Filtrar por asignación (teacher_subject)
     */
    public function scopeForAssignment($query, $teacherSubjectId)
    {
        return $query->where('teacher_subject_id', $teacherSubjectId);
    }

    /**
     * Filtrar por grado
     */
    public function scopeForGrade($query, $gradeId)
    {
        return $query->where('grade_id', $gradeId);
    }
}