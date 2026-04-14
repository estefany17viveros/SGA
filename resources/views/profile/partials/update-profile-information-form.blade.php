<section class="profile-card">

    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-custom border border-gray-200 p-8">

        {{-- HEADER --}}
        <header class="mb-6">
            <h2 class="text-2xl font-bold text-colegioAzul">
                Información del Perfil
            </h2>

            <p class="mt-2 text-gray-600">
                Solo puedes actualizar tu dirección y número de teléfono
            </p>
        </header>

        {{-- MENSAJE --}}
        @if(session('status') === 'profile-updated')
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                ✔ Perfil actualizado correctamente
            </div>
        @endif

        {{-- 🔥 FOTO --}}
        <div class="flex flex-col items-center mb-6">
            @if(auth()->user()->teacher->photo ?? false)
                <img src="{{ asset('storage/' . auth()->user()->teacher->photo) }}"
                     class="w-28 h-28 rounded-full object-cover border-4 border-blue-500 shadow">
            @else
                <div class="w-28 h-28 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    Sin foto
                </div>
            @endif
        </div>

        {{-- FORMULARIO SOLO EDITABLE --}}
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            {{-- 🔹 INFORMACIÓN SOLO LECTURA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">Nombre</label>
                    <input type="text"
                           value="{{ auth()->user()->name }}"
                           class="w-full border rounded-lg p-2 bg-gray-100"
                           disabled>
                </div>

                <div>
                    <label class="font-semibold">Correo electrónico</label>
                    <input type="text"
                           value="{{ auth()->user()->email }}"
                           class="w-full border rounded-lg p-2 bg-gray-100"
                           disabled>
                </div>

            </div>

            {{-- 🔥 SOLO EDITABLE --}}
            <div>
                <label class="font-semibold">Teléfono</label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone', auth()->user()->teacher->phone ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            <div>
                <label class="font-semibold">Dirección</label>
                <input type="text"
                       name="address"
                       value="{{ old('address', auth()->user()->teacher->address ?? '') }}"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            {{-- BOTÓN --}}
            <div class="flex items-center gap-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    💾 Guardar cambios
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-green-600 text-sm">
                        Guardado ✔
                    </span>
                @endif
            </div>

        </form>

    </div>

</section>