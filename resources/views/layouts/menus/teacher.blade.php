<!-- 🔽 ACTIVIDADES -->
<div class="relative">
    <button onclick="toggleMenu('menu5')" class="text-white">
        Actividades ▾
    </button>

    <div id="menu5" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-48 z-50">

        <a href="{{ route('teacher.dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">
            Ver panel de control
        </a>

        <a href="{{ route('teacher.dimension_comments.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Comentarios por dimensión
        </a>

        <!-- 🔥 NUEVO: DIRECTOR DE GRUPO -->
        <a href="{{ route('teacher.director.index') }}" class="block px-4 py-2 hover:bg-gray-200">
            Director de grupo
        </a>

    </div>
</div>