

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/dashboard.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    
    <h2>📚 Mis Asignaturas</h2>

    <div class="grid">

        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div class="card">

                <h3>
                    <?php echo e($subject['subject'] ?? 'Sin materia'); ?>

                </h3>

                <a href="<?php echo e(route('teacher.subject.grades', $subject['subject_id'])); ?>" class="btn">
                    Ver grados
                </a>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <div class="empty-state">
                <p>No tienes asignaturas asignadas.</p>
            </div>

        <?php endif; ?>

    </div>


    
    <?php if(isset($directorGrades) && $directorGrades->count() > 0): ?>

        <hr class="section-divider">

        <h2>📌 Dirección de grupo</h2>

        <div class="grid">

            <?php $__currentLoopData = $directorGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="card director-card">

                    <h3>👩‍🏫 Director de grupo</h3>

                    <p>
                        <strong>Grado:</strong> <?php echo e($grade->name); ?>

                    </p>

                    
                    <a href="<?php echo e(route('teacher.director.students', $grade->id)); ?>" class="btn btn-primary">
                        👨 Disciplina y Comportamiento
                    </a>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php else: ?>

        <div class="empty-state">
            <p>No eres director de ningún grado.</p>
        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/dashboard.blade.php ENDPATH**/ ?>