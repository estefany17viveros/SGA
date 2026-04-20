<?php $__env->startSection('title','Detalle Acudiente'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/guardians/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

<h3>Detalle del Acudiente</h3>

<div class="card">

<div class="card-body">

<p><strong>Nombre:</strong> <?php echo e($guardian->first_name); ?></p>

<p><strong>Apellido:</strong> <?php echo e($guardian->last_name); ?></p>

<p><strong>Parentesco:</strong> <?php echo e($guardian->relationship); ?></p>

<p><strong>Identificación:</strong> <?php echo e($guardian->identification_number); ?></p>

<p><strong>Teléfono:</strong> <?php echo e($guardian->phone); ?></p>

<p><strong>Email:</strong> <?php echo e($guardian->email); ?></p>

<p><strong>Ocupación:</strong> <?php echo e($guardian->occupation); ?></p>

<p><strong>Dirección:</strong> <?php echo e($guardian->address); ?></p>

<p><strong>Estudiante:</strong> <?php echo e($guardian->student->full_name ?? ''); ?></p>

<a href="<?php echo e(route('admin.guardians.index')); ?>"
class="btn btn-secondary">
Volver
</a>

</div>

</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/guardians/show.blade.php ENDPATH**/ ?>