<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/periods/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2>Detalle del Trimestre</h2>

<p><strong>#:</strong> <?php echo e($period->number); ?></p>
<p><strong>Nombre:</strong> <?php echo e($period->name); ?></p>
<p><strong>Inicio:</strong> <?php echo e($period->start_date); ?></p>
<p><strong>Fin:</strong> <?php echo e($period->end_date); ?></p>
<p><strong>Porcentaje:</strong> <?php echo e(number_format($period->percentage,2)); ?>%</p>
<p><strong>Estado:</strong> <?php echo e($period->status); ?></p>

<br>

<a href="<?php echo e(route('admin.periods.index',$period->academic_year_id)); ?>">
Volver
</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/periods/show.blade.php ENDPATH**/ ?>