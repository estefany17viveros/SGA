<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'dni',
        'phone',
        'address',
        'specialty',
        'photo'
    ];
    // Un profesor puede tener varias materias
   
    public function user()
{
    return $this->belongsTo(User::class);
}
}
