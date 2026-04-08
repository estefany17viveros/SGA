<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_subject_id',
        'saber',
        'hacer',
        'ser',
        'comment'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class);
    }
}