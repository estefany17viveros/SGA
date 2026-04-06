
<?php $__env->startSection('title', 'Profesores'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teachers/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2><?php echo e($teacher->full_name); ?></h2>


<?php if($teacher->photo): ?>
    <img src="<?php echo e(asset('storage/'.$teacher->photo)); ?>" width="120">
<?php endif; ?>

<p><strong>Edad:</strong> <?php echo e($teacher->age); ?> años</p>

<p><strong>Documento:</strong> <?php echo e($teacher->document_type); ?> - <?php echo e($teacher->document_number); ?></p>

<p><strong>Género:</strong> <?php echo e($teacher->gender); ?></p>

<p><strong>Fecha de nacimiento:</strong> <?php echo e($teacher->birth_date); ?></p>

<p><strong>Departamento expedición:</strong> <?php echo e($teacher->expedition_department); ?></p>

<p><strong>Municipio expedición:</strong> <?php echo e($teacher->expedition_municipality); ?></p>

<p><strong>Teléfono:</strong> <?php echo e($teacher->phone ?? 'N/A'); ?></p>

<p><strong>Dirección:</strong> <?php echo e($teacher->address ?? 'N/A'); ?></p>

<p><strong>Especialidad:</strong> <?php echo e($teacher->specialty ?? 'N/A'); ?></p>

<p><strong>Correo:</strong> <?php echo e($teacher->user->email); ?></p>

<p><strong>Fecha de ingreso:</strong> <?php echo e($teacher->start_date); ?></p>

<p><strong>Fecha de fin:</strong> <?php echo e($teacher->end_date ?? 'Sin definir'); ?></p>

<p>
    <strong>Estado:</strong>
    <?php if($teacher->is_active): ?>
        <span style="color: green">Activo</span>
    <?php else: ?>
        <span style="color: red">Inactivo</span>
    <?php endif; ?>
</p>


<?php if($teacher->cv): ?>
    <p>
        <a href="<?php echo e(asset('storage/'.$teacher->cv)); ?>" target="_blank">
            📄 Ver hoja de vida
        </a>
    </p>
<?php endif; ?>

<br>

<a href="<?php echo e(route('admin.teachers.index')); ?>">⬅ Volver</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teachers/show.blade.php ENDPATH**/ ?>