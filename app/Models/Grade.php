<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
    ];

    // Relaciones
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}