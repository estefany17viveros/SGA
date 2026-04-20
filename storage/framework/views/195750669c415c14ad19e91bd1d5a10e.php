<!DOCTYPE html>
<html lang="es">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title> 🌿 SGA 🌿</title>

   <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

<?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div class="app-container d-flex flex-column min-vh-100">

        
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <?php if(isset($header)): ?>
            <header class="app-header">
                <div class="container">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        
        <main class="app-main flex-fill">
            <div class="container">
                <div class="content-card">

                    
                    <?php if(isset($slot)): ?>
                        <?php echo e($slot); ?>

                    <?php endif; ?>

                    
                    <?php echo $__env->yieldContent('content'); ?>

                </div>
            </div>
        </main>

        
        <footer class="app-footer">
            © <?php echo e(date('Y')); ?> Sistema Gestión Académico - ITAF
        </footer>

    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\SGA\resources\views/layouts/app.blade.php ENDPATH**/ ?>