
<?php $__env->startSection('title', 'Grados'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/admin/grades/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    
    <h2 class="mb-4">
        Lista de Grados
    </h2>

    
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

    
    <div class="action-header mb-3">
        <a href="<?php echo e(route('admin.grades.create')); ?>" class="btn btn-primary">
            <span>+</span> Nuevo Grado
        </a>
    </div>

    
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Grado</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="font-bold"><?php echo e($grade->name); ?></td>
                    <td>
                        <span class="badge-level"><?php echo e($grade->level); ?></span>
                    </td>

                    <td class="actions-cell">
                        <div class="btn-group-custom">
                            <a href="<?php echo e(route('admin.grades.show', $grade)); ?>"
                               class="btn btn-info btn-sm">
                                Ver
                            </a>

                            <a href="<?php echo e(route('admin.grades.edit', $grade)); ?>"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <a href="<?php echo e(route('admin.grades.groups.index', $grade->id)); ?>"
                               class="btn btn-primary btn-sm">
                                Grupos
                            </a>

                            <form action="<?php echo e(route('admin.grades.destroy', $grade)); ?>"
                                  method="POST"
                                  class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button onclick="return confirm('¿Eliminar este grado?')"
                                        class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="empty-state">
                        No hay grados registrados
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/grades/index.blade.php ENDPATH**/ ?>