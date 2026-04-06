
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/subjects/create.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h1>➕ Crear Materia</h1>

<?php if($errors->any()): ?>
    <div style="color:red;">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.subjects.store')); ?>">
    <?php echo csrf_field(); ?>

    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="<?php echo e(old('name')); ?>">
    </div>

    <div>
        <label>Descripción</label>
        <textarea name="description"><?php echo e(old('description')); ?></textarea>
    </div>

    <br>

    <button>💾 Guardar</button>
</form>

<br>

<a href="<?php echo e(route('admin.subjects.index')); ?>">⬅ Volver</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/subjects/create.blade.php ENDPATH**/ ?>