<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaryNote extends Model
{
    protected $fillable = [
        'student_id',
        'grade_id',
        'note',
        'teacher_id'
    ];
}