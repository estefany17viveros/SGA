

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/grades.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <h2>🎓 Grados</h2>

    <a href="<?php echo e(route('teacher.dashboard')); ?>">⬅ Volver</a>

    <div class="grid">

        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="card">

                <h3><?php echo e($grade['grade_name']); ?></h3>

                <a href="<?php echo e(route('teacher.subject.students', [$subjectId, $grade['grade_id']])); ?>" class="btn">
                    Ver estudiantes
                </a>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/grades.blade.php ENDPATH**/ ?>