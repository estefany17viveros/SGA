<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/teachersubjects/edit.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2>Editar Asignación</h2>

<?php if($errors->any()): ?>
    <div style="color:red;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p>• <?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('admin.teacher-subjects.update', $assignment->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <label>Profesor</label>
    <select name="teacher_id">
        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($t->id); ?>"
                <?php echo e($assignment->teacher_id == $t->id ? 'selected' : ''); ?>>
                <?php echo e($t->first_name); ?> <?php echo e($t->last_name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <br><br>

    <label>Materia</label>
    <select name="subject_id">
        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s->id); ?>"
                <?php echo e($assignment->subject_id == $s->id ? 'selected' : ''); ?>>
                <?php echo e($s->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <br><br>

    <label>Grado</label>
    <select name="grade_id">
        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($g->id); ?>"
                <?php echo e($assignment->grade_id == $g->id ? 'selected' : ''); ?>>
                <?php echo e($g->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <br><br>

    <label>Grupo (Opcional)</label>
    <select name="group_id">
        <option value="">Sin grupo</option>
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($g->id); ?>"
                <?php echo e($assignment->group_id == $g->id ? 'selected' : ''); ?>>
                <?php echo e($g->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <br><br>

    <label>Estado</label>
    <select name="status">
        <option value="1" <?php echo e($assignment->status ? 'selected' : ''); ?>>Activo</option>
        <option value="0" <?php echo e(!$assignment->status ? 'selected' : ''); ?>>Inactivo</option>
    </select>

    <br><br>

    <button type="submit">
    <i class="fas fa-sync-alt"></i> Actualizar Asignación
</button>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/edit.blade.php ENDPATH**/ ?>