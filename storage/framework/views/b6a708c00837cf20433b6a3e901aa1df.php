<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/subjects/show.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="subject-show-page">

    <h1>Detalle de Materia</h1>

    
    <div class="card">
        <p><strong>ID:</strong> <?php echo e($subject->id); ?></p>

        <p><strong>Nombre:</strong> <?php echo e($subject->name); ?></p>

        <p>
            <strong>Descripción:</strong> 
            <?php echo e($subject->description ?? 'Sin descripción'); ?>

        </p>

        <p>
            <strong>Estado:</strong> 
            <?php if($subject->status == 'active'): ?>
                <span class="status active">Activo</span>
            <?php else: ?>
                <span class="status inactive">Inactivo</span>
            <?php endif; ?>
        </p>

        <p>
            <strong>Creado:</strong> 
            <?php echo e($subject->created_at->format('d/m/Y')); ?>

        </p>
    </div>

    
    <div class="actions">
        <a href="<?php echo e(route('admin.subjects.index')); ?>" class="btn-action btn-back">
            ⬅ Volver
        </a>
        
        <a href="<?php echo e(route('admin.subjects.edit', $subject)); ?>" class="btn-action btn-edit">
            ✏️ Editar Materia
        </a>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/subjects/show.blade.php ENDPATH**/ ?>