<nav class="bg-gradient-to-r from-colegioAzul to-colegioVerde shadow-xl px-8 py-5 rounded-b-3xl">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <!-- IZQUIERDA -->
        <div class="flex items-center space-x-6">

            <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg">
                🌿 SGA
            </a>

            <a href="{{ route('dashboard') }}" class="text-white hover:underline">
                Inicio
            </a>

            @auth
                @if(Auth::user()->role === 'admin')
                    @include('layouts.menus.admin')
                @endif

                @if(Auth::user()->role === 'teacher')
                    @include('layouts.menus.teacher')
                @endif
            @endauth

        </div>

        <!-- USUARIO -->
        <div>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="px-4 py-2 bg-gradient-to-r from-colegioAzulClaro to-colegioVerdeClaro text-white rounded-lg">
                        {{ Auth::user()->name }}
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Perfil
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

    </div>
</nav>

@include('layouts.menus.script')