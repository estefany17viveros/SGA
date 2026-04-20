<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/teachers/edit.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<h2>✏️ Editar Profesor</h2>


<?php if($errors->any()): ?>
    <div style="color:red; margin-bottom:15px;">
        <strong>⚠️ Errores:</strong>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<?php if(session('success')): ?>
    <div style="color:green; margin-bottom:15px;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.teachers.update', $teacher->id)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    
    
    <?php if(auth()->id() === $teacher->user_id): ?>

        <label>Teléfono</label>
        <input type="text" name="phone" value="<?php echo e(old('phone', $teacher->phone)); ?>">

        <label>Dirección</label>
        <input type="text" name="address" value="<?php echo e(old('address', $teacher->address)); ?>">

        <label>Correo</label>
        <input type="email" name="email" value="<?php echo e(old('email', $teacher->user->email)); ?>">

    <?php else: ?>

    
    
    

        <label>Nombres</label>
        <input type="text" name="first_name" value="<?php echo e(old('first_name', $teacher->first_name)); ?>">

        <label>Apellidos</label>
        <input type="text" name="last_name" value="<?php echo e(old('last_name', $teacher->last_name)); ?>">

        <label>Género</label>
        <select name="gender">
            <option value="masculino" <?php echo e($teacher->gender=='masculino'?'selected':''); ?>>Masculino</option>
            <option value="femenino" <?php echo e($teacher->gender=='femenino'?'selected':''); ?>>Femenino</option>
            <option value="otro" <?php echo e($teacher->gender=='otro'?'selected':''); ?>>Otro</option>
        </select>

        <label>Tipo Documento</label>
        <select name="document_type">
            <option value="cc" <?php echo e($teacher->document_type=='cc'?'selected':''); ?>>CC</option>
            <option value="ti" <?php echo e($teacher->document_type=='ti'?'selected':''); ?>>TI</option>
            <option value="ce" <?php echo e($teacher->document_type=='ce'?'selected':''); ?>>CE</option>
            <option value="pasaporte" <?php echo e($teacher->document_type=='pasaporte'?'selected':''); ?>>Pasaporte</option>
        </select>

        <label>Número Documento</label>
        <input type="text" name="document_number" value="<?php echo e(old('document_number', $teacher->document_number)); ?>">

        <label>Departamento de Expedición</label>
        <input type="text" name="expedition_department" value="<?php echo e(old('expedition_department', $teacher->expedition_department)); ?>">

        <label>Municipio de Expedición</label>
        <input type="text" name="expedition_municipality" value="<?php echo e(old('expedition_municipality', $teacher->expedition_municipality)); ?>">

        
        <label>Fecha de Nacimiento</label>
        <input type="date" name="birth_date" value="<?php echo e(old('birth_date', optional($teacher->birth_date)->format('Y-m-d'))); ?>">

        <label>Fecha de Ingreso</label>
        <input type="date" name="start_date" value="<?php echo e(old('start_date', optional($teacher->start_date)->format('Y-m-d'))); ?>">

        <label>Fecha de Fin</label>
        <input type="date" name="end_date" value="<?php echo e(old('end_date', optional($teacher->end_date)->format('Y-m-d'))); ?>">

        <label>Teléfono</label>
        <input type="text" name="phone" value="<?php echo e(old('phone', $teacher->phone)); ?>">

        <label>Dirección</label>
        <input type="text" name="address" value="<?php echo e(old('address', $teacher->address)); ?>">

        <label>Especialidad</label>
        <input type="text" name="specialty" value="<?php echo e(old('specialty', $teacher->specialty)); ?>">

        
        <?php if($teacher->photo): ?>
            <p>Foto actual:</p>
            <img src="<?php echo e(asset('storage/'.$teacher->photo)); ?>" width="100">
        <?php endif; ?>

        <label>Nueva Foto</label>
        <input type="file" name="photo">

        
        <?php if($teacher->cv): ?>
            <p>
                <a href="<?php echo e(asset('storage/'.$teacher->cv)); ?>" target="_blank">
                    📄 Ver hoja de vida actual
                </a>
            </p>
        <?php endif; ?>

        <label>Subir nueva hoja de vida</label>
        <input type="file" name="cv">

        <label>
            <input type="checkbox" name="is_active" <?php echo e($teacher->is_active ? 'checked' : ''); ?>>
            Activo
        </label>

    <?php endif; ?>

    <br><br>
    <button type="submit">💾 Actualizar</button>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teachers/edit.blade.php ENDPATH**/ ?>