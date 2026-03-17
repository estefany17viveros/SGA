<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use hasfactory;
    
    protected $table = 'parents';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'identification_type',
        'identification_number',
    ];

    /**
     * Relación muchos a muchos con estudiantes
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student')
                    ->withPivot('relationship')
                    ->withTimestamps();
    }
}