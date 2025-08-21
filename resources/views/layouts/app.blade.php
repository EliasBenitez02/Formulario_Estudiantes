@extends('layouts.app')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-light d-flex flex-column justify-content-center align-items-center min-vh-100">
    <main class="container flex-grow-1 d-flex flex-column justify-content-center align-items-center">
        @yield('content')
    </main>
</body>
</html>
