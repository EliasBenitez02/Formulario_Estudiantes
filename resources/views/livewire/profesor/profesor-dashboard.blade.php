@extends('layouts.app')
@section('title', 'Dashboard Profesor')
@section('content')






<div class="min-h-screen w-full bg-white flex flex-col"> <!-- contenedor raíz -->

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
                    <p class="text-gray-800 font-medium">{{ $profesor->name ?? 'Invitado' }}</p>
                </div>
                <img src="{{ $profesor && $profesor->profile_photo ? asset('storage/'.$profesor->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($profesor?->name).'&background=6366F1&color=fff' }}"
                    class="h-10 w-10 rounded-full border" alt="avatar">

            </div>
        </div>
    </header>

    <!-- Tarjetas resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-6">
        <div class="bg-white shadow rounded p-4 text-center">
            <h2 class="text-xl font-semibold mb-2">Alumnos Totales</h2>
            <p class="text-2xl font-bold text-blue-600">{{ $alumnos->total() }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h2 class="text-xl font-semibold mb-2">Alumnos Activos</h2>
            <p class="text-2xl font-bold text-green-600">{{ $alumnos->where('activo',1)->count() }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h2 class="text-xl font-semibold mb-2">Próximos Eventos</h2>
            <p class="text-2xl font-bold text-purple-600">3</p>
        </div>
    </div>

    <!-- Buscador -->
    <div class="mb-6 px-6">
        <input type="text" wire:model.debounce.300ms="q" placeholder="Buscar por nombre, email..."
            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <!-- Grilla de alumnos -->
    <div class="px-6 mb-8">
        @if($alumnos->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <p class="text-gray-600 font-medium">No hay alumnos registrados</p>
        </div>
        @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($alumnos as $alumno)
            <li class="bg-white rounded shadow hover:shadow-lg transition p-4 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-1">{{ $alumno->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $alumno->email }}</p>
                    <p class="text-gray-500 text-sm">WhatsApp: {{ $alumno->whatsapp ?? '-' }}</p>
                    <p class="text-gray-500 text-sm">Comisión: {{ $alumno->comision ?? '-' }}</p>
                </div>
                <div class="mt-4 flex justify-between">
                    <button wire:click="verAlumno({{ $alumno->id }})"
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        Ver
                    </button>
                    <button wire:click="eliminarAlumno({{ $alumno->id }})"
                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                        Eliminar
                    </button>
                </div>
            </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $alumnos->links() }}
        </div>
        @endif
    </div>

    <!-- Modal de detalle de alumno -->
    @if($alumnoSeleccionado)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Detalle del Alumno</h2>
            <p><strong>Nombre:</strong> {{ $alumnoSeleccionado->name }}</p>
            <p><strong>Email:</strong> {{ $alumnoSeleccionado->email }}</p>
            <p><strong>WhatsApp:</strong> {{ $alumnoSeleccionado->whatsapp ?? '-' }}</p>
            <p><strong>Comisión:</strong> {{ $alumnoSeleccionado->comision ?? '-' }}</p>
            <p><strong>Carrera:</strong> {{ $alumnoSeleccionado->carrera ?? '-' }}</p>
            <p><strong>DNI:</strong> {{ $alumnoSeleccionado->dni ?? '-' }}</p>
            <p><strong>Fecha Nac.:</strong> {{ $alumnoSeleccionado->fecha_nacimiento ?? '-' }}</p>

            <button wire:click="cerrarModal"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                Cerrar
            </button>
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

</div> <!-- fin contenedor raíz -->
@endsection