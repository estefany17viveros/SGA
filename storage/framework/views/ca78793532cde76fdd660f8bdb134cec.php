
<?php $__env->startSection('title', 'Crear Matrícula'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/enrollments/create.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

<h2>Crear Matrícula</h2>


<?php if($errors->any()): ?>

<div class="alert alert-danger">
<strong>Se encontraron errores:</strong>
<ul>
<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li><?php echo e($error); ?></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
</div>
<?php endif; ?>


<?php if(session('error')): ?>

<div class="alert alert-danger">
<?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<?php if(session('success')): ?>

<div class="alert alert-success">
<?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<form action="<?php echo e(route('admin.enrollments.store')); ?>" method="POST">

<?php echo csrf_field(); ?>

<div class="mb-3">
<label>Estudiante</label>

<select name="student_id" class="form-control">

<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($student->id); ?>">
<?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>
</div>

<div class="mb-3">
<label>Grado</label>

<select name="grade_id" class="form-control">

<?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($grade->id); ?>">
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

<option value="<?php echo e($group->id); ?>">
<?php echo e($group->name); ?>

</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>
</div>

<button class="btn btn-success">
Guardar Matrícula
</button>

<a href="<?php echo e(route('admin.enrollments.index')); ?>"
class="btn btn-secondary">
Cancelar </a>

</form>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/create.blade.php ENDPATH**/ ?>