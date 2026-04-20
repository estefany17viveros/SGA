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
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td data-label="Profesor">
                            <strong><?php echo e($a->teacher->first_name ?? 'Sin docente'); ?></strong>
                            <span><?php echo e($a->teacher->last_name ?? ''); ?></span>
                        </td>

                        <td data-label="Materia">
                            <?php echo e($a->subject->name ?? 'Sin materia'); ?>

                        </td>

                        <td data-label="Grado">
                            <span class="badge-info"><?php echo e($a->grade->name ?? 'Sin grado'); ?></span>
                        </td>

                        <td data-label="Grupo">
                            <?php echo e($a->group ? $a->group->name : 'General'); ?>

                        </td>

                        <td data-label="Año">
                            <?php echo e($a->academicYear ? $a->academicYear->year : 'Sin año'); ?>

                        </td>

                        <td data-label="Acciones" class="actions-cell">
                            <a href="<?php echo e(route('admin.teacher-subjects.show', $a->id)); ?>" class="btn-action show" title="Ver">
                                👁️
                            </a>

                            <a href="<?php echo e(route('admin.teacher-subjects.edit', $a->id)); ?>" class="btn-action edit" title="Editar">
                                ✏️
                            </a>

                            <form action="<?php echo e(route('admin.teacher-subjects.destroy', $a->id)); ?>" method="POST" class="delete-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar esta asignación?')" title="Eliminar">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="empty-row">No hay registros encontrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/index.blade.php ENDPATH**/ ?>