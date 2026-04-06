<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'specialty',
        'photo',
        'start_date',
        'end_date',
        'gender',
        'document_type',
        'document_number',
        'expedition_department',
        'expedition_municipality',
        'birth_date',
        'cv',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    // 🔗 relación
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🎯 EDAD AUTOMÁTICA
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}