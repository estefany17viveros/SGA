<?php $__env->startSection('title','Editar Acudiente'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/guardians/edit.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

<h3>Editar Acudiente</h3>

<div class="card">
<div class="card-body">

<form action="<?php echo e(route('admin.guardians.update',$guardian->id)); ?>" method="POST">

<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">

<div class="col-md-6">
<label>Estudiante</label>

<select name="student_id" class="form-control">

<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($student->id); ?>"
<?php echo e($guardian->student_id == $student->id ? 'selected' : ''); ?>>

<?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>


</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

</div>

<div class="col-md-6">
<label>Nombre Completo</label>

<input type="text"
name="first_name"
class="form-control"
value="<?php echo e($guardian->first_name); ?>">
</div>

<div class="col-md-6">
<label>Apellido</label>

<input type="text"
name="last_name"
class="form-control"
value="<?php echo e($guardian->last_name); ?>">
</div>

<div class="col-md-6">
<label>Parentesco</label>

<input type="text"
name="relationship"
class="form-control"
value="<?php echo e($guardian->relationship); ?>">
</div>

<div class="col-md-6">
<label>Identificación</label>

<input type="text"
name="identification_number"
class="form-control"
value="<?php echo e($guardian->identification_number); ?>">
</div>

<div class="col-md-6">
<label>Teléfono</label>

<input type="text"
name="phone"
class="form-control"
value="<?php echo e($guardian->phone); ?>">
</div>

<div class="col-md-6">
<label>Email</label>

<input type="email"
name="email"
class="form-control"
value="<?php echo e($guardian->email); ?>">
</div>

<div class="col-md-6">
<label>Ocupación</label>

<input type="text"
name="occupation"
class="form-control"
value="<?php echo e($guardian->occupation); ?>">
</div>

<div class="col-md-12">
<label>Dirección</label>

<input type="text"
name="address"
class="form-control"
value="<?php echo e($guardian->address); ?>">
</div>

</div>

<br>

<button class="btn btn-primary">
Actualizar
</button>

</form>

</div>
</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/guardians/edit.blade.php ENDPATH**/ ?>