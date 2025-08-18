
@extends('layouts.app')

@section('content')



@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center">Iniciar Sesión</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>
                    <div class="mt-3 text-center">
                        <span>¿No tienes una cuenta?</span>
                        <a href="{{ route('register') }}" class="text-primary fw-bold">Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
