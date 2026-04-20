<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/teachersubjects/show.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <h2 class="mb-4">📘 Detalle de Asignación</h2>

    <div class="detail-card">

        
        <div class="detail-row">
            <span class="detail-label">Profesor</span>
            <span class="detail-value">
                <?php echo e($assignment->teacher->first_name); ?> <?php echo e($assignment->teacher->last_name); ?>

            </span>
        </div>

        
        <div class="detail-row">
            <span class="detail-label">Materia</span>
            <span class="detail-value">
                <?php echo e($assignment->subject->name); ?>

            </span>
        </div>

        
        <div class="detail-row">
            <span class="detail-label">Grado</span>
            <span class="detail-value">
                <?php echo e($assignment->grade->name); ?>

            </span>
        </div>

        
        <div class="detail-row">
            <span class="detail-label">Grupo</span>
            <span class="detail-value">
                <?php echo e($assignment->group ? $assignment->group->name : 'General'); ?>

            </span>
        </div>

        
        <div class="detail-row">
            <span class="detail-label">Año</span>
            <span class="detail-value">
                <?php echo e($assignment->academicYear->year); ?>

            </span>
        </div>

        
        <div class="detail-row">
            <span class="detail-label">Estado</span>
            <span class="detail-value">
                <span class="badge <?php echo e($assignment->status ? 'badge-activo' : 'badge-inactivo'); ?>">
                    <?php echo e($assignment->status ? 'Activo' : 'Inactivo'); ?>

                </span>
            </span>
        </div>

    </div>

    
    <div class="mt-4">
        <a href="<?php echo e(route('admin.teacher-subjects.index')); ?>" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_subjects/show.blade.php ENDPATH**/ ?>