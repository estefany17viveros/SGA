
<?php $__env->startSection('title', 'Editar Grupo'); ?>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/groups/edit.css'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h4 class="mb-3">
        Editar Grupo - <?php echo e($group->grade->name); ?>

    </h4>

    <div class="card">
        <div class="card-body">

            <form action="<?php echo e(route('admin.grades.groups.update', [$group->grade_id, $group->id])); ?>" 
                  method="POST">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Nombre del Grupo</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?php echo e(old('name', $group->name)); ?>"
                           required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Capacidad</label>
                    <input type="number"
                           name="capacity"
                           class="form-control"
                           value="<?php echo e(old('capacity', $group->capacity)); ?>"
                           min="0"
                           required>
                    <?php $__errorArgs = ['capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option value="activo"
                            <?php echo e($group->status === 'activo' ? 'selected' : ''); ?>>
                            Activo
                        </option>
                        <option value="cerrado"
                            <?php echo e($group->status === 'cerrado' ? 'selected' : ''); ?>>
                            Cerrado
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    Actualizar
                </button>

                <a href="<?php echo e(route('admin.grades.groups.index', $group->grade_id)); ?>"
                   class="btn btn-secondary">
                    Volver
                </a>

            </form>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/groups/edit.blade.php ENDPATH**/ ?>