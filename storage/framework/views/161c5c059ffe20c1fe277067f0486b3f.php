


<?php $__env->startSection('title','Registrar Acudiente'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/guardians/create.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

<h3>👨‍👩‍👦 Registrar Acudiente del Estudiante</h3>

<div class="card">
<div class="card-body">

<?php if($errors->any()): ?>
<div class="alert alert-danger">
<strong>Corrige los siguientes errores:</strong>
<ul class="mb-0 mt-2">
<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li><?php echo e($error); ?></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
</div>
<?php endif; ?>


<form action="<?php echo e(route('admin.guardians.store')); ?>" method="POST">

<?php echo csrf_field(); ?>

<!-- estudiante vinculado automáticamente -->
<input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">


<div class="mb-3">
<label class="form-label"><strong>Estudiante</strong></label>
<input type="text" class="form-control"
value="<?php echo e($student->full_name); ?>" readonly>
</div>


<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Nombre del Acudiente</label>
<input type="text" name="first_name"
class="form-control"
value="<?php echo e(old('first_name')); ?>"
required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Apellido del Acudiente</label>
<input type="text" name="last_name"
class="form-control"
value="<?php echo e(old('last_name')); ?>"
required>
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Parentesco</label>
<select name="relationship" class="form-control" required>

<option value="">Seleccione</option>

<option value="Padre" <?php echo e(old('relationship')=='Padre'?'selected':''); ?>>
Padre
</option>

<option value="Madre" <?php echo e(old('relationship')=='Madre'?'selected':''); ?>>
Madre
</option>

<option value="Tutor" <?php echo e(old('relationship')=='Tutor'?'selected':''); ?>>
Tutor
</option>

<option value="Otro" <?php echo e(old('relationship')=='Otro'?'selected':''); ?>>
Otro
</option>

</select>
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Número de Identificación</label>
<input type="text"
name="identification_number"
class="form-control"
value="<?php echo e(old('identification_number')); ?>">
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Teléfono</label>
<input type="text"
name="phone"
class="form-control"
value="<?php echo e(old('phone')); ?>"
required>
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Correo Electrónico</label>
<input type="email"
name="email"
class="form-control"
value="<?php echo e(old('email')); ?>">
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Ocupación</label>
<input type="text"
name="occupation"
class="form-control"
value="<?php echo e(old('occupation')); ?>">
</div>


<div class="col-md-12 mb-3">
<label class="form-label">Dirección</label>
<input type="text"
name="address"
class="form-control"
value="<?php echo e(old('address')); ?>">
</div>

</div>


<div class="mt-3">

<button class="btn btn-success">
💾 Guardar Acudiente
</button>

<a href="<?php echo e(route('admin.students.show',$student->id)); ?>"
class="btn btn-secondary">
Cancelar
</a>

</div>

</form>

</div>
</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/guardians/create.blade.php ENDPATH**/ ?>