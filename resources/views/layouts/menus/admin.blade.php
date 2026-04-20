<!-- 🔽 PROFESORES -->
<div class="relative">
    <button onclick="toggleMenu('menu1')" class="text-white">
        Profesores ▾
    </button>

    <div id="menu1" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-48 z-50">
        <a href="{{ route('admin.teachers.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Lista de profesores
        </a>

        <a href="{{ route('admin.teacher-subjects.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Asignación académica
        </a>
    </div>
</div>

<!-- 🔽 ACADÉMICO -->
<div class="relative">
    <button onclick="toggleMenu('menu2')" class="text-white">
        Académico ▾
    </button>

    <div id="menu2" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-48 z-50">

        <a href="{{ route('admin.academic_years.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Años académicos
        </a>

        <a href="{{ route('admin.grades.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Grados
        </a>

        @php
            $activeYear = \App\Models\AcademicYear::where('status', 'activo')->first();
        @endphp

        @if($activeYear)
            <a href="{{ route('admin.periods.index', $activeYear->id) }}" class="block px-4 py-2 hover:bg-gray-200">
                Periodos
            </a>
        @endif

    </div>
</div>

<!-- 🔽 ESTUDIANTES -->
<div class="relative">
    <button onclick="toggleMenu('menu3')" class="text-white">
        Estudiantes ▾
    </button>

    <div id="menu3" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-56 z-50">

        <a href="{{ route('admin.students.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Estudiantes
        </a>

        <a href="{{ route('admin.enrollments.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Matrículas
        </a>

        <a href="{{ route('admin.enrollments.graduated') }}" class="block px-4 py-2 hover:bg-gray-200">
            Egresados
        </a>

        <a href="{{ route('admin.enrollments.retired') }}" class="block px-4 py-2 hover:bg-gray-200">
            Retirados
        </a>

        <a href="{{ route('admin.guardians.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Acudientes
        </a>

    </div>
</div>

<!-- 🔽 MATERIAS -->
<div class="relative">
    <button onclick="toggleMenu('menu4')" class="text-white">
        Materias ▾
    </button>

    <div id="menu4" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-48 z-50">

        <a href="{{ route('admin.subjects.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Ver materias
        </a>

        <a href="{{ route('admin.subjects.create') }}" class="block px-4 py-2 hover:bg-gray-200">
            Crear materia
        </a>

    </div>
</div>

<!-- 🔽 HISTORIAL -->
<div class="relative">
    <button onclick="toggleMenu('menu5')" class="text-white">
        Historial ▾
    </button>

    <div id="menu5" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-48 z-50">

        <a href="{{ route('admin.login-logs.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Ver historial
        </a>

    </div>
</div>

<!-- 🔽 BOLETINES -->
<div class="relative">
    <button onclick="toggleMenu('menu6')" class="text-white">
        Boletines ▾
    </button>

    <div id="menu6" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-56 z-50">

        <a href="{{ route('admin.boletin.index') }}" 
           class="block px-4 py-2 hover:bg-gray-200">
            Ver boletines por grado
        </a>

    </div>
</div>