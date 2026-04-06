

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')('resources/css/students/index.css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Estudiantes'); ?>

<?php $__env->startSection('content'); ?>

<div class="students-container">

<div class="page-header">
    <div class="header-content">
        <h3>👨‍🎓 Estudiantes</h3>
        <p class="subtitle">Gestiona todos los estudiantes del sistema</p>
    </div>

    <a href="<?php echo e(route('admin.students.create')); ?>" class="btn-create">
        <span class="icon">➕</span>
        Nuevo Estudiante
    </a>
</div>

<?php if(session('success')): ?>
<div class="success-message">
    <span class="message-icon">✓</span>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<!-- 🔍 BUSCADOR + FILTROS -->
<div class="search-container">

<form method="GET" action="<?php echo e(route('admin.students.index')); ?>">

<div class="search-box">

    <!-- BUSCADOR -->
    <input
        type="text"
        name="search"
        value="<?php echo e(request('search')); ?>"
        placeholder="Buscar por nombre, apellido o documento"
        class="search-input">

    <!-- FILTRO POR GRADO -->
    <select name="grade_id" class="search-input">
        <option value="">Todos los grados</option>

        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($grade->id); ?>"
                <?php echo e(request('grade_id') == $grade->id ? 'selected' : ''); ?>>
                <?php echo e($grade->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- BOTONES -->
    <button class="btn-search">🔍 Buscar</button>

    <a href="<?php echo e(route('admin.students.index')); ?>" class="btn-reset">
        Limpiar
    </a>

</div>

</form>

</div>

<!-- TABLA -->
<div class="table-container">
<table class="students-table">

<thead>
<tr>
<th>Foto</th>
<th>Nombre Completo</th>
<th>Documento</th>
<th>Edad</th>
<th>EPS</th>
<th>Grado</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

<?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<tr>

<td class="photo-cell">
<?php if($student->photo): ?>
    <img src="<?php echo e(asset('storage/'.$student->photo)); ?>" class="student-photo">
<?php else: ?>
    <div class="photo-placeholder">
        <span class="placeholder-icon">👤</span>
    </div>
<?php endif; ?>
</td>

<td class="name-cell">
<span class="student-name"><?php echo e($student->full_name); ?></span>
</td>

<td>
<?php echo e($student->identification_number); ?>

</td>

<td>
<span class="age-badge"><?php echo e($student->age); ?> años</span>
</td>

<td>
<?php echo e($student->eps); ?>

</td>

<td>
<?php
    $enrollment = $student->enrollments->first();
?>

<?php if($enrollment && $enrollment->grade): ?>
    <span class="badge-grade">
        <?php echo e($enrollment->grade->name); ?>

    </span>
<?php else: ?>
    <span class="badge-grade">Sin asignar</span>
<?php endif; ?>
</td>

<td class="actions-cell">

<a href="<?php echo e(route('admin.students.show', $student->id)); ?>" class="btn-action btn-view">
👁️ Ver
</a>

<a href="<?php echo e(route('admin.students.edit', $student->id)); ?>" class="btn-action btn-edit">
✏️ Editar
</a>

<form action="<?php echo e(route('admin.students.destroy', $student->id)); ?>" method="POST" class="delete-form">
<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button
type="submit"
class="btn-action btn-delete"
onclick="return confirm('¿Está seguro de eliminar a <?php echo e($student->full_name); ?>?')">
🗑️ Eliminar
</button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<tr>
<td colspan="7" class="empty-state">
<div class="empty-content">
<span class="empty-icon">📚</span>
<p>No se encontraron estudiantes</p>

<a href="<?php echo e(route('admin.students.index')); ?>" class="btn-create-first">
Mostrar todos
</a>

</div>
</td>
</tr>

<?php endif; ?>

</tbody>

</table>
</div>

<!-- PAGINACIÓN -->
<div class="pagination-container">
<?php echo e($students->appends(request()->query())->links()); ?>

</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SGA\resources\views/admin/students/index.blade.php ENDPATH**/ ?>