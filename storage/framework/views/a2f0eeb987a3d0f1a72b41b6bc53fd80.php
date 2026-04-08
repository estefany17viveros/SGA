

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/students.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>👨‍🎓 Estudiantes</h2>

        
        <a href="<?php echo e(route('teacher.scores.index', $teacher_subject_id)); ?>" class="btn btn-primary">
            📊 Gestionar Notas
        </a>
    </div>

    <a href="<?php echo e(route('teacher.dashboard')); ?>">⬅ Volver al inicio</a>

    <div class="table-responsive mt-3">
        <table class="table table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Saber</th>
                    <th>Hacer</th>
                    <th>Ser</th>
                    <th>Comentario</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $score = $student->scores
                            ->where('teacher_subject_id', $teacher_subject_id)
                            ->first();
                    ?>

                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>

                        <td><?php echo e($student->full_name); ?></td>

                        
                        <td>
                            <span class="badge bg-secondary">
                                <?php echo e($score->saber ?? '-'); ?>

                            </span>
                        </td>

                        
                        <td>
                            <span class="badge bg-secondary">
                                <?php echo e($score->hacer ?? '-'); ?>

                            </span>
                        </td>

                        
                        <td>
                            <span class="badge bg-secondary">
                                <?php echo e($score->ser ?? '-'); ?>

                            </span>
                        </td>

                        
                        <td>
                            <?php echo e($score->comment ?? 'Sin comentario'); ?>

                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="6" class="text-center">
                            No hay estudiantes
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/students.blade.php ENDPATH**/ ?>