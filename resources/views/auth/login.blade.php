@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="w-full max-w-lg mx-auto px-2 sm:px-0">
        <div class="bg-white shadow-xl rounded-2xl px-4 py-8 sm:px-8 sm:py-12">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-700">Iniciar Sesión</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                @if($errors->any())
                    <div class="mb-2 p-2 bg-red-100 text-red-700 rounded text-sm">
                        @if($errors->has('email'))
                            {{ $errors->first('email') }}
                        @elseif($errors->has('password'))
                            {{ $errors->first('password') }}
                        @else
                            Credenciales incorrectas.
                        @endif
                    </div>
                @endif
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <div class="relative">
                    <input type="password" name="password" id="login_password" placeholder="Contraseña" class="w-full pr-10 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required autocomplete="current-password">
                    <span class="absolute right-3 top-2.5 text-gray-400 cursor-pointer" id="eye-login_password" onclick="togglePassword('login_password')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.274.835-.66 1.624-1.149 2.336M15.5 15.5l2.5 2.5"/></svg>
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
