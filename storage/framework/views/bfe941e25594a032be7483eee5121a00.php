


<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/students/create.css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

<h3 class="mb-4">Crear Estudiante</h3>

<?php if($errors->any()): ?>
<div class="alert alert-danger">

<strong>Por favor corrige los siguientes errores:</strong>

<ul class="mb-0 mt-2">
<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li><?php echo e($error); ?></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

</div>
<?php endif; ?>


<form action="<?php echo e(route('admin.students.store')); ?>" method="POST" enctype="multipart/form-data" novalidate>
<?php echo csrf_field(); ?>



<div class="card step active" id="step1">

<div class="card-header bg-primary text-white">
Paso 1 - Información del estudiante
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">
<label>Foto</label>
<input type="file" name="photo" class="form-control">
</div>

<div class="col-md-4">
<label>Nombre</label>
<input type="text" name="first_name" value="<?php echo e(old('first_name')); ?>"
class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-4">
<label>Apellido</label>
<input type="text" name="last_name" value="<?php echo e(old('last_name')); ?>"
class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="col-md-4 mt-3">

<label>Genero</label>

<select name="gender"
class="form-control <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Seleccione</option>

<option value="masculino" <?php echo e(old('gender')=='masculino'?'selected':''); ?>>Masculino</option>
<option value="femenino" <?php echo e(old('gender')=='femenino'?'selected':''); ?>>Femenino</option>

</select>

<?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-4 mt-3">

<label>Fecha nacimiento</label>

<input type="date" name="birth_date"
value="<?php echo e(old('birth_date')); ?>"
class="form-control <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-4 mt-3">

<label>Tipo documento</label>

<select name="identification_type"
class="form-control <?php $__errorArgs = ['identification_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Seleccione</option>

<option value="registro_civil" <?php echo e(old('identification_type')=='registro_civil'?'selected':''); ?>>Registro Civil</option>
<option value="tarjeta_identidad" <?php echo e(old('identification_type')=='tarjeta_identidad'?'selected':''); ?>>Tarjeta Identidad</option>
<option value="cedula_ciudadania" <?php echo e(old('identification_type')=='cedula_ciudadania'?'selected':''); ?>>Cédula Ciudadanía</option>
<option value="cedula_extranjeria" <?php echo e(old('identification_type')=='cedula_extranjeria'?'selected':''); ?>>Cédula Extranjería</option>
<option value="pasaporte" <?php echo e(old('identification_type')=='pasaporte'?'selected':''); ?>>Pasaporte</option>

</select>

<?php $__errorArgs = ['identification_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-4 mt-3">

<label>Número documento</label>

<input type="text" name="identification_number"
value="<?php echo e(old('identification_number')); ?>"
class="form-control <?php $__errorArgs = ['identification_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['identification_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-4 mt-3">

<label>Fecha expedición</label>

<input type="date" name="expedition_date"
value="<?php echo e(old('expedition_date')); ?>"
class="form-control <?php $__errorArgs = ['expedition_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['expedition_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-4 mt-3">

<label>Departamento expedición</label>

<input type="text" name="expedition_department"
value="<?php echo e(old('expedition_department')); ?>"
class="form-control <?php $__errorArgs = ['expedition_department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['expedition_department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-6 mt-3">

<label>Municipio expedición</label>

<input type="text" name="expedition_municipality"
value="<?php echo e(old('expedition_municipality')); ?>"
class="form-control <?php $__errorArgs = ['expedition_municipality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['expedition_municipality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-6 mt-3">

<label>Dirección</label>

<input type="text" name="address"
value="<?php echo e(old('address')); ?>"
class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>

</div>

<div class="text-end mt-4">
<button type="button" class="btn btn-primary" onclick="nextStep()">Siguiente</button>
</div>

</div>
</div>




<div class="card step" id="step2">

<div class="card-header bg-success text-white">
Paso 2 - Información de salud
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>EPS</label>

<input type="text" name="eps"
value="<?php echo e(old('eps')); ?>"
class="form-control <?php $__errorArgs = ['eps'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['eps'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-6">

<label>Tipo de sangre</label>

<select name="blood_type"
class="form-control <?php $__errorArgs = ['blood_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Seleccione</option>

<option <?php echo e(old('blood_type')=='A+'?'selected':''); ?>>A+</option>
<option <?php echo e(old('blood_type')=='A-'?'selected':''); ?>>A-</option>
<option <?php echo e(old('blood_type')=='B+'?'selected':''); ?>>B+</option>
<option <?php echo e(old('blood_type')=='B-'?'selected':''); ?>>B-</option>
<option <?php echo e(old('blood_type')=='AB+'?'selected':''); ?>>AB+</option>
<option <?php echo e(old('blood_type')=='AB-'?'selected':''); ?>>AB-</option>
<option <?php echo e(old('blood_type')=='O+'?'selected':''); ?>>O+</option>
<option <?php echo e(old('blood_type')=='O-'?'selected':''); ?>>O-</option>

</select>

<?php $__errorArgs = ['blood_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-12 mt-3">

<label>Condiciones médicas</label>

<textarea name="medical_conditions"
class="form-control"><?php echo e(old('medical_conditions')); ?></textarea>

</div>

</div>

<div class="d-flex justify-content-between mt-4">

<button type="button" class="btn btn-secondary" onclick="prevStep()">Anterior</button>
<button type="button" class="btn btn-primary" onclick="nextStep()">Siguiente</button>

</div>

</div>
</div>




<div class="card step" id="step3">

<div class="card-header bg-dark text-white">
Paso 3 - Información adicional
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>PDF certificado</label>

<input type="file" name="certificate_file"
class="form-control <?php $__errorArgs = ['certificate_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['certificate_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<div class="invalid-feedback"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>


<div class="col-md-12 mt-3">

<label>Observaciones</label>

<textarea name="observations"
class="form-control"><?php echo e(old('observations')); ?></textarea>

</div>

</div>

<div class="d-flex justify-content-between mt-4">

<button type="button" class="btn btn-secondary" onclick="prevStep()">Anterior</button>

<button type="submit" class="btn btn-success">
Guardar Estudiante
</button>

</div>

</div>
</div>

</form>

</div>


<script>

let currentStep = 1;
const totalSteps = 3;

function showStep(step){

document.querySelectorAll('.step').forEach((card)=>{
card.classList.remove('active');
});

document.getElementById('step'+step).classList.add('active');

}

function nextStep(){

if(currentStep < totalSteps){
currentStep++;
showStep(currentStep);
}

}

function prevStep(){

if(currentStep > 1){
currentStep--;
showStep(currentStep);
}

}


<?php if($errors->any()): ?>

let stepError = 1;

<?php if($errors->has('eps') || $errors->has('blood_type') ): ?>
stepError = 2;
<?php endif; ?>

<?php if($errors->has('certificate_file')): ?>
stepError = 3;
<?php endif; ?>

currentStep = stepError;
showStep(currentStep);

<?php endif; ?>

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/students/create.blade.php ENDPATH**/ ?>