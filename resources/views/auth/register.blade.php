
@extends('layouts.app')

@section('content')



@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center">Crear cuenta</h2>
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 text-center">
                            <label for="profile_photo" class="form-label">Foto de perfil</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Nombre completo" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="whatsapp" class="form-control" placeholder="WhatsApp" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="comision" class="form-control" placeholder="Comisión" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="dni" class="form-control" placeholder="DNI" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="carrera" class="form-control" placeholder="Carrera" required>
                        </div>
                        <div class="mb-3">
                            <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento" required>
                        </div>
                        <div class="mb-3">
                            <select name="role_id" class="form-select" required>
                                <option value="">Selecciona tu rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Redes sociales</label>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <button type="button" class="btn btn-outline-primary" onclick="showSocialInput('linkedin')">LinkedIn</button>
                                <button type="button" class="btn btn-outline-dark" onclick="showSocialInput('github')">GitHub</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="showSocialInput('gitlab')">GitLab</button>
                                <button type="button" class="btn btn-outline-info" onclick="showSocialInput('wordpress')">WordPress</button>
                                <button type="button" class="btn btn-outline-success" onclick="showSocialInput('notion')">Notion</button>
                            </div>
                            <div id="social-inputs">
                                <!-- Inputs dinámicos -->
                            </div>
                        </div>
                        <script>
                        const socialInputs = {
                            linkedin: {label: 'LinkedIn', color: 'primary'},
                            github: {label: 'GitHub', color: 'dark'},
                            gitlab: {label: 'GitLab', color: 'secondary'},
                            wordpress: {label: 'WordPress', color: 'info'},
                            notion: {label: 'Notion', color: 'success'}
                        };
                        function showSocialInput(network) {
                            const container = document.getElementById('social-inputs');
                            const inputDiv = document.getElementById('input-' + network);
                            if (!inputDiv) {
                                const div = document.createElement('div');
                                div.className = 'input-group mb-2';
                                div.id = 'input-' + network;
                                div.innerHTML = `<span class="input-group-text bg-${socialInputs[network].color} text-white">${socialInputs[network].label}</span><input type="url" name="${network}" class="form-control" placeholder="Enlace de ${socialInputs[network].label}">`;
                                container.appendChild(div);
                            } else {
                                inputDiv.remove();
                            }
                        }
                        </script>
                        <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
                        <!-- El script ya está incluido arriba, eliminar duplicado -->
