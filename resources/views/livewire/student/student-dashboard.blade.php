<div class="max-w-6xl mx-auto p-4 sm:p-6 space-y-6">

  {{-- HEADER con marca + Cerrar sesión --}}
  <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-4 sm:px-6 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
        <span class="text-blue-600 text-xl">🎓</span>
      </div>
      <div>
        <div class="text-lg font-semibold leading-tight">SICEP</div>
        <div class="text-xs text-gray-500 -mt-0.5">Panel del Alumno</div>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <div class="hidden sm:block text-right">
        <div class="text-sm font-medium">{{ $alumno->name }}</div>
        <div class="text-xs text-gray-500">Alumno</div>
      </div>
      <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-200">
        @if($alumno->profile_photo)
          <img class="w-full h-full object-cover" src="{{ asset('storage/'.$alumno->profile_photo) }}" alt="Foto">
        @else
          <div class="w-full h-full flex items-center justify-center text-gray-600">
            {{ strtoupper(substr($alumno->name,0,1)) }}
          </div>
        @endif
      </div>

      {{-- Botón Cerrar sesión --}}
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="btn btn-outline-danger btn-sm whitespace-nowrap">
          Cerrar sesión
        </button>
      </form>
    </div>
  </div>

  {{-- TARJETA: MIS DATOS --}}
  <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-6 py-4 border-b">
      <h2 class="text-lg font-semibold">Mis Datos</h2>

      @if(!$editando)
        <button wire:click="habilitarEdicion"
                class="inline-flex items-center gap-2 px-3 py-1.5 text-sm rounded-md border bg-white hover:bg-gray-50">
          <span class="opacity-70">✎</span> Editar
        </button>
      @endif
    </div>

    <div class="px-4 sm:px-6 py-5">
      {{-- AVATAR --}}
      <div class="mb-4">
        @if($alumno->profile_photo)
          <img src="{{ asset('storage/'.$alumno->profile_photo) }}" class="w-20 h-20 rounded-full object-cover ring-2 ring-blue-100" alt="Foto de perfil">
        @else
          <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 ring-2 ring-gray-100">
            {{ strtoupper(substr($nombre,0,1)) }}
          </div>
        @endif
      </div>

      @if (session()->has('mensaje'))
        <div class="alert alert-success mb-3">{{ session('mensaje') }}</div>
      @endif

      @if(!$editando)
        {{-- MODO LECTURA --}}
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="form-label text-gray-600 text-sm">Nombre</label>
            <input type="text" value="{{ $nombre }}" class="form-control bg-gray-100" readonly>
          </div>
          <div>
            <label class="form-label text-gray-600 text-sm">Email</label>
            <input type="text" value="{{ $email }}" class="form-control bg-gray-100" readonly>
          </div>
          <div>
            <label class="form-label text-gray-600 text-sm">WhatsApp</label>
            <input type="text" value="{{ $whatsapp ?: '—' }}" class="form-control bg-gray-100" readonly>
          </div>
          <div>
            <label class="form-label text-gray-600 text-sm">Comisión</label>
            <input type="text" value="{{ $comision ?: '—' }}" class="form-control bg-gray-100" readonly>
          </div>
          <div>
            <label class="form-label text-gray-600 text-sm">Carrera</label>
            <input type="text" value="{{ $carrera ?: '—' }}" class="form-control bg-gray-100" readonly>
          </div>
        </div>
      @else
        {{-- MODO EDICIÓN: dos columnas, a la izq valores actuales, a la der formulario --}}
        <div class="grid lg:grid-cols-2 gap-6">
          {{-- Izquierda: valores actuales --}}
          <div class="rounded-xl border border-gray-100 p-4">
            <div class="text-sm text-gray-500 mb-3">Tus datos actuales</div>
            <div class="space-y-2 text-sm">
              <div><span class="text-gray-500">Nombre:</span> <span class="font-medium">{{ $alumno->name }}</span></div>
              <div><span class="text-gray-500">Email:</span> <span class="font-medium">{{ $alumno->email }}</span></div>
              @if($alumno->whatsapp)<div><span class="text-gray-500">WhatsApp:</span> <span class="font-medium">{{ $alumno->whatsapp }}</span></div>@endif
              @if($alumno->comision)<div><span class="text-gray-500">Comisión:</span> <span class="font-medium">{{ $alumno->comision }}</span></div>@endif
              @if($alumno->carrera)<div><span class="text-gray-500">Carrera:</span> <span class="font-medium">{{ $alumno->carrera }}</span></div>@endif
            </div>
          </div>

          {{-- Derecha: formulario --}}
          <form wire:submit.prevent="actualizarDatos" class="space-y-3" enctype="multipart/form-data">
            <div>
              <label class="form-label">Nombre</label>
              <input type="text" wire:model.defer="nombre" class="form-control" />
              @error('nombre') <span class="text-danger text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
              <label class="form-label">Email</label>
              <input type="email" wire:model.defer="email" class="form-control" />
              @error('email') <span class="text-danger text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
              <div>
                <label class="form-label">WhatsApp</label>
                <input type="text" wire:model.defer="whatsapp" class="form-control" />
              </div>
              <div>
                <label class="form-label">Comisión</label>
                <input type="text" wire:model.defer="comision" class="form-control" />
              </div>
            </div>
            <div>
              <label class="form-label">Carrera</label>
              <input type="text" wire:model.defer="carrera" class="form-control" />
            </div>

            <div class="pt-2">
              <label class="form-label">Foto de perfil</label>
              <div class="flex items-center gap-3">
                <input type="file" wire:model="nuevaFoto" class="form-control" accept="image/*">
                <button type="button" wire:click="actualizarFoto" class="btn btn-outline-primary">Actualizar foto</button>
              </div>
              @error('nuevaFoto') <span class="text-danger text-sm">{{ $message }}</span> @enderror

              @if($nuevaFoto)
                <img src="{{ $nuevaFoto->temporaryUrl() }}" class="w-16 h-16 rounded-full object-cover mt-2 ring-2 ring-blue-100" alt="Preview">
              @endif
            </div>

            <div class="flex items-center gap-2 pt-2">
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
              <button type="button" wire:click="cancelarEdicion" class="btn btn-secondary">Cancelar</button>
            </div>
          </form>
        </div>
      @endif
    </div>
  </div>

  {{-- TARJETA: PERFIL PROFESOR --}}
  <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
    <div class="px-4 sm:px-6 py-4 border-b">
      <h2 class="text-lg font-semibold">Perfil del Profesor</h2>
    </div>

    @if($profesores->count() === 0)
      <div class="p-5 text-gray-600">No se encontraron profesores con ese criterio.</div>
    @else
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4 sm:p-6">
        @foreach($profesores as $prof)
          <div class="p-4 border rounded-xl bg-white hover:shadow-md transition">
            <div class="flex items-center gap-3">
              @if($prof->profile_photo)
                <img src="{{ asset('storage/'.$prof->profile_photo) }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100" alt="Foto">
              @else
                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 ring-2 ring-gray-100">
                  {{ strtoupper(substr($prof->name,0,1)) }}
                </div>
              @endif
              <div>
                <h3 class="text-base font-semibold leading-tight">{{ $prof->name }}</h3>
                <p class="text-xs text-gray-500">Profesor</p>
                <a class="text-xs text-blue-600 underline" href="mailto:{{ $prof->email }}">{{ $prof->email }}</a>
              </div>
            </div>

            <div class="mt-3 text-sm text-gray-700 space-y-1">
              @if($prof->whatsapp)
                @php $numero = preg_replace('/\D/', '', $prof->whatsapp); @endphp
                <p>
                  <strong>WhatsApp:</strong>
                  <a href="https://wa.me/{{ $numero }}" target="_blank" class="text-green-600 underline">
                    {{ $prof->whatsapp }}
                  </a>
                </p>
              @endif
              @if($prof->comision)
                <p><strong>Comisión:</strong> {{ $prof->comision }}</p>
              @endif
              @if($prof->carrera)
                <p><strong>Carrera:</strong> {{ $prof->carrera }}</p>
              @endif
            </div>

            <div class="mt-3 pt-3 border-t text-sm">
              <p class="font-medium mb-1">Redes sociales</p>
              @php $profiles = $prof->socialProfiles; @endphp
              @if($profiles->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                  @if($profiles->first()->linkedin)
                    <a href="{{ $profiles->first()->linkedin }}" target="_blank" class="btn btn-light btn-sm">LinkedIn</a>
                  @endif
                  @if($profiles->first()->github)
                    <a href="{{ $profiles->first()->github }}" target="_blank" class="btn btn-light btn-sm">GitHub</a>
                  @endif
                  @if($profiles->first()->gitlab)
                    <a href="{{ $profiles->first()->gitlab }}" target="_blank" class="btn btn-light btn-sm">GitLab</a>
                  @endif
                </div>
              @else
                <p class="text-gray-400">Sin perfiles sociales cargados.</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>

      <div class="px-4 sm:px-6 pb-5">
        {{ $profesores->links() }}
      </div>
    @endif
  </div>
</div>
