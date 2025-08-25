<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SICEP - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body>
    <div class="container mx-auto">
       @yield('content')
    </div>
    @livewireScripts
</body>
</html>