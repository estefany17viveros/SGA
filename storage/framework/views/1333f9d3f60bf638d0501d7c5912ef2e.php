
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/periods/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<h2>Periodos - Año <?php echo e($year->year); ?></h2>

<a href="<?php echo e(route('admin.academic_years.index')); ?>">← Volver</a>

<br><br>

<?php
$total = $periods->sum('percentage');
?>

<p>
    Total: 
    <strong style="color: <?php echo e($total == 100 ? 'green' : 'red'); ?>">
        <?php echo e(number_format($total,2)); ?>%
    </strong>
</p>

<?php if(session('success')): ?>
<p style="color:green"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<?php if(session('error')): ?>
<p style="color:red"><?php echo e(session('error')); ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
<tr>
    <th>#</th>
    <th>Nombre</th>
    <th>Fechas</th>
    <th>%</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

<?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr <?php if($loop->last): ?> style="background:#eef" <?php endif; ?>>
    <td><?php echo e($p->number); ?></td>
    <td><?php echo e($p->name); ?></td>
    <td><?php echo e($p->start_date); ?> - <?php echo e($p->end_date); ?></td>
    <td><?php echo e(number_format($p->percentage,2)); ?>%</td>

    <td>
        <?php echo e($p->status); ?>

    </td>

    <td>
        <a href="<?php echo e(route('admin.periods.show',$p->id)); ?>">Ver</a> |
        <a href="<?php echo e(route('admin.periods.edit',$p->id)); ?>">Editar</a> |

        <?php if($p->status=='activo'): ?>
            <a href="<?php echo e(route('admin.periods.close',$p->id)); ?>">Cerrar</a>
        <?php else: ?>
            <a href="<?php echo e(route('admin.periods.open',$p->id)); ?>">Activar</a>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/periods/index.blade.php ENDPATH**/ ?>