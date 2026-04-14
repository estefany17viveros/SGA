<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'grade_id',
        'group_id',
        'academic_year_id',
        'status'
    ];

    // 🔗 RELACIONES

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

public function dimension_Comments()
{
    return $this->hasMany(Dimension_Comment::class);
}

   public function academicYear()
{
    return $this->belongsTo(AcademicYear::class);
}

    // 🔥 FUTURO: notas
    public function gradeRecords()
    {
        return $this->hasMany(GradeRecord::class);
    }

    // 🔍 FILTRAR SOLO ACTIVOS
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}