
<?php $__env->startSection('title', 'Crear Grado'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/grades/edit.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>Editar Grado</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.grades.update',$grade)); ?>" method="POST">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">

            <label class="form-label">Grado</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="<?php echo e(old('name',$grade->name)); ?>"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">Nivel</label>

            <input type="number"
                   name="level"
                   class="form-control"
                   value="<?php echo e(old('level',$grade->level)); ?>"
                   required>

        </div>
<div>
    <label for="director_id">Director de grupo</label>

    <select name="director_id" id="director_id" class="mt-1 block w-full border rounded p-2">

        <option value="">-- Sin director --</option>

        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($teacher->id); ?>"
                <?php echo e($grade->director_id == $teacher->id ? 'selected' : ''); ?>>
                
                <?php echo e($teacher->full_name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </select>
</div>
        <button class="btn btn-primary">
            Actualizar
        </button>

        <a href="<?php echo e(route('admin.grades.index')); ?>"
           class="btn btn-secondary">
           Cancelar
        </a>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/grades/edit.blade.php ENDPATH**/ ?>