<section class="profile-card">

    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-custom border border-gray-200 p-8">

        
        <header class="mb-6">
            <h2 class="text-2xl font-bold text-colegioAzul">
                Información del Perfil
            </h2>

            <p class="mt-2 text-gray-600">
                Solo puedes actualizar tu dirección y número de teléfono
            </p>
        </header>

        
        <?php if(session('status') === 'profile-updated'): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                ✔ Perfil actualizado correctamente
            </div>
        <?php endif; ?>

        
        <div class="flex flex-col items-center mb-6">
            <?php if(auth()->user()->teacher->photo ?? false): ?>
                <img src="<?php echo e(asset('storage/' . auth()->user()->teacher->photo)); ?>"
                     class="w-28 h-28 rounded-full object-cover border-4 border-blue-500 shadow">
            <?php else: ?>
                <div class="w-28 h-28 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    Sin foto
                </div>
            <?php endif; ?>
        </div>

        
        <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('patch'); ?>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">Nombre</label>
                    <input type="text"
                           value="<?php echo e(auth()->user()->name); ?>"
                           class="w-full border rounded-lg p-2 bg-gray-100"
                           disabled>
                </div>

                <div>
                    <label class="font-semibold">Correo electrónico</label>
                    <input type="text"
                           value="<?php echo e(auth()->user()->email); ?>"
                           class="w-full border rounded-lg p-2 bg-gray-100"
                           disabled>
                </div>

            </div>

            
            <div>
                <label class="font-semibold">Teléfono</label>
                <input type="text"
                       name="phone"
                       value="<?php echo e(old('phone', auth()->user()->teacher->phone ?? '')); ?>"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            <div>
                <label class="font-semibold">Dirección</label>
                <input type="text"
                       name="address"
                       value="<?php echo e(old('address', auth()->user()->teacher->address ?? '')); ?>"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            
            <div class="flex items-center gap-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    💾 Guardar cambios
                </button>

                <?php if(session('status') === 'profile-updated'): ?>
                    <span class="text-green-600 text-sm">
                        Guardado ✔
                    </span>
                <?php endif; ?>
            </div>

        </form>

    </div>

</section><?php /**PATH C:\xampp\htdocs\SGA\resources\views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>