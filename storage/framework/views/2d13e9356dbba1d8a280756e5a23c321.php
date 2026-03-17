

<?php $__env->startSection('title', 'Lista de Profesores'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teachers/index.css'); ?>


<?php $__env->startSection('content'); ?>

<div class="teachers-list-container">

    
    <div class="list-header">
        <h1>👨‍🏫 Lista de Profesores</h1>

        <a href="<?php echo e(route('admin.teacher-profiles.create')); ?>" class="btn-new">
            ➕ Nuevo Profesor
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div class="table-card">
            <div class="success-message">
                <span class="message-icon">✓</span>
                <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    
    <div class="table-card">
        <div class="table-wrapper">

            <table class="teachers-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th class="center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="td-num">
                                <?php echo e($loop->iteration); ?>

                            </td>

                            <td class="td-name">
                                <?php echo e($teacher->first_name); ?>

                                <?php echo e($teacher->last_name); ?>

                            </td>

                            <td class="td-email">
                                <?php echo e($teacher->user->email ?? 'Sin correo'); ?>

                            </td>

                            <td class="center">
                                <div class="actions-cell">

                                    
                                    <a href="<?php echo e(route('admin.teacher-profiles.show', $teacher->id)); ?>"
                                       class="btn-view">
                                        👁 Ver
                                    </a>

                                    
                                    <a href="<?php echo e(route('admin.teacher-profiles.edit', $teacher->id)); ?>"
                                       class="btn-edit">
                                        ✏️ Editar
                                    </a>

                                    
                                    <form action="<?php echo e(route('admin.teacher-profiles.destroy', $teacher->id)); ?>"
                                          method="POST"
                                          class="delete-form"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este profesor?')">

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="submit" class="btn-delete">
                                            🗑 Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <span class="empty-icon">📭</span>
                                    <p>No hay profesores registrados.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/teacher_profiles/index.blade.php ENDPATH**/ ?>