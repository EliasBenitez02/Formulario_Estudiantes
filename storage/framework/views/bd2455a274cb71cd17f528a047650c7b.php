<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full min-h-screen flex flex-col items-center justify-start bg-gray-50 px-2 sm:px-0 py-4">
    <div class="w-full max-w-6xl bg-white p-4 sm:p-10 rounded-2xl shadow-2xl">
        <?php if(session()->has('mensaje')): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-center text-sm"><?php echo e(session('mensaje')); ?></div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 rounded text-center text-sm"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-center text-sm"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <h2 class="text-2xl font-bold mb-6 text-center">Profesores</h2>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full border rounded-xl text-base">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Correo</th>
                        <th class="px-6 py-3 text-left">Curso Asignado</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 align-top"><?php echo e($profesor->name); ?></td>
                            <td class="px-6 py-3 align-top"><?php echo e($profesor->email); ?></td>
                            <td class="px-6 py-3 align-top"><?php echo e($profesor->course?->name ?? '-'); ?></td>
                            <td class="px-6 py-3 align-top">
                                <form method="POST" action="<?php echo e(route('admin.delete.profesor', $profesor->id)); ?>" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm bg-red-600 text-white px-4 py-2 rounded-xl w-full sm:w-auto" onclick="return confirm('¿Seguro que quieres eliminar al profesor <?php echo e($profesor->name); ?>?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-center">Cursos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border rounded-xl text-base">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Descripción</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $ocupado = \App\Models\User::where('role_id', 2)->where('course_id', $curso->id)->exists();
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 align-top"><?php echo e($curso->name); ?></td>
                            <td class="px-6 py-3 align-top"><?php echo e($curso->description); ?></td>
                            <td class="px-6 py-3 align-top">
                                <?php if($ocupado): ?>
                                    <button type="button" class="btn btn-danger btn-sm bg-gray-400 text-white px-4 py-2 rounded-xl w-full sm:w-auto cursor-not-allowed" disabled title="No se puede eliminar el curso porque tiene un profesor asignado">Eliminar</button>
                                <?php else: ?>
                                    <form method="POST" action="<?php echo e(route('admin.delete.curso', $curso->id)); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm bg-red-600 text-white px-4 py-2 rounded-xl w-full sm:w-auto" onclick="return confirm('¿Seguro que quieres eliminar el curso <?php echo e($curso->name); ?>?')">Eliminar</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perfil\resources\views/livewire/admin/dashboard.blade.php ENDPATH**/ ?>