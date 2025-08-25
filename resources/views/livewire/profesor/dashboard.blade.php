<div class="p-6 min-h-screen bg-gray-100">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <h1 class="text-3xl font-bold text-blue-700">SICEP - Dashboard del Profesor</h1>
        </div>
        <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300" wire:click="acercaDe">
            Acerca de
        </button>
    </div>

    {{-- Perfil del Profesor --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-6 mb-8">
        <img src="{{ auth()->user()->foto_perfil ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-blue-500">
        <div>
            <p class="font-bold text-xl">{{ auth()->user()->name }}</p>
            <p class="text-gray-600">{{ auth()->user()->email }}</p>
            <div class="flex gap-2 mt-2">
                <button class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600" wire:click="editarPerfil">
                    Editar Perfil
                </button>
            </div>
        </div>
    </div>

    {{-- Lista de Alumnos --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Lista de Alumnos</h2>
        @if(session()->has('mensaje'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('mensaje') }}
            </div>
        @endif

        <div class="mb-4 relative">
            <input type="text" wire:model="q" placeholder="Buscar por nombre, email..." class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" />
            @if(strlen($q) >= 4 && count($sugerencias) > 0)
                <ul class="absolute z-10 bg-white shadow-md rounded mt-1 w-full">
                    @foreach($sugerencias as $sug)
                        <li wire:click="verAlumno({{ $sug->id }})" class="p-2 cursor-pointer hover:bg-gray-100">
                            {{ $sug->name }} ({{ $sug->email }})
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-blue-100 text-blue-700">
                    <tr>
                        <th class="p-3 text-left">Foto</th>
                        <th class="p-3 text-left">Alumno</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Redes</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumnos as $alumno)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">
                                <img src="{{ $alumno->foto_perfil ?? 'https://ui-avatars.com/api/?name='.$alumno->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-green-400">
                            </td>
                            <td class="p-3 font-medium">{{ $alumno->name }}</td>
                            <td class="p-3">{{ $alumno->email }}</td>
                            <td class="p-3 flex gap-2">
                                @if($alumno->whatsapp)
                                    <a href="https://wa.me/{{ $alumno->whatsapp }}" target="_blank" title="WhatsApp">
                                        <svg class="w-6 h-6 text-green-500 hover:text-green-700" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.52 3.48A12 12 0 003.48 20.52a12 12 0 0017.04-17.04zm-8.52 18.52a10.5 10.5 0 01-5.62-1.62l-.4-.24-4.13 1.08 1.1-4.03-.26-.42A10.5 10.5 0 1112 22.01zm5.2-7.2c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.13-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.27-.48.09-.19.05-.36-.02-.5-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.36-.01-.56-.01-.19 0-.5.07-.76.34-.26.27-1 1-1 2.43s1.03 2.82 1.18 3.02c.15.2 2.03 3.18 5.01 4.34.7.27 1.25.43 1.68.55.71.19 1.36.16 1.87.1.57-.07 1.65-.67 1.89-1.32.24-.65.24-1.21.17-1.32z"/>
                                        </svg>
                                    </a>
                                @endif
                            </td>
                            <td class="p-3 flex gap-2">
                                <button wire:click="verAlumno({{ $alumno->id }})" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver
                                </button>
                                <button wire:click="eliminarAlumno({{ $alumno->id }})" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-3">
                {{ $alumnos->links() }}
            </div>
        </div>
    </div>

    {{-- Card de Detalle del Alumno --}}
    @if($alumnoSeleccionado)
        <div class="mt-8 p-6 bg-white rounded-xl shadow flex flex-col md:flex-row gap-6 items-center">
            <img src="{{ $alumnoSeleccionado->foto_perfil ?? 'https://ui-avatars.com/api/?name='.$alumnoSeleccionado->name }}" class="w-32 h-32 rounded-full object-cover border-2 border-green-400">
            <div>
                <h2 class="text-xl font-bold mb-3">Detalles del Alumno</h2>
                <ul class="space-y-2">
                    <li><strong>Nombre:</strong> {{ $alumnoSeleccionado->name }}</li>
                    <li><strong>Email:</strong> {{ $alumnoSeleccionado->email }}</li>
                    <li><strong>WhatsApp:</strong>
                        @if($alumnoSeleccionado->whatsapp)
                            <a href="https://wa.me/{{ $alumnoSeleccionado->whatsapp }}" target="_blank" class="text-green-600 underline">
                                {{ $alumnoSeleccionado->whatsapp }}
                                <svg class="inline w-5 h-5 ml-1 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.52 3.48A12 12 0 003.48 20.52a12 12 0 0017.04-17.04zm-8.52 18.52a10.5 10.5 0 01-5.62-1.62l-.4-.24-4.13 1.08 1.1-4.03-.26-.42A10.5 10.5 0 1112 22.01zm5.2-7.2c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.13-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.27-.48.09-.19.05-.36-.02-.5-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.36-.01-.56-.01-.19 0-.5.07-.76.34-.26.27-1 1-1 2.43s1.03 2.82 1.18 3.02c.15.2 2.03 3.18 5.01 4.34.7.27 1.25.43 1.68.55.71.19 1.36.16 1.87.1.57-.07 1.65-.67 1.89-1.32.24-.65.24-1.21.17-1.32z"/>
                                </svg>
                            </a>
                        @else
                            -
                        @endif
                    </li>
                    <li><strong>DNI:</strong> {{ $alumnoSeleccionado->dni ?? '-' }}</li>
                    <li><strong>Fecha de Nacimiento:</strong> {{ $alumnoSeleccionado->fecha_nacimiento ?? '-' }}</li>
                    <li><strong>Comisión:</strong> {{ $alumnoSeleccionado->comision ?? '-' }}</li>
                    <li><strong>Carrera:</strong> {{ $alumnoSeleccionado->carrera ?? '-' }}</li>
                </ul>
            </div>
        </div>
    @endif

    {{-- Modal Editar Perfil --}}
    @if($mostrarEditarPerfil)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Editar Perfil</h2>
                <form wire:submit.prevent="guardarPerfil">
                    <div class="mb-2">
                        <label class="block font-bold">Nombre</label>
                        <input type="text" wire:model.defer="profesorEdit.name" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">Email</label>
                        <input type="email" wire:model.defer="profesorEdit.email" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">DNI</label>
                        <input type="text" wire:model.defer="profesorEdit.dni" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">WhatsApp</label>
                        <input type="text" wire:model.defer="profesorEdit.whatsapp" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">Fecha de Nacimiento</label>
                        <input type="date" wire:model.defer="profesorEdit.fecha_nacimiento" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">Comisión</label>
                        <input type="text" wire:model.defer="profesorEdit.comision" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">Carrera</label>
                        <input type="text" wire:model.defer="profesorEdit.carrera" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-2">
                        <label class="block font-bold">Foto de Perfil</label>
                        <input type="file" wire:model="fotoPerfilProfesor" class="w-full">
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
                        <button type="button" wire:click="cerrarModales" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Acerca de --}}
    @if($mostrarAcercaDe)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Acerca de</h2>
                <ul class="space-y-2">
                    <li><strong>Nombre:</strong> {{ auth()->user()->name }}</li>
                    <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                    <li><strong>DNI:</strong> {{ auth()->user()->dni ?? '-' }}</li>
                    <li><strong>WhatsApp:</strong> {{ auth()->user()->whatsapp ?? '-' }}</li>
                    <li><strong>Fecha de Nacimiento:</strong> {{ auth()->user()->fecha_nacimiento ?? '-' }}</li>
                    <li><strong>Comisión:</strong> {{ auth()->user()->comision ?? '-' }}</li>
                    <li><strong>Carrera:</strong> {{ auth()->user()->carrera ?? '-' }}</li>
                </ul>
                <div class="flex justify-end mt-4">
                    <button type="button" wire:click="cerrarModales" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cerrar</button>
                </div>
            </div>
        </div>
    @endif
</div>