
<?php $__env->startSection('title', 'Información del estudiante'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/students/show.css'); ?>    
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>👨‍🎓 Información del estudiante</h2>

    
    <div class="card mb-3 p-3 text-center">
        <h5>📷 Foto</h5>

        <?php if($student->photo): ?>
            <img src="<?php echo e(asset('storage/' . $student->photo)); ?>"
                 width="140"
                 class="rounded">
        <?php else: ?>
            <p>Sin foto</p>
        <?php endif; ?>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>📄 Datos personales</h5>

        <p><strong>Nombre:</strong> <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></p>
        <p><strong>Documento:</strong> <?php echo e($student->identification_type); ?> - <?php echo e($student->identification_number); ?></p>
        <p><strong>Género:</strong> <?php echo e($student->gender); ?></p>
        <p><strong>Fecha nacimiento:</strong> <?php echo e($student->birth_date); ?></p>
        <p><strong>Edad:</strong> <?php echo e($student->age); ?></p>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>📍 Ubicación</h5>

        <p><strong>Dirección:</strong> <?php echo e($student->address); ?></p>
        <p><strong>Expedición:</strong> <?php echo e($student->expedition_department); ?> - <?php echo e($student->expedition_municipality); ?></p>
        <p><strong>Fecha expedición:</strong> <?php echo e($student->expedition_date); ?></p>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>🏥 Salud</h5>

        <p><strong>EPS:</strong> <?php echo e($student->eps); ?></p>
        <p><strong>Tipo de sangre:</strong> <?php echo e($student->blood_type); ?></p>
        <p><strong>Condiciones médicas:</strong> <?php echo e($student->medical_conditions ?? 'Ninguna'); ?></p>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>🌎 Población</h5>

        <p><strong>Tipo:</strong> <?php echo e($student->population_type); ?></p>

        <?php if($student->population_certificate): ?>
            <a href="<?php echo e(asset('storage/' . $student->population_certificate)); ?>"
               target="_blank"
               class="btn btn-primary btn-sm">
                📄 Ver certificado
            </a>
        <?php endif; ?>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>👨‍👩‍👧 Acudientes</h5>

        <?php if($student->guardians && $student->guardians->count()): ?>
            <ul>
                <?php $__currentLoopData = $student->guardians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <strong><?php echo e($g->first_name); ?> <?php echo e($g->last_name); ?></strong><br>
                        📞 <?php echo e($g->phone ?? 'Sin teléfono'); ?><br>
                        🏠 <?php echo e($g->address ?? 'Sin dirección registrada'); ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p>No tiene acudientes</p>
        <?php endif; ?>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>🎓 Matrículas</h5>

        <?php if($student->enrollments && $student->enrollments->count()): ?>
            <ul>
                <?php $__currentLoopData = $student->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                       Año: <?php echo e($e->academicYear->year ?? $e->academicYear->name ?? 'Sin año'); ?>

                        Grado: <?php echo e($e->grade->name ?? 'Sin grado'); ?> |
                        Estado: <?php echo e($e->status); ?>

</li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p>No tiene matrículas</p>
        <?php endif; ?>
    </div>

    
    <div class="card mb-3 p-3">
        <h5>📘 Observador</h5>

        <p><?php echo e($student->observations ?? 'Sin observaciones'); ?></p>

        <?php if($student->certificate_file): ?>
            <a href="<?php echo e(asset('storage/' . $student->certificate_file)); ?>"
               target="_blank"
               class="btn btn-primary btn-sm">
                📄 Ver PDF
            </a>
        <?php endif; ?>

        <?php if($isDirector ?? false): ?>

            <hr>

            <form action="<?php echo e(route('teacher.students.observer.update', $student->id)); ?>"
                  method="POST"
                  enctype="multipart/form-data">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-2">
                    <label>Editar observación</label>
                    <textarea name="observations"
                              class="form-control"
                              rows="3"><?php echo e($student->observations); ?></textarea>
                </div>

                <div class="mb-2">
                    <input type="file" name="certificate_file" class="form-control">
                </div>

                <button class="btn btn-success btn-sm">
                    💾 Guardar cambios
                </button>

            </form>

        <?php else: ?>
            <p class="text-muted mt-2">
                🔒 Solo el director del grupo puede editar el observador
            </p>
        <?php endif; ?>

    </div>

    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">
        ⬅ Volver
    </a>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/students/show.blade.php ENDPATH**/ ?>