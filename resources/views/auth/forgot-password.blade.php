@push('styles')
    @vite('resources/css/app.css')

<x-guest-layout>
    <div class="forgot-password-container max-w-md mx-auto mt-16 p-8 bg-white dark:bg-gray-800 shadow-lg rounded-2xl transition-all duration-500">
        <h2 class="title text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4 text-center">
            ¿Olvidaste tu contraseña?
        </h2>
        
        <!-- Estado de sesión -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Errores de validación -->
        <x-input-error :messages="$errors->all()" class="mb-4" />

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Correo electrónico -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm transition-all duration-300"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors duration-300">
                Restablecer contraseña
           </x-primary-button>
            </div>
        </form>

    <!-- Enlace de depuración (solo desarrollo) -->
@if(session('debug_link'))
    <div class="debug-link mt-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg text-blue-700 dark:text-blue-200">
        <strong>Se generó un enlace de recuperación.</strong><br>

        <a href="{{ session('debug_link') }}"
           class="text-blue-600 dark:text-blue-300 font-semibold hover:underline">
           Haz clic aquí para restablecer tu contraseña
        </a>
    </div>
@endif
        <!-- Volver al login -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                Volver al inicio de sesión
            </a>
        </div>
    </div>

    <!-- CSS personalizado -->
    <style>
        /* Container con degradado y animación */
        .forgot-password-container {
            background: rgba(232, 235, 240, 0.627);;
            transition: all 0.5s ease;
        }

        /* Título con sombra ligera */
        .title {
            text-shadow: 1px 1px 4px rgba(0,0,0,0.1);
        }

        /* Inputs interactivos */
        input[type="email"] {
            transition: all 0.3s ease;
        }
        input[type="email"]:focus {
            transform: scale(1.02);
            box-shadow: 0 0 12px rgba(59,130,246,0.3);
             background: rgba(232, 235, 240, 0.627);
        }
        

        /* Botón primario */
        button {
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59,130,246,0.3);
        }

       /* Forzar que los enlaces largos se rompan y se ajusten */
.debug-link a {
    display: inline-block;       /* Para que respete padding y margen */
    word-break: break-all;       /* Rompe la palabra si es demasiado larga */
    overflow-wrap: anywhere;     /* Compatible con navegadores modernos */
    color: inherit;              /* Mantiene el color según el tema */
    text-decoration: underline;
}

        /* Texto centrado y colores suaves para modo oscuro */
        body.dark .forgot-password-container {
            background: linear-gradient(135deg, #0163f7 0%, #e0e0e0 100%);
        }
    </style>
</x-guest-layout>