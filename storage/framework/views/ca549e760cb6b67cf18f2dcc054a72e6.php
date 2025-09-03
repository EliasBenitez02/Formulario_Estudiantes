
<?php $__env->startSection('title', 'Agregar Profesor'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Agregar Profesor</h2>
    <form method="POST" action="<?php echo e(route('admin.profesores.store')); ?>">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" placeholder="Nombre" class="w-full mb-2 p-2 border rounded" required>
        <input type="email" name="email" placeholder="Correo" class="w-full mb-2 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full mb-2 p-2 border rounded" required>
        <select name="course_id" class="w-full mb-2 p-2 border rounded" required>
            <option value="">Selecciona un curso</option>
            <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($curso->id); ?>"><?php echo e($curso->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="flex justify-end gap-2 mt-4">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Agregar</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perfil\resources\views/admin/agregar-profesor.blade.php ENDPATH**/ ?>