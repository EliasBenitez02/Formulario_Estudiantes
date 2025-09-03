<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - <?php echo $__env->yieldContent('title'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
        <span class="font-bold text-xl">Admin Panel</span>
        <div>
            <a href="<?php echo e(route('admin.profesores.create')); ?>" class="mr-4 hover:underline">Agregar Profesor</a>
            <a href="<?php echo e(route('admin.cursos.create')); ?>" class="mr-4 hover:underline">Agregar Curso</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="hover:underline bg-transparent border-none text-white cursor-pointer">Cerrar sesión</button>
            </form>
        </div>
    </nav>
    <main class="container mx-auto py-8">
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo e($slot ?? ''); ?>

    </main>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\perfil\resources\views/components/layouts/admin-layout.blade.php ENDPATH**/ ?>