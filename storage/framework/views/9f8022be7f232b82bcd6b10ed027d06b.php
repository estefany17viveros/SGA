

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/teachersubjects/history.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    <h3>📅 Historial de años</h3>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Año</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td data-label="Año">
                            <?php echo e($h->academicYear->year); ?>

                        </td>
                        <td data-label="Estado">
                            <?php
                                $status = strtolower($h->academicYear->status);
                                $badgeClass = match($status) {
                                    'activo'   => 'badge-activo',
                                    'cerrado'  => 'badge-cerrado',
                                    default    => 'badge-inactivo',
                                };
                            ?>
                            <span class="badge-estado <?php echo e($badgeClass); ?>">
                                <?php echo e($h->academicYear->status); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" class="empty-row">
                            No hay registros en el historial.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="<?php echo e(route('admin.teacher-subjects.index')); ?>" class="btn btn-secondary">
        ← Volver
    </a>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/history.blade.php ENDPATH**/ ?>