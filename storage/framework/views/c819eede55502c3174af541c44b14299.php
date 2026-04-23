
<?php $__env->startSection('title', 'Información del estudiante'); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/teacher/students/show.css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">

    <h2>👨‍🎓 Información del estudiante</h2>

    <div class="student-layout">

        
        <div class="student-col-left">

            
            <div class="card card-foto">
                <h5>📷 Foto</h5>
                <?php if($student->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $student->photo)); ?>"
                         width="110" class="rounded">
                <?php else: ?>
                    <div class="sin-foto">Sin foto</div>
                <?php endif; ?>
            </div>

            
            <div class="card">
                <h5>📄 Datos personales</h5>
                <p><strong>Nombre:</strong> <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></p>
                <p><strong>Documento:</strong> <?php echo e($student->identification_type); ?> – <?php echo e($student->identification_number); ?></p>
                <p><strong>Género:</strong> <?php echo e($student->gender); ?></p>
                <p><strong>Nacimiento:</strong> <?php echo e($student->birth_date); ?></p>
                <p><strong>Edad:</strong> <?php echo e($student->age); ?></p>
            </div>

            
            <div class="card">
                <h5>📍 Ubicación</h5>
                <p><strong>Dirección:</strong> <?php echo e($student->address); ?></p>
                <p><strong>Expedición:</strong> <?php echo e($student->expedition_department); ?> – <?php echo e($student->expedition_municipality); ?></p>
                <p><strong>Fecha expedición:</strong> <?php echo e($student->expedition_date); ?></p>
            </div>

            
            <div class="card">
                <h5>🏥 Salud</h5>
                <p><strong>EPS:</strong> <?php echo e($student->eps); ?></p>
                <p><strong>Tipo de sangre:</strong> <?php echo e($student->blood_type); ?></p>
                <p><strong>Condiciones:</strong> <?php echo e($student->medical_conditions ?? 'Ninguna'); ?></p>
            </div>

            
            <div class="card">
                <h5>🌎 Población</h5>
                <p><strong>Tipo:</strong> <?php echo e($student->population_type); ?></p>
                <?php if($student->population_certificate): ?>
                    <a href="<?php echo e(asset('storage/' . $student->population_certificate)); ?>"
                       target="_blank"
                       class="btn-pdf">
                        📄 Ver certificado
                    </a>
                <?php endif; ?>
            </div>

            
            <div class="card">
                <h5>👨‍👩‍👧 Acudientes</h5>
                <?php if($student->guardians && $student->guardians->count()): ?>
                    <ul>
                        <?php $__currentLoopData = $student->guardians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <strong><?php echo e($g->first_name); ?> <?php echo e($g->last_name); ?></strong>
                                📞 <?php echo e($g->phone ?? 'Sin teléfono'); ?><br>
                                🏠 <?php echo e($g->address ?? 'Sin dirección registrada'); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p>No tiene acudientes registrados</p>
                <?php endif; ?>
            </div>

            
            <div class="card card-matricula">
                <h5>🎓 Matrículas</h5>
                <?php if($student->enrollments && $student->enrollments->count()): ?>
                    <ul>
                        <?php $__currentLoopData = $student->enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <strong><?php echo e($e->academicYear->year ?? $e->academicYear->name ?? 'Sin año'); ?></strong>
                                Grado: <?php echo e($e->grade->name ?? 'Sin grado'); ?> &nbsp;|&nbsp; Estado: <?php echo e($e->status); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p>No tiene matrículas registradas</p>
                <?php endif; ?>
            </div>

        </div>

        
        <div class="student-col-right">

            
            <div class="card">
                <h5>📘 Observador</h5>

                <div class="obs-texto">
                    <?php echo e($student->observations ?? 'Sin observaciones registradas'); ?>

                </div>

                <?php if($student->certificate_file): ?>
                    <a href="<?php echo e(asset('storage/' . $student->certificate_file)); ?>"
                       target="_blank"
                       class="btn-pdf">
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
                                      rows="4"><?php echo e($student->observations); ?></textarea>
                        </div>

                        <div class="mb-2">
                            <label>Subir archivo PDF</label>
                            <input type="file" name="certificate_file" class="form-control">
                        </div>

                        <button type="submit" class="btn-guardar">
                            💾 Guardar cambios
                        </button>

                    </form>

                <?php else: ?>
                    <p class="aviso-director">
                        🔒 Solo el director del grupo puede editar el observador
                    </p>
                <?php endif; ?>

            </div>

        </div>

    </div>

    <a href="<?php echo e(url()->previous()); ?>" class="btn-volver">
        ⬅ Volver
    </a>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/teacher/students/show.blade.php ENDPATH**/ ?>