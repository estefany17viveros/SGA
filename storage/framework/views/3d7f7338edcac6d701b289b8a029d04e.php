<?php $__env->startSection('title', 'Editar Estudiante'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/students/edit.css'); ?>    
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="edit-student-container">

    <!-- Header -->
    <div class="form-header">
        <h3>✏️ Editar Estudiante</h3>
        <p class="form-subtitle">Actualiza la información del estudiante</p>
    </div>

    <!-- ERRORES -->
    <?php if($errors->any()): ?>
        <div class="alert-error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>⚠️ <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="form-card">
        <form action="<?php echo e(route('admin.students.update', $student->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">

                <!-- Nombre -->
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="first_name"
                        value="<?php echo e(old('first_name', $student->first_name)); ?>"
                        class="form-input" required>
                </div>

                <!-- Apellido -->
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="last_name"
                        value="<?php echo e(old('last_name', $student->last_name)); ?>"
                        class="form-input" required>
                </div>

                <!-- Género -->
                <div class="form-group">
                    <label>Género</label>
                    <select name="gender" class="form-input">
                        <option value="masculino" <?php echo e(old('gender', $student->gender) == 'masculino' ? 'selected' : ''); ?>>Masculino</option>
                        <option value="femenino" <?php echo e(old('gender', $student->gender) == 'femenino' ? 'selected' : ''); ?>>Femenino</option>
                    </select>
                </div>

                <!-- ✅ FECHA CORREGIDA -->
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input 
                        type="date"
                        name="birth_date"
                        value="<?php echo e(old('birth_date', optional($student->birth_date)->format('Y-m-d'))); ?>"
                        class="form-input"
                        required
                    >
                </div>

                <!-- Documento -->
                <div class="form-group">
                    <label>Documento</label>
                    <input type="text" name="identification_number"
                        value="<?php echo e(old('identification_number', $student->identification_number)); ?>"
                        class="form-input" required>
                </div>

                <!-- EPS -->
                <div class="form-group">
                    <label>EPS</label>
                    <input type="text" name="eps"
                        value="<?php echo e(old('eps', $student->eps)); ?>"
                        class="form-input" required>
                </div>

                <!-- Tipo de población -->
                <div class="form-group">
                    <label>Tipo de población</label>
                    <select name="population_type" class="form-input">
                        <option value="ninguno" <?php echo e(old('population_type', $student->population_type) == 'ninguno' ? 'selected' : ''); ?>>Ninguno</option>
                        <option value="afro" <?php echo e(old('population_type', $student->population_type) == 'afro' ? 'selected' : ''); ?>>Afro</option>
                        <option value="indigena" <?php echo e(old('population_type', $student->population_type) == 'indigena' ? 'selected' : ''); ?>>Indígena</option>
                        <option value="desplazado" <?php echo e(old('population_type', $student->population_type) == 'desplazado' ? 'selected' : ''); ?>>Desplazado</option>
                    </select>
                </div>

                <!-- Certificado -->
                <div class="form-group full-width">
                    <label>Certificado población</label>

                    <?php if($student->population_certificate): ?>
                        <a href="<?php echo e(asset('storage/'.$student->population_certificate)); ?>" target="_blank">
                            📄 Ver actual
                        </a>
                    <?php endif; ?>

                    <input type="file" name="population_certificate" class="form-input">
                </div>

                <!-- Foto -->
                <div class="form-group full-width">
                    <label>Foto</label>

                    <?php if($student->photo): ?>
                        <img src="<?php echo e(asset('storage/'.$student->photo)); ?>" width="80">
                    <?php endif; ?>

                    <input type="file" name="photo" class="form-input">
                </div>

            </div>

            <!-- Botones -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.students.index')); ?>" class="btn-cancel">
                    Cancelar
                </a>

                <button type="submit" class="btn-submit">
                    💾 Actualizar
                </button>
            </div>

        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/students/edit.blade.php ENDPATH**/ ?>