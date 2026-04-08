<?php $__env->startSection('title', 'Crear Perfil de Profesor'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teachers/create.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="profile-form-container">

    <div class="form-header">
        <h2>👨‍🏫 Crear Perfil de Profesor</h2>
        <p class="form-subtitle">Completa todos los datos del nuevo profesor</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="error-message">
            <strong>⚠️ Se encontraron errores:</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="success-message">
            <span class="message-icon">✓</span>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form method="POST"
          action="<?php echo e(route('admin.teachers.store')); ?>"
          class="teacher-form"
          enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="form-section">
            <h4>📋 Datos Personales</h4>

            <div class="form-group full-width">
                <label for="photo">🖼 Foto del Profesor</label>
                <input type="file" id="photo" name="photo" class="form-input" accept="image/*">
            </div>

            <div class="form-grid">

                
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="first_name" class="form-input" value="<?php echo e(old('first_name')); ?>" required>
                </div>

                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="last_name" class="form-input" value="<?php echo e(old('last_name')); ?>" required>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="phone" class="form-input" value="<?php echo e(old('phone')); ?>">
                </div>

                <div class="form-group full-width">
                    <label>Dirección</label>
                    <input type="text" name="address" class="form-input" value="<?php echo e(old('address')); ?>">
                </div>

                <div class="form-group full-width">
                    <label>Especialidad</label>
                    <input type="text" name="specialty" class="form-input" value="<?php echo e(old('specialty')); ?>">
                </div>

                
                
                <div class="form-group">
                    <label>Género</label>
                    <select name="gender" class="form-input" required>
                        <option value="">Seleccione</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipo Documento</label>
                    <select name="document_type" class="form-input" required>
                        <option value="">Seleccione</option>
                        <option value="cc">CC</option>
                        <option value="ti">TI</option>
                        <option value="ce">CE</option>
                        <option value="pasaporte">Pasaporte</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Número Documento</label>
                    <input type="text" name="document_number" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Departamento Expedición</label>
                    <input type="text" name="expedition_department" class="form-input">
                </div>

                <div class="form-group">
                    <label>Municipio Expedición</label>
                    <input type="text" name="expedition_municipality" class="form-input">
                </div>

                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="birth_date" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Fecha de Ingreso</label>
                    <input type="date" name="start_date" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Fecha de Fin</label>
                    <input type="date" name="end_date" class="form-input">
                </div>

                <div class="form-group full-width">
                    <label>Hoja de Vida (PDF)</label>
                    <input type="file" name="cv" class="form-input">
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" checked>
                        Usuario Activo
                    </label>
                </div>

            </div>
        </div>

        <div class="form-section">
            <h4>🔐 Datos de Acceso</h4>

            <div class="form-group full-width">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-input" value="<?php echo e(old('email')); ?>" required>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('admin.teachers.index')); ?>" class="btn-cancel">❌ Cancelar</a>
            <button type="submit" class="btn-submit">💾 Crear Profesor</button>
        </div>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teachers/create.blade.php ENDPATH**/ ?>