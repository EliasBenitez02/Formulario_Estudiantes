@extends('components.layouts.admin-layout')
@section('title', 'Agregar Curso')
@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Agregar Curso</h2>
    <form method="POST" action="{{ route('admin.cursos.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Nombre del curso" class="w-full mb-2 p-2 border rounded" required>
        <input type="text" name="description" placeholder="Descripción" class="w-full mb-2 p-2 border rounded" required>
        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Agregar</button>
        </div>
    </form>
</div>
@endsection
