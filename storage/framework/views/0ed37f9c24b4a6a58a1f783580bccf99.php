
<?php $__env->startSection('title', 'Crear Grado'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/grades/create.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>Crear Grado</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.grades.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        
        <div class="mb-3">
            <label class="form-label">Grado</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="<?php echo e(old('name')); ?>"
                   placeholder="Ej: Sexto"
                   required>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Nivel</label>

            <input type="number"
                   name="level"
                   class="form-control"
                   value="<?php echo e(old('level')); ?>"
                   placeholder="Ej: 6"
                   required>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Director de grupo</label>

            <select name="director_id" class="form-control">
                <option value="">Sin director</option>

                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($teacher->id); ?>">
                        <?php echo e($teacher->full_name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <button class="btn btn-success">
            Guardar
        </button>

        <a href="<?php echo e(route('admin.grades.index')); ?>"
           class="btn btn-secondary">
           Cancelar
        </a>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/grades/create.blade.php ENDPATH**/ ?>