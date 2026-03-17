
<?php $__env->startSection('title', 'Editar Matrícula'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/enrollments/edit.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

<h2>Editar Matrícula</h2>

<form action="<?php echo e(route('admin.enrollments.update',$enrollment->id)); ?>" method="POST">

<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="mb-3">

<label>Grado</label>

<select name="grade_id" class="form-control">

<?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($grade->id); ?>"
<?php echo e($enrollment->grade_id == $grade->id ? 'selected' : ''); ?>>
<?php echo e($grade->name); ?>

</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

</div>

<div class="mb-3">

<label>Grupo</label>

<select name="group_id" class="form-control">

<option value="">Sin grupo</option>

<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($group->id); ?>"
<?php echo e($enrollment->group_id == $group->id ? 'selected' : ''); ?>>
<?php echo e($group->name); ?>

</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

</div>

<div class="mb-3">

<label>Estado</label>

<select name="status" class="form-control">

<option value="matriculado">Matriculado</option>
<option value="aprobado">Aprobado</option>
<option value="reprobado">Reprobado</option>
<option value="retirado">Retirado</option>

</select>

</div>

<button class="btn btn-primary">
Actualizar
</button>

<a href="<?php echo e(route('admin.enrollments.index')); ?>"
class="btn btn-secondary">
Volver </a>

</form>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/edit.blade.php ENDPATH**/ ?>