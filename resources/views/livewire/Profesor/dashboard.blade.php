@extends('layouts.app')

@section('title', 'Dashboard Profesor')

@section('content')
<div class="min-h-screen w-full bg-white flex flex-col">

    <!-- Header -->
    <header class="w-full bg-white px-6 py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-100 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5c-2.28-3.132-4.77-5.375-7.16-6.922L12 14z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-2xl text-gray-800">SICEP</h1>
                    <h2 class="text-lg font-bold">Panel del Profesor</h2>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <span class="text-xs text-gray-500">Profesor</span>
                    <p class="text-gray-800 font-medium">{{ $profesor->name }}</p>
                </div>
                <img src="{{ $profesor->profile_photo ? asset('storage/'.$profesor->profile_photo) : 'https://ui-avatars.com/api/?name='.$profesor->name.'&background=6366F1&color=fff' }}"
                     class="h-10 w-10 rounded-full border" alt="avatar">
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="flex-1 w-full px-6 py-4">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 flex flex-col">

            <!-- Título -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div>
                    <h2 class="text-lg font-bold mb-2">Lista de Alumnos</h2>
                    <p class="text-sm text-gray-600 mb-4">{{ $alumnos->count() }} alumnos registrados</p>
                </div>
            </div>

            <!-- Buscador -->
            <div class="mb-6">
                <input type="text" wire:model.debounce.300ms="q" placeholder="Buscar por nombre, email..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Tabla de alumnos -->
            @if($alumnos->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-gray-600 font-medium">No hay alumnos registrados</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-3">Alumno</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($alumnos as $alumno)
                            <tr class="border-b">
                                <td class="p-3 flex items-center gap-2">
                                    <img src="{{ $alumno->profile_photo ? asset('storage/'.$alumno->profile_photo) : 'https://ui-avatars.com/api/?name='.$alumno->name.'&background=ddd&color=333' }}"
                                         class="h-10 w-10 rounded-full object-cover" alt="{{ $alumno->name }}">
                                    <span class="font-medium text-gray-800">{{ $alumno->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $alumno->email }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button wire:click="verAlumno({{ $alumno->id }})"
                                            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                        Ver
                                    </button>
                                    <button wire:click="eliminarAlumno({{ $alumno->id }})"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Modal alumno -->
    @if($alumnoSeleccionado)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <button wire:click="cerrarModal"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

                <img src="{{ $alumnoSeleccionado->profile_photo ? asset('storage/'.$alumnoSeleccionado->profile_photo) : 'https://ui-avatars.com/api/?name='.$alumnoSeleccionado->name.'&background=ddd&color=333' }}"
                     class="h-32 w-32 rounded-full object-cover mx-auto mb-4">

                <h3 class="text-lg font-semibold text-center mb-2">{{ $alumnoSeleccionado->name }}</h3>
                <p class="text-sm text-gray-600 text-center">{{ $alumnoSeleccionado->email }}</p>
                <p class="text-sm text-gray-600 text-center">{{ $alumnoSeleccionado->whatsapp ?? 'No especificado' }}</p>
                <p class="text-sm text-gray-600 text-center">{{ $alumnoSeleccionado->comision ?? 'No especificada' }}</p>
                <p class="text-sm text-gray-600 text-center">{{ $alumnoSeleccionado->dni ?? 'No especificado' }}</p>
                <p class="text-sm text-gray-600 text-center">{{ $alumnoSeleccionado->carrera ?? 'No especificada' }}</p>
                <p class="text-sm text-gray-600 text-center">{{ $alumnoSeleccionado->fecha_nacimiento ?? 'No especificada' }}</p>
            </div>
        </div>
    @endif

    <!-- Mensajes Flash -->
    @if (session()->has('mensaje'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg"
             x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('mensaje') }}
        </div>
    @endif

</div>
@endsection
