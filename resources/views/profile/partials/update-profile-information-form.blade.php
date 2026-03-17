
<section class="profile-card">   <!-- Información del Perfil -->
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-custom border border-gray-200 p-8">
        <header class="mb-6">
            <h2 class="text-2xl font-bold text-colegioAzul">Información del Perfil</h2>
            <p class="mt-2 text-gray-600">
                Actualice la información de su perfil y su dirección de correo electrónico.
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <!-- Nombre -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" class="font-semibold text-gray-700"/>
                <x-text-input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-colegioAzul focus:border-colegioAzul" 
                    :value="old('name', auth()->user()->name)" 
                    required 
                    autofocus 
                    autocomplete="name" 
                />
                <x-input-error class="mt-1 text-red-600" :messages="$errors->get('name')" />
            </div>

            <!-- Correo Electrónico -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" class="font-semibold text-gray-700"/>
                <x-text-input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-colegioAzul focus:border-colegioAzul" 
                    :value="old('email', auth()->user()->email)" 
                    required 
                    autocomplete="username" 
                />
                <x-input-error class="mt-1 text-red-600" :messages="$errors->get('email')" />

               @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-md">
                        <p class="text-yellow-700 text-sm">
                            Su dirección de correo electrónico no está verificada.
                            <button form="send-verification" class="underline text-yellow-600 hover:text-yellow-800 ml-1">
                                Haga clic aquí para reenviar el correo de verificación.
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 text-green-600 text-sm font-medium">
                                Se ha enviado un nuevo enlace de verificación a su correo electrónico.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Botón Guardar -->
            <div class="flex items-center gap-4">
                <x-primary-button class="bg-gradient-to-r from-colegioAzul to-colegioVerde hover:opacity-90">
                    Guardar
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >Guardado.</p>
                @endif
            </div>
        </form>
    </div>
</section>