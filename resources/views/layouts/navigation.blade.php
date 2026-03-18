<nav class="bg-gradient-to-r from-colegioAzul to-colegioVerde shadow-xl px-8 py-5 rounded-b-3xl">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo y links -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg">
                🌿 SGA 🌿
            </a>
            <a href="{{ route('dashboard') }}" class="text-white hover:underline">
                Inicio
            </a>
            
            @auth
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.teacher-profiles.index') }}">
            Profesores
        </a>
        
        
 <a href="{{ route('admin.grades.index') }}">
            Registro grado
        </a>
        </a>
 <a href="{{ route('admin.academic_years.index') }}">
            Registro año académico
        </a>

         </a>
 <a href="{{ route('admin.enrollments.index') }}">
            matriculas
        </a>
          </a>
 <a href="{{ route('admin.enrollments.graduated') }}">
            graduados
        </a> 
          </a>
 <a href="{{ route('admin.enrollments.retired') }}">
            retirados
        </a> 
         </a>
 <a href="{{ route('admin.students.index') }}">
            estudiantes
        </a>
          </a>
 <a href="{{ route('admin.guardians.index') }}">
            acudientes
        </a>
    @endif
@endauth
        </div>

        <!-- Usuario -->
        <div>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="px-4 py-2 bg-gradient-to-r from-colegioAzulClaro to-colegioVerdeClaro text-white rounded-lg hover:opacity-90 hover:-translate-y-0.5 transition">
                        {{ Auth::user()->name }}
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="py-1">
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
                    </div>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
