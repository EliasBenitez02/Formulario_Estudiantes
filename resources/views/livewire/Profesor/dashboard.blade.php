{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')



@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    {{-- Encabezado del sistema --}}
    <div class="flex flex-col items-center mb-8">
        <div class="flex items-center gap-3 mb-2">
            {{-- Icono de profesor --}}
            <span class="bg-blue-600 text-white rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-6m0 0l-9-5m9 5l9-5" />
                </svg>
            </span>
            <h1 class="text-4xl font-bold text-blue-700">SICEP</h1>
        </div>
        <span class="text-lg text-gray-600">Sistema Integral de Control Escolar del Profesor</span>
    </div>

    {{-- Perfil del profesor --}}
    <div class="flex flex-col items-center mb-10">
        @if(!empty(auth()->user()->foto))
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-600 mb-2">
                <img src="{{ asset('uploads/' . auth()->user()->foto) }}" alt="Foto del Profesor" class="w-full h-full object-cover">
            </div>
        @endif

        @if(!empty(auth()->user()->name))
            <div class="text-xl font-semibold text-gray-800">{{ auth()->user()->name }}</div>
        @endif

        @if(!empty(auth()->user()->email))
            <div class="text-gray-500">{{ auth()->user()->email }}</div>
        @endif
    </div>

    {{-- Buscador --}}
    <div class="max-w-2xl mx-auto mb-8">
        <input type="text" placeholder="Buscar alumno por nombre o correo..."
            class="w-full p-3 rounded-xl border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
    </div>

    {{-- Lista de alumnos --}}
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-700">Lista de Alumnos</h2>
    @if(count($alumnos ?? []) > 0)
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($alumnos as $alumno)
                <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col items-center hover:shadow-xl transition duration-300">
                    <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-4 overflow-hidden">
                        @if(!empty($alumno->foto))
                            <img src="{{ asset('uploads/' . $alumno->foto) }}" alt="Foto de {{ $alumno->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-3xl uppercase">{{ substr($alumno->name, 0, 1) }}</span>
                        @endif
                    </div>
                    @if(!empty($alumno->name))
                        <h3 class="text-lg font-semibold text-gray-800 mb-1 text-center">{{ $alumno->name }}</h3>
                    @endif
                    @if(!empty($alumno->email))
                        <p class="text-gray-500 text-sm text-center">{{ $alumno->email }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        {{-- Contenedor de mensaje de vaciado --}}
        <div class="max-w-md mx-auto bg-white p-8 rounded-3xl shadow-lg text-center mt-10">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 1119.88 6.196 9 9 0 015.12 17.804z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold mb-2">No hay alumnos registrados</h2>
                <p class="text-gray-500">Comienza agregando tu primer alumno al sistema</p>
            </div>
        </div>
    @endif
</div>
@endsection