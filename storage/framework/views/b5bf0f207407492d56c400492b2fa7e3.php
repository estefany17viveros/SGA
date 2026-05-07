


<?php $__env->startSection('title','Crear Egresado'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin/enrollments/graduatescreate.css']); ?>  
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">

    <h3>➕ Crear Egresado</h3>

    
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>⚠️ <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.enrollments.store_graduate')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="row">

            
            <div class="col-md-6">
                <label>Nombre</label>
                <input type="text"
                       name="first_name"
                       class="form-control"
                       value="<?php echo e(old('first_name')); ?>"
                       required>
            </div>

            
            <div class="col-md-6">
                <label>Apellido</label>
                <input type="text"
                       name="last_name"
                       class="form-control"
                       value="<?php echo e(old('last_name')); ?>"
                       required>
            </div>

            
            <div class="col-md-6 mt-2">
                <label>Documento</label>
                <input type="text"
                       name="identification_number"
                       class="form-control"
                       value="<?php echo e(old('identification_number')); ?>">
            </div>

            
            <div class="col-md-6 mt-2">
                <label>Teléfono</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       value="<?php echo e(old('phone')); ?>">
            </div>

            
            <div class="col-md-6 mt-2">
                <label>Dirección</label>
                <input type="text"
                       name="address"
                       class="form-control"
                       value="<?php echo e(old('address')); ?>">
            </div>

            
            <div class="col-md-6 mt-2">
                <label>Fecha de nacimiento</label>
                <input type="date"
                       name="birth_date"
                       class="form-control"
                       value="<?php echo e(old('birth_date')); ?>">
            </div>

            
            <div class="col-md-6 mt-2">
                <label>Año de graduación</label>
                <input type="text"
                       name="year"
                       class="form-control"
                       placeholder="Ej: 2024 o Promoción 2024"
                       value="<?php echo e(old('year')); ?>"
                       required>
            </div>

        </div>

        
        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary">
                💾 Guardar
            </button>

            <a href="<?php echo e(route('admin.enrollments.graduated')); ?>" class="btn btn-secondary">
                Cancelar
            </a>
        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/enrollments/create_graduate.blade.php ENDPATH**/ ?>