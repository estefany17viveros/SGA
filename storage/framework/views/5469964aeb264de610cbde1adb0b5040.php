
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/teachersubjects/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2>Asignaciones</h2>

<a href="<?php echo e(route('admin.teacher-subjects.create')); ?>">Nueva Asignación</a>

<?php if(session('success')): ?>
    <p style="color:green"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Profesor</th>
            <th>Materia</th>
            <th>Grado</th>
            <th>Grupo</th>
            <th>Año</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <?php echo e($a->teacher->first_name ?? 'Sin docente'); ?>

                    <?php echo e($a->teacher->last_name ?? ''); ?>

                </td>

                <td>
                    <?php echo e($a->subject->name ?? 'Sin materia'); ?>

                </td>

                <td>
                    <?php echo e($a->grade->name ?? 'Sin grado'); ?>

                </td>

                <td>
                    <?php echo e($a->group ? $a->group->name : 'General'); ?>

                </td>

                
                <td>
                    <?php echo e($a->academicYear ? $a->academicYear->year : 'Sin año'); ?>

                </td>

                <td>
                    <a href="<?php echo e(route('admin.teacher-subjects.show', $a->id)); ?>">Ver</a>

                    <a href="<?php echo e(route('admin.teacher-subjects.edit', $a->id)); ?>">Editar</a>

                    <form action="<?php echo e(route('admin.teacher-subjects.destroy', $a->id)); ?>" method="POST" style="display:inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6">No hay registros</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/index.blade.php ENDPATH**/ ?>