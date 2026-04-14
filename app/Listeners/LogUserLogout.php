<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\LoginLog;

class LogUserLogout
{
    public function handle(Logout $event): void
    {
        $user = $event->user;

        if (!$user) return;

        // 🔥 buscar último login SIN salida
        $log = LoginLog::where('user_id', $user->id)
            ->whereNull('logout_at')
            ->latest()
            ->first();

        if ($log) {
            $log->update([
                'logout_at' => now()
            ]);
        }
    }
}
