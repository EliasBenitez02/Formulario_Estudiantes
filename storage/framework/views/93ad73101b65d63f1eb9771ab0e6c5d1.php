<?php $__env->startSection('title', 'Agregar Profesor'); ?>
<?php $__env->startSection('content'); ?>
<div class="w-full min-h-screen flex items-center justify-center bg-gray-50 px-2 sm:px-0">
    <div class="w-full max-w-md bg-white p-6 sm:p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-center">Agregar Profesor</h2>
        <form method="POST" action="<?php echo e(route('admin.profesores.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <input type="text" name="name" placeholder="Nombre" class="w-full mb-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-200 focus:outline-none transition" required value="<?php echo e(old('name')); ?>">
            </div>
            <div>
                <input type="email" name="email" placeholder="Correo" class="w-full mb-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-200 focus:outline-none transition" required value="<?php echo e(old('email')); ?>">
            </div>
            <div>
                <input type="password" name="password" placeholder="Contraseña" class="w-full mb-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-200 focus:outline-none transition" required>
            </div>
            <div>
                <select name="course_id" class="w-full mb-2 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-200 focus:outline-none transition" required>
                    <option value="">Selecciona un curso</option>
                    <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $ocupado = \App\Models\User::where('role_id', 2)->where('course_id', $curso->id)->exists();
                        ?>
                        <option value="<?php echo e($curso->id); ?>" <?php if($ocupado): ?> disabled style="background:#f8d7da;color:#721c24;" <?php endif; ?>>
                            <?php echo e($curso->name); ?> <?php if($ocupado): ?> (Ocupado) <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['profesor.course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="mb-2 text-red-600 text-sm"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="flex flex-col sm:flex-row justify-end gap-2 mt-4">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 bg-gray-300 rounded-xl text-center">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl w-full sm:w-auto">Agregar</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perfil\resources\views/livewire/admin/agregar-profesor.blade.php ENDPATH**/ ?>