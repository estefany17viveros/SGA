<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'role',
        'login_at',
        'logout_at',
        'ip_address'
    ];

    // 🔥 ESTO SOLUCIONA TU ERROR
    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}