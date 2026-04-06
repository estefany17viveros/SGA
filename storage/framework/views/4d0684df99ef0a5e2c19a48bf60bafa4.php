

<?php $__env->startSection('content'); ?>

<h2>Detalle de Asignación</h2>

<p><strong>Profesor:</strong> <?php echo e($assignment->teacher->first_name); ?> <?php echo e($assignment->teacher->last_name); ?></p>
<p><strong>Materia:</strong> <?php echo e($assignment->subject->name); ?></p>
<p><strong>Grado:</strong> <?php echo e($assignment->grade->name); ?></p>
<p><strong>Grupo:</strong> <?php echo e($assignment->group ? $assignment->group->name : 'General'); ?></p>
<p><strong>Año:</strong> <?php echo e($assignment->academicYear->year); ?></p>
<p><strong>Estado:</strong> <?php echo e($assignment->status ? 'Activo' : 'Inactivo'); ?></p>

<a href="<?php echo e(route('admin.teacher-subjects.index')); ?>">Volver</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/show.blade.php ENDPATH**/ ?>