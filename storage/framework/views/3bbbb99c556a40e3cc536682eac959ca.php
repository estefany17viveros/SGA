
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/subjects/edit.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h1>✏️ Editar Materia</h1>

<?php if($errors->any()): ?>
    <div style="color:red;">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.subjects.update', $subject)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div>
        <label>Nombre</label>
        <input type="text" name="name" value="<?php echo e($subject->name); ?>">
    </div>

    <div>
        <label>Descripción</label>
        <textarea name="description"><?php echo e($subject->description); ?></textarea>
    </div>

    <div>
        <label>Estado</label>
        <select name="status">
            <option value="active" <?php echo e($subject->status == 'active' ? 'selected' : ''); ?>>Activo</option>
            <option value="inactive" <?php echo e($subject->status == 'inactive' ? 'selected' : ''); ?>>Inactivo</option>
        </select>
    </div>

    <br>

    <button>🔄 Actualizar</button>
</form>

<br>

<a href="<?php echo e(route('admin.subjects.index')); ?>">⬅ Volver</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/subjects/edit.blade.php ENDPATH**/ ?>