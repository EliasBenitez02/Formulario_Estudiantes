@extends('layouts.app')

@section('title', 'Dashboard Profesor')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col items-center">

    <!-- Header -->
    <header class="w-full bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            
            <!-- Logo + Nombre -->
            <div class="flex items-center gap-2">
                <div class="bg-indigo-100 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5c-2.28-3.132-4.77-5.375-7.16-6.922L12 14z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-gray-800">SICEP</h1>
                    <span class="text-sm text-gray-500">Panel del Profesor</span>
                </div>
            </div>

            <!-- Usuario -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <span class="text-xs text-gray-500">Profesor</span>
                    <p class="text-gray-800 font-medium">{{ $profesor->name }}</p>
                </div>
                <img src="{{ $profesor->profile_photo ?? 'https://ui-avatars.com/api/?name='.$profesor->name.'&background=6366F1&color=fff' }}"
                    class="h-10 w-10 rounded-full border" alt="avatar">
            </div>
        </div>
    </header>

    <!-- Tarjeta principal -->
    <main class="w-full max-w-6xl mt-8 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 flex flex-col">

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Lista de Alumnos</h2>
                    <p class="text-sm text-gray-500">{{ $alumnos->count() }} alumnos registrados</p>
                </div>
            </div>

            <!-- Buscador -->
            <div class="mb-6">
                <input type="text" wire:model="search" placeholder="Buscar por nombre o correo..."
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Lista de alumnos -->
            @if($alumnos->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-gray-600 font-medium">No hay alumnos registrados</p>
                </div>
            @else
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($alumnos as $alumno)
                        <li class="bg-gray-50 rounded-lg p-4 shadow-sm flex flex-col items-center">
                            <img src="{{ $alumno->profile_photo ?? 'https://ui-avatars.com/api/?name='.$alumno->name.'&background=ddd&color=333' }}"
                                class="h-24 w-24 rounded-full object-cover mb-3" alt="{{ $alumno->name }}">
                            <p class="font-medium text-gray-800 text-center">{{ $alumno->name }}</p>
                            <p class="text-sm text-gray-500 text-center">{{ $alumno->email }}</p>

                            <div class="flex gap-2 mt-2">
                                <button wire:click="verAlumno({{ $alumno->id }})"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                    Ver
                                </button>

                                <button wire:click="eliminarAlumno({{ $alumno->id }})"
                                    onclick="confirm('¿Seguro que quieres eliminar este alumno?') || event.stopImmediatePropagation()"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    Eliminar
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </main>

    <!-- Modal Alumno -->
    @if($alumnoSeleccionado)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
                <button wire:click="$set('alumnoSeleccionado', null)"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

                <img src="{{ $alumnoSeleccionado->profile_photo ?? 'https://ui-avatars.com/api/?name='.$alumnoSeleccionado->name.'&background=ddd&color=333' }}"
                    class="h-32 w-32 rounded-full object-cover mx-auto mb-4">

                <h3 class="text-lg font-semibold text-center mb-2">{{ $alumnoSeleccionado->name }}</h3>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->email }}</p>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->whattsapp }}</p>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->comision }}</p>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->dni }}</p>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->caarrera }}</p>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->fecha_nacimiento }}</p>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $alumnoSeleccionado->email }}</p>

            </div>
        </div>
    @endif

</div>
@endsection
