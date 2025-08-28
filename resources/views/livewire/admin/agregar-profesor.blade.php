@extends('components.layouts.admin-layout')
@section('title', 'Agregar Profesor')
@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Agregar Profesor</h2>
    <form method="POST" action="{{ route('admin.profesores.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Nombre" class="w-full mb-2 p-2 border rounded" required>
        <input type="email" name="email" placeholder="Correo" class="w-full mb-2 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full mb-2 p-2 border rounded" required>
        <select name="course_id" class="w-full mb-2 p-2 border rounded" required>
            <option value="">Selecciona un curso</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso->id }}">{{ $curso->name }}</option>
            @endforeach
        </select>
        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Agregar</button>
        </div>
    </form>
</div>
@endsection
