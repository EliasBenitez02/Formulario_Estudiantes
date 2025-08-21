
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <main class="container flex-grow-1 d-flex flex-column justify-content-center align-items-center">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>

    {{-- Livewire scripts --}}
    @livewireScripts
</body>
</html>