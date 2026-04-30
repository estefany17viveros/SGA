<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>🌿 SGA 🌿</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        /* ─── Fuentes y Variables ─── */
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap');

        :root {
            --azul-prof:   #0f4c81;
            --azul-med:    #1e88e5;
            --azul-claro:  #e3f2fd;
            --teal:        #26a69a;
            --teal-claro:  #80cbc4;
            --teal-bg:     #e0f2f1;
            --gris-osc:    #263238;
            --gris-med:    #546e7a;
            --gris-claro:  #f5f7fa;
            --blanco:      #ffffff;
            --rojo:        #ef5350;
            --r-lg: 24px;
            --r-pill: 999px;
            --font-display: 'Syne', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        /* ══════════════════════════════════════════════════════
           ESTRUCTURA PARA FOOTER SIEMPRE ABAJO
        ══════════════════════════════════════════════════════ */
        
        /* 1. Hacemos que el HTML y BODY ocupen el 100% de la pantalla */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* 2. El body se convierte en un contenedor Flex vertical */
        body {
            display: flex;
            flex-direction: column;
            font-family: var(--font-body);
            background-color: var(--gris-claro);
        }

        /* 3. El MAIN crecerá para ocupar todo el espacio disponible, empujando al footer */
        .app-main {
            flex: 1 0 auto;
        }

       
        /* ══════════════════════════════════════════════════════
           NOTIFICACIONES (FLOTANTES)
        ══════════════════════════════════════════════════════ */
        .notification-fab {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 9999;
        }

        .notification-bell {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--azul-prof) 0%, #1565c0 60%, var(--teal) 100%);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease;
            box-shadow: 0 6px 24px rgba(15,76,129,.35);
            position: relative;
        }

        .notification-bell:hover { transform: scale(1.08); }

        .notification-count {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--rojo);
            color: var(--blanco);
            font-size: 11px;
            font-weight: 700;
            min-width: 22px;
            height: 22px;
            border-radius: var(--r-pill);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2.5px solid var(--blanco);
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            bottom: calc(100% + 14px); 
            right: 0;
            width: 350px;
            max-width: 90vw;
            background: var(--blanco);
            border-radius: var(--r-lg);
            box-shadow: 0 8px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            animation: slideUp 0.3s ease forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notification-dropdown.is-open { display: block; }

        .notification-header {
            padding: 15px 20px;
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #edf2f7;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 15px 20px;
            display: flex;
            gap: 12px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .notification-item:hover { background: #f1f5f9; }

        .btn-read {
            background: var(--teal-bg);
            color: var(--teal);
            border: none;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: bold;
            cursor: pointer;
        }

        .notif-empty { padding: 30px; text-align: center; color: var(--gris-med); }
    </style>
</head>

<body>

    
    <nav class="app-navbar">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </nav>

    
    <?php if(isset($header)): ?>
        <header class="app-header" style="background: white; padding: 20px 0; border-bottom: 1px solid #eee; flex-shrink: 0;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <?php echo e($header); ?>

            </div>
        </header>
    <?php endif; ?>

    
    <main class="app-main">
        <div class="container" style="max-width: 1200px; margin: 30px auto; padding: 0 20px;">
            <div class="content-card" style=" padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <?php if(isset($slot)): ?>
                    <?php echo e($slot); ?>

                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </main>

    
    <div class="notification-fab">
        <div class="notification-dropdown" id="notificationDropdown">
            <div class="notification-header">
                <strong style="font-family: var(--font-display);">Notificaciones</strong>
                <form method="POST" action="<?php echo e(route('notifications.read')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="btn-read" type="submit">LIMPIAR</button>
                </form>
            </div>

            <div class="notification-list">
                <?php if(auth()->check()): ?>
                    <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="notification-item">
                            <div style="font-size: 20px;">🔔</div>
                            <div>
                                <strong style="font-size: 0.85rem; color: var(--gris-osc);"><?php echo e($notification->data['nombre'] ?? 'Aviso'); ?></strong>
                                <p style="margin: 3px 0 0; font-size: 0.8rem; color: var(--gris-med);"><?php echo e($notification->data['mensaje'] ?? ''); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="notif-empty">
                            <span style="display:block; font-size: 2rem; opacity: 0.2;">🔕</span>
                            No tienes notificaciones
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <button class="notification-bell" onclick="toggleNotifications()" aria-label="Ver notificaciones">
            🔔
            <?php if(auth()->check() && auth()->user()->unreadNotifications->count() > 0): ?>
                <span class="notification-count">
                    <?php echo e(auth()->user()->unreadNotifications->count()); ?>

                </span>
            <?php endif; ?>
        </button>
    </div>

    
    <footer class="app-footer">
        © <?php echo e(date('Y')); ?> Sistema Gestión Académico — <strong>ITAF</strong>
    </footer>

    
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('is-open');
        }

        document.addEventListener('click', function (e) {
            const fab = document.querySelector('.notification-fab');
            if (fab && !fab.contains(e.target)) {
                document.getElementById('notificationDropdown').classList.remove('is-open');
            }
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\SGA\resources\views/layouts/app.blade.php ENDPATH**/ ?>