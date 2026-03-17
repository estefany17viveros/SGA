
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/academic_years/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>Detalle Año Académico</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Año:</strong> <?php echo e($academicYear->year); ?></li>
        <li class="list-group-item"><strong>Calendario:</strong> <?php echo e($academicYear->calendar); ?></li>
        <li class="list-group-item">
<strong>Inicio:</strong>
<?php echo e(\Carbon\Carbon::parse($academicYear->start_date)->format('d/m/Y')); ?>

</li>

<li class="list-group-item">
<strong>Fin:</strong>
<?php echo e(\Carbon\Carbon::parse($academicYear->end_date)->format('d/m/Y')); ?>

</li>
        <li class="list-group-item"><strong>Períodos:</strong> <?php echo e($academicYear->periods); ?></li>
        <li class="list-group-item"><strong>Estado:</strong> <?php echo e($academicYear->status); ?></li>
    </ul>

    <a href="<?php echo e(route('admin.academic_years.index')); ?>"
       class="btn btn-secondary mt-3">
        Volver
    </a>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/academic_years/show.blade.php ENDPATH**/ ?>