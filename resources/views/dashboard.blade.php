@push('styles')
    @vite('resources/css/dashboard.css')
@endpush
 
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-white">
                Panel Principal
            </h1>
            <span class="text-sm text-blue-100">
                {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </x-slot>

    {{-- Banner institucional --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-800 via-blue-700 to-emerald-600 p-10 text-white shadow-2xl mb-12">

        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-3">
                Bienvenida, {{ Auth::user()->name }} 👋
            </h2>
            <p class="text-lg text-blue-100">
                Sistema Académico del Colegio — Plataforma de Gestión Institucional
            </p>
        </div>

        {{-- efecto decorativo --}}
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-52 h-52 bg-emerald-300/20 rounded-full blur-3xl"></div>

    </div>

    {{-- Tarjetas principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        {{-- Tarjeta Rol --}}
        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition duration-300 border border-slate-100">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm uppercase tracking-wider text-slate-500">
                        Rol de Usuario
                    </h3>
                    <p class="text-2xl font-bold text-blue-800 mt-2">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>
                </div>

                <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-blue-100 text-3xl group-hover:scale-110 transition">
                    🔐
                </div>
            </div>

            <div class="h-1 w-full bg-gradient-to-r from-blue-600 to-blue-400 rounded-full"></div>
        </div>

        {{-- Tarjeta Estado --}}
        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition duration-300 border border-slate-100">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm uppercase tracking-wider text-slate-500">
                        Estado del Sistema
                    </h3>
                    <p class="text-xl font-bold text-emerald-700 mt-2">
                        Operando con normalidad
                    </p>
                </div>

                <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-emerald-100 text-3xl group-hover:scale-110 transition">
                    📊
                </div>
            </div>

            <div class="h-1 w-full bg-gradient-to-r from-emerald-600 to-emerald-400 rounded-full"></div>
        </div>

        {{-- Tarjeta Acceso --}}
        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition duration-300 border border-slate-100">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm uppercase tracking-wider text-slate-500">
                        Último Acceso
                    </h3>
                    <p class="text-xl font-bold text-green-700 mt-2">
                        {{ now()->format('d/m/Y') }}
                    </p>
                </div>

                <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-green-100 text-3xl group-hover:scale-110 transition">
                    📅
                </div>
            </div>

            <div class="h-1 w-full bg-gradient-to-r from-green-600 to-green-400 rounded-full"></div>
        </div>
        

    </div>

</x-app-layout>
