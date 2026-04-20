<nav class="bg-gradient-to-r from-colegioAzul to-colegioVerde shadow-xl px-4 md:px-8 py-3 md:py-4 rounded-b-3xl sticky top-0 z-50" 
     x-data="{ mobileMenuOpen: false }">
    
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('dashboard')); ?>" class="relative group">
                <div class="bg-white p-1 rounded-full shadow-lg overflow-hidden w-30 h-12 md:w- md:h-12 flex items-center justify-center transition-all group-hover:ring-4 group-hover:ring-white/20">
                    <img src="<?php echo e(asset('images/logo-itaf.jpg')); ?>" alt="ITAF" class="h-full w-full object-cover rounded-full transition-transform duration-300 group-hover:scale-110">
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-1">
                <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 text-white font-semibold hover:bg-white/10 rounded-xl transition">
                    Inicio
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role === 'admin'): ?> <?php echo $__env->make('layouts.menus.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php endif; ?>
                    <?php if(Auth::user()->role === 'teacher'): ?> <?php echo $__env->make('layouts.menus.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <div class="hidden md:block">
                <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        <button class="flex items-center space-x-2 px-4 py-2 bg-white/20 text-white rounded-xl border border-white/30 font-bold text-sm hover:bg-white/30 transition shadow-sm">
                            <span><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                     <?php $__env->endSlot(); ?>
                     <?php $__env->slot('content', null, []); ?> 
    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 custom-dropdown-container">
    <div class="bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
        
        <a class="nav-link-custom px-4 py-3" href="<?php echo e(route('profile.edit')); ?>">
            <span class="mr-2">👤</span>
            <span>Perfil</span>
        </a>

        <div class="border-t border-gray-100"></div>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <a class="nav-link-custom nav-link-logout px-4 py-3" 
               href="<?php echo e(route('logout')); ?>" 
               onclick="event.preventDefault(); this.closest('form').submit();">
                <span class="mr-2">🚪</span>
                <span>Cerrar sesión</span>
            </a>
        </form>
    </div>
</div>
 <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2.5 rounded-xl bg-white/10 text-white active:scale-95 transition-all focus:outline-none">
                <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden mt-4 bg-white rounded-3xl shadow-2xl p-4 space-y-4 border border-gray-100 max-h-[80vh] overflow-y-auto">
        
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center p-3 text-gray-700 font-extrabold hover:bg-gray-50 rounded-2xl transition">🏠 Inicio</a>

        <div class="space-y-1">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-3 mb-2">Administración</p>
            <div class="mobile-nav-container">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role === 'admin'): ?> <?php echo $__env->make('layouts.menus.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php endif; ?>
                    <?php if(Auth::user()->role === 'teacher'): ?> <?php echo $__env->make('layouts.menus.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] px-3 mb-2">Cuenta</p>
            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center p-3 text-gray-600 font-medium hover:bg-gray-50 rounded-2xl transition">👤 Mi Perfil</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center p-3 text-red-500 font-bold hover:bg-red-50 rounded-2xl transition text-left">🚪 Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>

<style>
    /* Forzamos que el contenedor sea blanco siempre */
.custom-dropdown-container {
    background-color: white !important;
}

/* Los enlaces (Perfil y Cerrar Sesión) */
.nav-link-custom {
    color: #1a1a1a !important; /* Negro casi puro para que se lea perfecto */
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    display: flex !important;
    align-items: center !important;
    text-decoration: none !important;
}

/* El efecto HOVER en color AZUL */
.nav-link-custom:hover {
    background-color: #eff6ff !important; /* Fondo azul clarito */
    color: #2563eb !important; /* Texto azul vibrante */
}

/* Ajuste para el texto de Cerrar Sesión (para que mantenga el rojo o cambie a azul) */
.nav-link-logout {
    color: #dc2626 !important; /* Rojo inicial */
}

.nav-link-logout:hover {
    color: #2563eb !important; /* Cambia a azul al pasar el mouse */
}
    /* --- COMPORTAMIENTO DESKTOP (PC) --- */
    @media (min-width: 769px) {
        div[id^="menu"] {
            position: absolute !important;
            top: 110%;
            left: 0;
            background: white;
            min-width: 230px;
            border-radius: 16px;
            box-shadow: 0 15px 30px -5px rgba(67, 151, 248, 0.61);
            z-index: 100;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        button[onclick^="toggleMenu"] {
            color: white !important;
        }
    }

    /* --- COMPORTAMIENTO MÓVIL (CORRECCIÓN DE ACORDEÓN) --- */
    @media (max-width: 768px) {
        /* IMPORTANTE: Quitamos el 'absolute' para que el submenú empuje el contenido hacia abajo */
        div[id^="menu"] {
            position: relative !important;
            width: 100% !important;
            background: #f8fafc !important; /* Gris suave para resaltar el área interna */
            box-shadow: none !important;
            border: none !important;
            margin: 8px 0 !important;
            padding: 8px !important;
            border-radius: 15px !important;
            top: 0 !important;
            left: 0 !important;
        }

        /* Botones del menú principal (Profesores, Materias, etc.) */
        button[onclick^="toggleMenu"] {
            color: #1e293b !important;
            width: 100% !important;
            justify-content: space-between !important;
            padding: 14px !important;
            font-weight: 800 !important;
            background: transparent !important;
            border-radius: 12px;
            display: flex !important;
            align-items: center;
        }

        button[onclick^="toggleMenu"]:hover {
            background: #f1f5f9 !important;
        }

        /* Enlaces internos del submenú */
        div[id^="menu"] a {
            display: block !important;
            padding: 12px 18px !important;
            color: #475569 !important;
            font-size: 14px !important;
            font-weight: 600;
            border-left: 3px solid #e2e8f0;
            margin-left: 10px;
            border-radius: 0 !important;
            transition: all 0.2s;
        }

        div[id^="menu"] a:hover {
            border-left-color: #1e88e5;
            background: white !important;
            color: #1e88e5 !important;
            transform: translateX(5px);
        }

        /* Clase para ocultar */
        .hidden {
            display: none !important;
        }
    }
    
    [x-cloak] { display: none !important; }
</style>

<script>
    function toggleMenu(menuId) {
        const allMenus = document.querySelectorAll('[id^="menu"]');
        
        allMenus.forEach(menu => {
            if (menu.id === menuId) {
                // Abre o cierra el clickeado
                menu.classList.toggle('hidden');
            } else {
                // Cierra los otros para evitar desorden
                menu.classList.add('hidden');
            }
        });
    }

    // Cerrar al hacer clic afuera (solo en PC)
    window.addEventListener('click', function(e) {
        if (window.innerWidth > 768) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('[id^="menu"]').forEach(m => m.classList.add('hidden'));
            }
        }
    });
</script><?php /**PATH C:\xampp\htdocs\SGA\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>