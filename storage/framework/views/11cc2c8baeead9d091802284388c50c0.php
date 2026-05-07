
<?php $__env->startSection('title', 'Detalle de Matrícula'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/enrollments/show.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

<h2>Detalle de Matrícula</h2>

<div class="card">
<div class="card-body">

<p>
<strong>Estudiante:</strong>
<?php echo e($enrollment->student->first_name); ?>

<?php echo e($enrollment->student->last_name); ?>

</p>

<p>
<strong>Grado:</strong>
<?php echo e($enrollment->grade->name); ?>

</p>

<p>
<strong>Grupo:</strong>
<?php echo e($enrollment->group->name ?? 'Sin grupo'); ?>

</p>

<p>
<strong>Estado:</strong>
<?php echo e($enrollment->status); ?>

</p>

<a href="<?php echo e(route('admin.enrollments.index')); ?>"
class="btn btn-secondary">
Volver </a>

</div>
</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/show.blade.php ENDPATH**/ ?>