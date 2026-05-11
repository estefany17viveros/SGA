
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/boletin/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <h2>📊 Boletines por Grado</h2>

    <div class="row">

        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-3 mb-3">
                <div class="card shadow">

                    <div class="card-body text-center">

                        <h4>Grado <?php echo e($grade->name); ?></h4>

                        <a href="<?php echo e(route('admin.boletin.grade',$grade->id)); ?>"
                           class="btn btn-primary mt-2">
                            Ver estudiantes
                        </a>

                    </div>

                </div>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/boletin/index.blade.php ENDPATH**/ ?>