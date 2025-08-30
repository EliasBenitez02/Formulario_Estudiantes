@extends('components.layouts.admin-layout')
@section('title', 'Dashboard')
@section('content')
    @if (session()->has('mensaje'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('mensaje') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold mb-4">Profesores</h2>
    <table class="table-auto w-full mb-8">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profesores as $profesor)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $profesor->name }}</td>
                    <td class="px-4 py-2">{{ $profesor->email }}</td>
                    <td class="px-4 py-2">
                        <button type="button" onclick="if(confirm('¿Seguro que quieres eliminar {{ $profesor->name }}?')) { window.livewire.emit('eliminarProfesor', {{ $profesor->id }}); }" class="btn btn-danger btn-sm bg-red-600 text-white px-3 py-1 rounded">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mb-4">Cursos</h2>
    <table class="table-auto w-full">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $curso->name }}</td>
                    <td class="px-4 py-2">{{ $curso->description }}</td>
                    <td class="px-4 py-2">
                        <button type="button" onclick="window.livewire.emit('eliminarCurso', {{ $curso->id }});" class="btn btn-danger btn-sm bg-red-600 text-white px-3 py-1 rounded">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
