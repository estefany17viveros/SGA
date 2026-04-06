

<?php $__env->startSection('title','Acudientes'); ?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/guardians/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

<div class="d-flex justify-content-between mb-3">
<h3>👨‍👩‍👦 Acudientes</h3>
</div>

<?php if(session('success')): ?>

<div class="alert alert-success">
<?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<!-- BUSCADOR -->

<div class="card mb-3">
<div class="card-body">

<form method="GET" action="<?php echo e(route('admin.guardians.index')); ?>">

<div class="row">

<div class="col-md-6">

<input type="text"
name="apellido"
value="<?php echo e(request('apellido')); ?>"
class="form-control"
placeholder="Buscar por apellido del estudiante">

</div>

<div class="col-md-3">

<button class="btn btn-primary">
🔍 Buscar
</button>

<a href="<?php echo e(route('admin.guardians.index')); ?>"
class="btn btn-secondary">
Limpiar </a>

</div>

</div>

</form>

</div>
</div>

<div class="card">
<div class="card-body">

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellido</th>
<th>Parentesco</th>
<th>Teléfono</th>
<th>Estudiante</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

<?php $__empty_1 = true; $__currentLoopData = $guardians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guardian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<tr>

<td><?php echo e($guardian->id); ?></td>

<td><?php echo e($guardian->first_name); ?></td>

<td><?php echo e($guardian->last_name); ?></td>

<td><?php echo e($guardian->relationship); ?></td>

<td><?php echo e($guardian->phone); ?></td>

<td><?php echo e($guardian->student->full_name ?? ''); ?></td>

<td>

<a href="<?php echo e(route('admin.guardians.show',$guardian->id)); ?>"
class="btn btn-info btn-sm">Ver</a>

<a href="<?php echo e(route('admin.guardians.edit',$guardian->id)); ?>"
class="btn btn-warning btn-sm">Editar</a>

<form action="<?php echo e(route('admin.guardians.destroy',$guardian->id)); ?>"
method="POST"
style="display:inline">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button class="btn btn-danger btn-sm"
onclick="return confirm('Eliminar acudiente?')">
Eliminar </button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<tr>
<td colspan="6" class="text-center">
No se encontraron resultados
</td>
</tr>

<?php endif; ?>

</tbody>

</table>

<?php echo e($guardians->links()); ?>


</div>
</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/guardians/index.blade.php ENDPATH**/ ?>