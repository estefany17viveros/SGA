
<?php $__env->startSection('title', 'Detalle del Grado'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/grades/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>Detalle del Grado</h2>

    <div class="card">
        <div class="card-body">
            
            <p><strong>Grado:</strong> <?php echo e($grade->name); ?></p>

            <p><strong>Nivel:</strong> <?php echo e($grade->level); ?></p>

            <p><strong>Creado:</strong>
                <?php echo e($grade->created_at->format('d/m/Y')); ?>

            </p>

        </div>
    </div>

    <a href="<?php echo e(route('admin.grades.index')); ?>"
       class="btn btn-secondary mt-3">
        Volver
    </a>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/grades/show.blade.php ENDPATH**/ ?>