<div class="max-w-6xl mx-auto p-6">

    {{-- Mensaje de sesión --}}
    @if(session()->has('mensaje'))
        <div class="alert alert-success mb-4">{{ session('mensaje') }}</div>
    @endif

    {{-- Datos del alumno --}}
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
        <h2 class="text-lg font-semibold mb-2">Tus datos personales</h2>

        @if(!$editando)
            <div class="flex items-center gap-4 mb-3">
                @if($alumno->profile_photo)
                    <img src="{{ asset('storage/'.$alumno->profile_photo) }}" class="w-24 h-24 rounded-full object-cover" alt="Foto de perfil">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xl">
                        {{ strtoupper(substr($nombre,0,1)) }}
                    </div>
                @endif
                <div>
                    <p><strong>Nombre:</strong> {{ $nombre }}</p>
                    <p><strong>Email:</strong> {{ $email }}</p>
                    @if($whatsapp)<p><strong>WhatsApp:</strong> {{ $whatsapp }}</p>@endif
                    @if($comision)<p><strong>Comisión:</strong> {{ $comision }}</p>@endif
                    @if($carrera)<p><strong>Carrera:</strong> {{ $carrera }}</p>@endif
                    <button wire:click="habilitarEdicion" class="btn btn-warning mt-2">Editar mis datos</button>
                </div>
            </div>
        @else
            <form wire:submit.prevent="actualizarDatos" class="space-y-2" enctype="multipart/form-data">
                <div>
                    <label>Nombre:</label>
                    <input type="text" wire:model="nombre" class="form-control" />
                    @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Email:</label>
                    <input type="email" wire:model="email" class="form-control" />
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>WhatsApp:</label>
                    <input type="text" wire:model="whatsapp" class="form-control" />
                </div>
                <div>
                    <label>Comisión:</label>
                    <input type="text" wire:model="comision" class="form-control" />
                </div>
                <div>
                    <label>Carrera:</label>
                    <input type="text" wire:model="carrera" class="form-control" />
                </div>
                <div>
                    <label>Foto de perfil:</label>
                    <input type="file" wire:model="nuevaFoto" class="form-control" accept="image/*">
                    @error('nuevaFoto') <span class="text-danger">{{ $message }}</span> @enderror
                    @if($alumno->profile_photo)
                        <img src="{{ asset('storage/'.$alumno->profile_photo) }}" class="w-24 h-24 rounded-full object-cover mt-2" alt="Foto actual">
                    @endif
                    <button type="button" wire:click="actualizarFoto" class="btn btn-info mt-2">Actualizar foto</button>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Guardar cambios</button>
                <button type="button" wire:click="cancelarEdicion" class="btn btn-secondary mt-2">Cancelar</button>
            </form>
        @endif
    </div>

    {{-- Profesores --}}
    <h2 class="text-2xl font-bold mb-4">Perfil Profesor</h2>

    @if($profesores->count() === 0)
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
            No se encontraron profesores con ese criterio.
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($profesores as $prof)
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <div class="flex items-center gap-3">
                        @if($prof->profile_photo)
                            <img src="{{ asset('storage/'.$prof->profile_photo) }}" class="w-12 h-12 rounded-full object-cover" alt="Foto">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                {{ strtoupper(substr($prof->name,0,1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold">{{ $prof->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $prof->email }}</p>
                            <p class="text-xs text-gray-500">Rol: Profesor</p>
                        </div>
                    </div>

                    <div class="mt-3 text-sm text-gray-700 space-y-1">
                        @if($prof->whatsapp)<p><strong>WhatsApp:</strong> {{ $prof->whatsapp }}</p>@endif
                        @if($prof->comision)<p><strong>Comisión:</strong> {{ $prof->comision }}</p>@endif
                        @if($prof->carrera)<p><strong>Carrera:</strong> {{ $prof->carrera }}</p>@endif
                        @if(!empty($prof->telefono))<p><strong>Teléfono:</strong> {{ $prof->telefono }}</p>@endif
                        @if(!empty($prof->descripcion))<p><strong>Descripción:</strong> {{ $prof->descripcion }}</p>@endif
                    </div>

                    <div class="mt-3 pt-3 border-t text-sm">
                        <p class="font-medium mb-1">Perfiles sociales:</p>
                        @php $profiles = $prof->socialProfiles; @endphp
                        @if($profiles->isNotEmpty())
                            <ul class="space-y-1">
                                @foreach($profiles as $sp)
                                    @if($sp->linkedin)<li><a href="{{ $sp->linkedin }}" target="_blank" class="text-blue-600 underline">LinkedIn</a></li>@endif
                                    @if($sp->github)<li><a href="{{ $sp->github }}" target="_blank" class="text-blue-600 underline">GitHub</a></li>@endif
                                    @if($sp->gitlab)<li><a href="{{ $sp->gitlab }}" target="_blank" class="text-blue-600 underline">GitLab</a></li>@endif
                                    @if($sp->wordpress)<li><a href="{{ $sp->wordpress }}" target="_blank" class="text-blue-600 underline">WordPress</a></li>@endif
                                    @if($sp->notion)<li><a href="{{ $sp->notion }}" target="_blank" class="text-blue-600 underline">Notion</a></li>@endif
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Sin perfiles sociales cargados.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $profesores->links() }}
        </div>
    @endif

</div>
