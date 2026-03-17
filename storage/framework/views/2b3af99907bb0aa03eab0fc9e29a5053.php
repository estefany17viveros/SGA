
<?php $__env->startSection('title', 'Años Académicos'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/academic_years/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

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

    <a href="<?php echo e(route('admin.academic_years.create')); ?>" class="btn btn-primary mb-3">
        Crear Nuevo Año
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Año</th>
                <th>Calendario</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Períodos</th>
                <th>Estado</th>
                <th width="250">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $academicYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($year->year); ?></td>
                    <td><?php echo e($year->calendar); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($year->start_date)->format('d/m/Y')); ?></td>
<td><?php echo e(\Carbon\Carbon::parse($year->end_date)->format('d/m/Y')); ?></td>
                    <td><?php echo e($year->periods); ?></td>
                    <td>
                        <?php if($year->status === 'activo'): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Cerrado</span>
                        <?php endif; ?>
                    </td>
                    <td>

                        <a href="<?php echo e(route('admin.academic_years.show', $year->id)); ?>"
                           class="btn btn-info btn-sm">Ver</a>

                        <a href="<?php echo e(route('admin.academic_years.edit', $year->id)); ?>"
                           class="btn btn-warning btn-sm">Editar</a>

                        <?php if($year->status === 'activo'): ?>
                            <form action="<?php echo e(route('admin.academic_years.close', $year->id)); ?>"
                                  method="POST"
                                  style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button class="btn btn-dark btn-sm">
                                    Cerrar
                                </button>
                            </form>
                        <?php endif; ?>

                        <form action="<?php echo e(route('admin.academic_years.destroy', $year->id)); ?>"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este año?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">No hay registros.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/academic_years/index.blade.php ENDPATH**/ ?>