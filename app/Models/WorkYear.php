<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'calendar',
        'periods',
        'start_date',
        'end_date',
        'active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
    ];

    // Relaciones

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}