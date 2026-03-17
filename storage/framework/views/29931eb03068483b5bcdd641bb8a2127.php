
<?php $__env->startSection('title', 'Detalle del Grupo'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/groups/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h4 class="mb-3">
        Detalle del Grupo <?php echo e($group->name); ?>

    </h4>

    <div class="card">
        <div class="card-body">

            <p><strong>Grado:</strong> <?php echo e($group->grade->name); ?></p>
            <p><strong>Capacidad:</strong> <?php echo e($group->capacity); ?></p>
            <p><strong>Matriculados:</strong> <?php echo e($group->enrollments_count); ?></p>
            <p><strong>Estado:</strong> <?php echo e(ucfirst($group->status)); ?></p>

           <a href="<?php echo e(route('admin.grades.groups.edit', [$grade->id, $group->id])); ?>"
               class="btn btn-warning">
                Editar
            </a>

          <a href="<?php echo e(route('admin.grades.groups.index', $grade->id)); ?>"
               class="btn btn-secondary">
                Volver
            </a>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/groups/show.blade.php ENDPATH**/ ?>