<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/periods/edit.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2>Editar Periodo</h2>

<?php if(session('error')): ?>
<p style="color:red"><?php echo e(session('error')); ?></p>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.periods.update',$period->id)); ?>">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<label>Nombre</label><br>
<input type="text" name="name" value="<?php echo e($period->name); ?>"><br><br>

<label>Inicio</label><br>
<input type="date" name="start_date" value="<?php echo e($period->start_date); ?>"><br><br>

<label>Fin</label><br>
<input type="date" name="end_date" value="<?php echo e($period->end_date); ?>"><br><br>

<label>Porcentaje</label><br>
<input type="number" step="0.01" name="percentage" value="<?php echo e($period->percentage); ?>"><br><br>

<button>Guardar</button>

</form>

<br>
<a href="<?php echo e(route('admin.periods.index',$period->academic_year_id)); ?>">Volver</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/periods/edit.blade.php ENDPATH**/ ?>