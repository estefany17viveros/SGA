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

    <!-- Formulario -->
    <div class="form-card">
        <form action="<?php echo e(route('admin.students.update', $student)); ?>" method="POST" enctype="multipart/form-data" class="edit-form">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">

                <!-- Nombre -->
                <div class="form-group">
                    <label for="first_name">
                        <span class="label-icon">✏️</span>
                        Nombre
                    </label>
                    <input 
                        type="text" 
                        id="first_name"
                        name="first_name" 
                        value="<?php echo e(old('first_name', $student->first_name)); ?>" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Apellido -->
                <div class="form-group">
                    <label for="last_name">
                        <span class="label-icon">✏️</span>
                        Apellido
                    </label>
                    <input 
                        type="text" 
                        id="last_name"
                        name="last_name" 
                        value="<?php echo e(old('last_name', $student->last_name)); ?>" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Género -->
                <div class="form-group">
                    <label for="gender">
                        <span class="label-icon">⚧️</span>
                        Género
                    </label>
                    <select name="gender" id="gender" class="form-input">
                        <option value="masculino" <?php echo e(old('gender', $student->gender) == 'masculino' ? 'selected' : ''); ?>>
                            Masculino
                        </option>
                        <option value="femenino" <?php echo e(old('gender', $student->gender) == 'femenino' ? 'selected' : ''); ?>>
                            Femenino
                        </option>
                    </select>
                </div>

                <!-- Fecha de nacimiento -->
                <div class="form-group">
                    <label for="birth_date">
                        <span class="label-icon">📅</span>
                        Fecha de Nacimiento
                    </label>
                    <input 
                        type="date" 
                        id="birth_date"
                        name="birth_date"
                        value="<?php echo e(old('birth_date', $student->birth_date->format('Y-m-d'))); ?>"
                        class="form-input"
                        required
                    >
                </div>

                <!-- Documento -->
                <div class="form-group">
                    <label for="identification_number">
                        <span class="label-icon">🆔</span>
                        Número de Documento
                    </label>
                    <input 
                        type="text" 
                        id="identification_number"
                        name="identification_number"
                        value="<?php echo e(old('identification_number', $student->identification_number)); ?>"
                        class="form-input"
                        required
                    >
                </div>

                <!-- EPS -->
                <div class="form-group">
                    <label for="eps">
                        <span class="label-icon">🏥</span>
                        EPS
                    </label>
                    <input 
                        type="text" 
                        id="eps"
                        name="eps"
                        value="<?php echo e(old('eps', $student->eps)); ?>"
                        class="form-input"
                        required
                    >
                </div>
<!-- Tipo de población -->
<div class="form-group">
    <label>
        <span class="label-icon">🌎</span>
        Tipo de población
    </label>

    <select name="population_type" class="form-input" id="population_type">

        <option value="ninguno"
            <?php echo e(old('population_type', $student->population_type) == 'ninguno' ? 'selected' : ''); ?>>
            Ninguno
        </option>

        <option value="afro"
            <?php echo e(old('population_type', $student->population_type) == 'afro' ? 'selected' : ''); ?>>
            Afro
        </option>

        <option value="indigena"
            <?php echo e(old('population_type', $student->population_type) == 'indigena' ? 'selected' : ''); ?>>
            Indígena
        </option>

        <option value="desplazado"
            <?php echo e(old('population_type', $student->population_type) == 'desplazado' ? 'selected' : ''); ?>>
            Desplazado
        </option>

    </select>
</div>


<!-- Certificado población -->
<div class="form-group full-width" id="certificado_container">
    <label>
        <span class="label-icon">📄</span>
        Certificado población (PDF)
    </label>

    <?php if($student->population_certificate): ?>
        <div class="current-photo">
            <a href="<?php echo e(asset('storage/'.$student->population_certificate)); ?>"
               target="_blank"
               class="btn-certificate">
               📄 Ver certificado actual
            </a>
        </div>
    <?php endif; ?>

    <input 
        type="file" 
        name="population_certificate"
        class="form-input file-input"
        accept="application/pdf"
    >

    <small class="form-hint">
        Solo PDF. Subir solo si deseas cambiarlo.
    </small>
</div>
                <!-- Foto -->
                <div class="form-group full-width">
                    <label for="photo">
                        <span class="label-icon">📷</span>
                        Foto
                    </label>
                    
                    <?php if($student->photo): ?>
                        <div class="current-photo">
                            <img src="<?php echo e(asset('storage/'.$student->photo)); ?>" alt="Foto actual" class="photo-preview">
                            <span class="photo-label">Foto actual</span>
                        </div>
                    <?php endif; ?>
                    
                    <input 
                        type="file" 
                        id="photo"
                        name="photo" 
                        class="form-input file-input"
                        accept="image/*"
                    >
                    <small class="form-hint">Selecciona una nueva foto si deseas cambiarla</small>
                </div>

            </div>

            <!-- Botones de acción -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.students.index')); ?>" class="btn-cancel">
                    <span class="icon">❌</span>
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    <span class="icon">💾</span>
                    Actualizar Estudiante
                </button>
            </div>

        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/students/edit.blade.php ENDPATH**/ ?>