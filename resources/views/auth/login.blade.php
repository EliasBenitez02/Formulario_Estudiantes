@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="w-full max-w-2xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl px-8 py-12">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-700">Iniciar Sesión</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="email" name="email" placeholder="Correo electrónico" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <div class="relative">
                    <input type="password" name="password" id="login_password" placeholder="Contraseña" class="w-full pl-10 pr-10 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <!-- SVG icon -->
                    </span>
                    <span class="absolute right-3 top-2.5 text-gray-400 cursor-pointer" onclick="togglePassword('login_password')">
                        <!-- SVG icon -->
                    </span>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">Ingresar</button>
            </form>
            <script>
            function togglePassword(id) {
                const input = document.getElementById(id);
                const eye = document.getElementById('eye-' + id);
                if (input.type === 'password') {
                    input.type = 'text';
                    eye.classList.add('text-blue-600');
                } else {
                    input.type = 'password';
                    eye.classList.remove('text-blue-600');
                }
            }
            </script>
            <div class="mt-4 text-center">
                <span class="text-gray-600">¿No tienes una cuenta?</span>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Regístrate</a>
            </div>
        </div>
    </div>
</div>
@endsection
