<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Alumnos</h1>

    {{-- Mensaje de éxito --}}
    @if(session()->has('mensaje'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- Buscador --}}
    <div class="mb-4 relative">
        <input type="text" wire:model="q" placeholder="Buscar por nombre, email..."
            class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" />

        {{-- Sugerencias --}}
        @if(strlen($q) >= 4 && count($sugerencias) > 0)
            <ul class="absolute z-10 bg-white shadow-md rounded mt-1 w-full">
                @foreach($sugerencias as $sug)
                    <li wire:click="verAlumno({{ $sug->id }})"
                        class="p-2 cursor-pointer hover:bg-gray-100">
                        {{ $sug->name }} ({{ $sug->email }})
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-left">Alumno</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 flex items-center gap-3">
                            <img src="{{ $alumno->foto_perfil ?? 'https://ui-avatars.com/api/?name='.$alumno->name }}"
                                class="w-10 h-10 rounded-full object-cover">
                            <span class="font-medium">{{ $alumno->name }}</span>
                        </td>
                        <td class="p-3">{{ $alumno->email }}</td>
                        <td class="p-3 flex gap-2">
                            <button wire:click="verAlumno({{ $alumno->id }})"
                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Ver
                            </button>
                            <button wire:click="eliminarAlumno({{ $alumno->id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
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

    {{-- Detalle del alumno --}}
    @if($alumnoSeleccionado)
        <div class="mt-6 p-4 bg-white shadow rounded-lg">
            <h2 class="text-xl font-bold mb-3">Detalles del Alumno</h2>
            <div class="flex items-center gap-4 mb-4">
                <img src="{{ $alumnoSeleccionado->foto_perfil ?? 'https://ui-avatars.com/api/?name='.$alumnoSeleccionado->name }}"
                    class="w-20 h-20 rounded-full object-cover">
                <div>
                    <p class="font-bold text-lg">{{ $alumnoSeleccionado->name }}</p>
                    <p class="text-gray-600">{{ $alumnoSeleccionado->email }}</p>
                </div>
            </div>
            <ul class="space-y-2">
                <li><strong>WhatsApp:</strong> {{ $alumnoSeleccionado->whatsapp ?? '-' }}</li>
                <li><strong>DNI:</strong> {{ $alumnoSeleccionado->dni ?? '-' }}</li>
                <li><strong>Fecha de Nacimiento:</strong> {{ $alumnoSeleccionado->fecha_nacimiento ?? '-' }}</li>
                <li><strong>Comisión:</strong> {{ $alumnoSeleccionado->comision ?? '-' }}</li>
                <li><strong>Carrera:</strong> {{ $alumnoSeleccionado->carrera ?? '-' }}</li>
            </ul>
        </div>
    @endif
</div>