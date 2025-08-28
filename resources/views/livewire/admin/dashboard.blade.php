
<div>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-blue-700">Panel de Administrador</h1>
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Profesores</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded shadow">
                        <thead>
                            <tr class="bg-blue-100 text-blue-700">
                                <th class="py-2 px-4 text-left">Nombre</th>
                                <th class="py-2 px-4 text-left">Correo</th>
                                <th class="py-2 px-4 text-left">Curso</th>
                                <th class="py-2 px-4 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profesores as $prof)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $prof->name }}</td>
                                <td class="py-2 px-4">{{ $prof->email }}</td>
                                <td class="py-2 px-4">{{ $prof->course->name ?? 'Sin curso' }}</td>
                                <td class="py-2 px-4">
                                    <button wire:click="eliminarProfesor({{ $prof->id }})" class="bg-red-500 text-white px-3 py-1 rounded">Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4">Cursos</h2>
                <ul class="space-y-2">
                    @foreach($cursos as $curso)
                        <li class="bg-white p-4 rounded shadow flex justify-between items-center">
                            <span>{{ $curso->name }}</span>
                            <button wire:click="eliminarCurso({{ $curso->id }})" class="bg-red-500 text-white px-3 py-1 rounded">Eliminar</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
