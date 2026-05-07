<?php $__env->startSection('title', 'Editar Estudiante'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/students/edit.css'); ?>    
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="edit-student-container">

    <div class="form-header">
        <h3>✏️ Editar Estudiante</h3>
        <p class="form-subtitle">Actualiza la información del estudiante</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert-error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>⚠️ <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-card">

        <form action="<?php echo e(route('admin.students.update', $student->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="first_name"
                        value="<?php echo e($student->first_name); ?>"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="last_name"
                        value="<?php echo e($student->last_name); ?>"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>Género</label>
                    <select name="gender" class="form-input">
                        <option value="masculino" <?php echo e($student->gender == 'masculino' ? 'selected' : ''); ?>>Masculino</option>
                        <option value="femenino" <?php echo e($student->gender == 'femenino' ? 'selected' : ''); ?>>Femenino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date"
                        name="birth_date"
                        value="<?php echo e(optional($student->birth_date)->format('Y-m-d')); ?>"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>Documento</label>
                    <input type="text"
                        name="identification_number"
                        value="<?php echo e($student->identification_number); ?>"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label>EPS</label>
                    <input type="text"
                        name="eps"
                        value="<?php echo e($student->eps); ?>"
                        class="form-input">
                </div>

                
                <div class="form-group full-width">
                    <label>Observación del estudiante</label>
                    <textarea name="observations" class="form-input" rows="4">
<?php echo e($student->observations); ?>

                    </textarea>
                </div>

                
                <div class="form-group full-width">
                    <label>Certificado (PDF)</label>

                    <?php if($student->certificate_file): ?>
                        <a href="<?php echo e(asset('storage/'.$student->certificate_file)); ?>" target="_blank">
                            📄 Ver archivo actual
                        </a>
                    <?php endif; ?>

                    <input type="file" name="certificate_file" class="form-input">
                </div>

                
                <div class="form-group full-width">
                    <label>Foto</label>

                    <?php if($student->photo): ?>
                        <img src="<?php echo e(asset('storage/'.$student->photo)); ?>" width="80">
                    <?php endif; ?>

                    <input type="file" name="photo" class="form-input">
                </div>

            </div>

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