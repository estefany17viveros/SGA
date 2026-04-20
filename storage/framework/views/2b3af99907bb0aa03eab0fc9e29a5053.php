<?php $__env->startSection('title', 'Años Académicos'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/academic_years/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?><div class="container">

    <h2>Años Académicos</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="d-flex justify-content-between mb-3">
        <a href="<?php echo e(route('admin.academic_years.create')); ?>" class="btn btn-primary">
            Crear Nuevo Año
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Año</th>
                <th>Calendario</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Períodos</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $academicYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr>
    <td data-label="Año"><?php echo e($year->year); ?></td>
    <td data-label="Calendario"><?php echo e($year->calendar); ?></td>
    <td data-label="Inicio">
        <?php echo e(\Carbon\Carbon::parse($year->start_date)->format('d/m/Y')); ?>

    </td>
    <td data-label="Fin">
        <?php echo e(\Carbon\Carbon::parse($year->end_date)->format('d/m/Y')); ?>

    </td>
    <td data-label="Períodos"><?php echo e($year->periods); ?></td>
    <td data-label="Estado">
        <?php if($year->status === 'activo'): ?>
            <span class="badge bg-success">Activo</span>
        <?php else: ?>
            <span class="badge bg-secondary">Cerrado</span>
        <?php endif; ?>
    </td>
    <td data-label="Acciones">
    <div class="action-group"> 
        
        <a href="<?php echo e(route('admin.academic_years.show', $year->id)); ?>"
           class="btn btn-info btn-sm">
           Ver
        </a>

        <?php if($year->status === 'activo'): ?>
        <form action="<?php echo e(route('admin.academic_years.close', $year->id)); ?>"
              method="POST" class="d-inline"> 
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <button class="btn btn-dark btn-sm">Cerrar</button>
        </form>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.academic_years.destroy', $year->id)); ?>"
              method="POST" class="d-inline"> 
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button class="btn btn-danger btn-sm" 
                    onclick="return confirm('¿Estás seguro?')">
                Eliminar
            </button>
        </form>

    </div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="7">No hay registros.</td>
</tr>
<?php endif; ?>
</tbody>
    </table>

    <div class="mt-3">
        <?php echo e($academicYears->links()); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/academic_years/index.blade.php ENDPATH**/ ?>