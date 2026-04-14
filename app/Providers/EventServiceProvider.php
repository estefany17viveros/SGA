<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// 👇 IMPORTANTE: tu listener personalizado
use App\Listeners\LogSuccessfulLogin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        // 📌 Cuando un usuario inicia sesión
        Login::class => [
            LogSuccessfulLogin::class,
        ],

        // 📌 Registro de usuarios (opcional Laravel default)
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // 📌 Logout (opcional si luego quieres guardar salida)
        Logout::class => [
        LogUserLogout::class, // 🔥 IMPORTANTE
    ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}