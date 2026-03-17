
<?php $__env->startSection('title', 'Crear Año Académico'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/academic_years/create.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>Editar Año Académico</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.academic_years.update', $academicYear->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label>Año</label>
            <input type="number"
                   name="year"
                   class="form-control"
                   value="<?php echo e(old('year', $academicYear->year)); ?>"
                   required>
        </div>

          <div class="mb-3">
            <label>Calendario</label>
           <select name="calendar" class="form-control" disabled>
    <option value="A" <?php echo e($academicYear->calendar == 'A' ? 'selected' : ''); ?>>A</option>
    <option value="B" <?php echo e($academicYear->calendar == 'B' ? 'selected' : ''); ?>>B</option>
</select>

<input type="hidden" name="calendar" value="<?php echo e($academicYear->calendar); ?>">
        </div>

        <div class="mb-3">
            <label>Períodos Académicos</label>
            <input type="number"
                   name="periods"
                   class="form-control"
                   value="<?php echo e(old('periods', $academicYear->periods)); ?>"
                   required>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="<?php echo e(route('admin.academic_years.index')); ?>" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/academic_years/edit.blade.php ENDPATH**/ ?>