
<?php $__env->startSection('title', 'Crear Año Académico'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/academic_years/create.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>Crear Año Académico</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.academic_years.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label>Año</label>
            <input type="number" name="year"
                   class="form-control"
                   value="<?php echo e(old('year')); ?>"
                   required>
        </div>

        <div class="mb-3">
            <label>Calendario</label>
            <select name="calendar" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="A" <?php echo e(old('calendar') == 'A' ? 'selected' : ''); ?>>A (Enero - Diciembre)</option>
                <option value="B" <?php echo e(old('calendar') == 'B' ? 'selected' : ''); ?>>B (Julio - Junio)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Trimestres Académicos</label>
            <input type="number" name="periods"
                   class="form-control"
                   value="<?php echo e(old('periods')); ?>"
                   required>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="<?php echo e(route('admin.academic_years.index')); ?>" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/academic_years/create.blade.php ENDPATH**/ ?>