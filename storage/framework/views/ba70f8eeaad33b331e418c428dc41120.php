<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/dashboard.css'); ?>
<?php $__env->stopPush(); ?>
 
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-white">
                Panel Principal
            </h1>
            <span class="text-sm text-blue-100">
                <?php echo e(now()->format('d/m/Y')); ?>

            </span>
        </div>
     <?php $__env->endSlot(); ?>

    
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-800 via-blue-700 to-emerald-600 p-10 text-white shadow-2xl mb-12">

        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-3">
                Bienvenida, <?php echo e(Auth::user()->name); ?> 👋
            </h2>
            <p class="text-lg text-blue-100">
                Sistema Académico del Colegio — Plataforma de Gestión Institucional
            </p>
        </div>

        
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-52 h-52 bg-emerald-300/20 rounded-full blur-3xl"></div>

    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        
        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition duration-300 border border-slate-100">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm uppercase tracking-wider text-slate-500">
                        Rol de Usuario
                    </h3>
                    <p class="text-2xl font-bold text-blue-800 mt-2">
                        <?php echo e(ucfirst(Auth::user()->role)); ?>

                    </p>
                </div>

                <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-blue-100 text-3xl group-hover:scale-110 transition">
                    🔐
                </div>
            </div>

            <div class="h-1 w-full bg-gradient-to-r from-blue-600 to-blue-400 rounded-full"></div>
        </div>

        
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

        
        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition duration-300 border border-slate-100">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm uppercase tracking-wider text-slate-500">
                        Último Acceso
                    </h3>
                    <p class="text-xl font-bold text-green-700 mt-2">
                        <?php echo e(now()->format('d/m/Y')); ?>

                    </p>
                </div>

                <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-green-100 text-3xl group-hover:scale-110 transition">
                    📅
                </div>
            </div>

            <div class="h-1 w-full bg-gradient-to-r from-green-600 to-green-400 rounded-full"></div>
        </div>
        

    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\SGA\resources\views/dashboard.blade.php ENDPATH**/ ?>