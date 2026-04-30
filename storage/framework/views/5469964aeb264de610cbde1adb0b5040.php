<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/teachersubjects/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <h2>Asignaciones</h2>

    <div class="header-actions">
        <a href="<?php echo e(route('admin.teacher-subjects.create')); ?>" class="btn-create">
            <span>+</span> Nueva Asignación
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <p><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Profesor</th>
                    <th>Materia</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Año actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $a = $group->first();

                        $activeYear = $group->firstWhere('academicYear.status', 'activo');
                    ?>

                    <tr>
                        <td>
                            <strong><?php echo e($a->teacher->first_name ?? ''); ?></strong>
                            <?php echo e($a->teacher->last_name ?? ''); ?>

                        </td>

                        <td><?php echo e($a->subject->name ?? ''); ?></td>

                        <td><?php echo e($a->grade->name ?? ''); ?></td>

                        <td><?php echo e($a->group ? $a->group->name : 'General'); ?></td>

                        <td>
                            <?php echo e($activeYear->academicYear->year ?? 'Sin año activo'); ?>

                        </td>

                        <td class="actions-cell">

                            
                            <a href="<?php echo e(route('admin.teacher-subjects.history', $a->id)); ?>" class="btn-action show" title="Historial">
                                📅
                            </a>

                            
                            <a href="<?php echo e(route('admin.teacher-subjects.edit', $a->id)); ?>" class="btn-action edit" title="Editar">
                                ✏️
                            </a>

                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">No hay registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/index.blade.php ENDPATH**/ ?>