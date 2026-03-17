
<?php $__env->startSection('title', 'Grupos del Grado'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/groups/index.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">
                Grupos del Grado: <?php echo e($grade->name); ?>

            </h4>
           
        </div>

        <a href="<?php echo e(route('admin.grades.groups.create', $grade->id)); ?>"
           class="btn btn-primary">
            + Nuevo Grupo
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Matriculados</th>
                        <th>Disponibles</th>
                        <th>Estado</th>
                        <th width="220">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($group->name); ?></td>

                        <td><?php echo e($group->capacity); ?></td>

                        <td><?php echo e($group->enrollments_count); ?></td>

                        <td>
                            <?php echo e($group->capacity - $group->enrollments_count); ?>

                        </td>

                        <td>
                            <?php if($group->status === 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Cerrado</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?php echo e(route('admin.grades.groups.show', [$group->grade_id, $group->id])); ?>"
                               class="btn btn-sm btn-info">
                                Ver
                            </a>

                            <a href="<?php echo e(route('admin.grades.groups.edit', [$group->grade_id, $group->id])); ?>"
                               class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            <form action="<?php echo e(route('admin.grades.groups.destroy', [$group->grade_id, $group->id])); ?>"
                                  method="POST"
                                  class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar grupo?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay grupos registrados.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/groups/index.blade.php ENDPATH**/ ?>