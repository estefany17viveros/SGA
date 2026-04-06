<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'relationship',
        'identification_number',
        'phone',
        'email',
        'address',

    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}