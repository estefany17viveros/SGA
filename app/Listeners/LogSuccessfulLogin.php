<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\LoginLog;

class LogSuccessfulLogin
{
  public function handle(Login $event): void
{
    $user = $event->user;

    // 🔥 CERRAR SESIONES ANTERIORES
    LoginLog::where('user_id', $user->id)
        ->whereNull('logout_at')
        ->update([
            'logout_at' => now()
        ]);

    // 🔥 CREAR NUEVA SESIÓN
    LoginLog::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
        'login_at' => now(),
        'ip_address' => request()->ip(),
    ]);
}
}