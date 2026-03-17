<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
    ];

    // Una materia pertenece a un profesor
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
