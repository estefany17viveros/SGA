@push('styles')
    @vite('resources/css/app.css')

<x-guest-layout class="login-page">

    <!-- Estado de Sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-card">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Correo Electrónico -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input 
                    id="email" 
                    class="block mt-1 w-full" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a 
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" 
                        href="{{ route('password.request') }}"
                    >
                        {{ __('¿Olvidó su contraseña?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
            </div>

        </form>
    </div>

</x-guest-layout>