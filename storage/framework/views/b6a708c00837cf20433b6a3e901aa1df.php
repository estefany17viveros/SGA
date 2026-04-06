
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/subjects/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h1>📄 Detalle de Materia</h1>

<div style="border:1px solid #ccc; padding:20px; border-radius:10px;">

    <p><strong>ID:</strong> <?php echo e($subject->id); ?></p>

    <p><strong>Nombre:</strong> <?php echo e($subject->name); ?></p>

    <p><strong>Descripción:</strong> 
        <?php echo e($subject->description ?? 'Sin descripción'); ?>

    </p>

    <p><strong>Estado:</strong> 
        <?php if($subject->status == 'active'): ?>
            <span style="color:green;">Activo</span>
        <?php else: ?>
            <span style="color:red;">Inactivo</span>
        <?php endif; ?>
    </p>

    <p><strong>Creado:</strong> <?php echo e($subject->created_at->format('d/m/Y')); ?></p>

</div>

<br>

<a href="<?php echo e(route('admin.subjects.index')); ?>">⬅ Volver</a>
<a href="<?php echo e(route('admin.subjects.edit', $subject)); ?>">✏️ Editar</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/subjects/show.blade.php ENDPATH**/ ?>