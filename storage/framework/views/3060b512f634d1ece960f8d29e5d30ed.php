<!-- 🔽 ACTIVIDADES -->
<div class="relative">
    <button onclick="toggleMenu('menu5')" class="text-white">
        Actividades ▾
    </button>

    <div id="menu5" class="hidden absolute bg-white text-black mt-2 rounded shadow-lg w-48 z-50">

        <a href="<?php echo e(route('teacher.activities.index')); ?>" class="block px-4 py-2 hover:bg-gray-200">
            Ver actividades
        </a>

    </div>
</div><?php /**PATH C:\xampp\htdocs\SGA\resources\views/layouts/menus/teacher.blade.php ENDPATH**/ ?>