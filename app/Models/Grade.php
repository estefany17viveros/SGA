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
        'director_id'
    ];

    // Relaciones
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
public function director()
{
    return $this->belongsTo(Teacher::class, 'director_id');
}
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    // esta se hace para que cuanod este en 11 no permita promover a otro grado

  public function isFinal()
{
    $name = strtolower(trim($this->name));

    return $name == '11'
        || $name == 'once'
        || str_contains($name, '11')
        || str_contains($name, 'once');
}
}