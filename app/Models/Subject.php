<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    /**
     * Relación con asignaciones (teacher_subjects)
     */
    public function assignments()
    {
        return $this->hasMany(TeacherSubject::class);
    }
}