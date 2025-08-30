<div class="min-h-[80vh] bg-slate-50">
  <!-- HEADER -->
  <header class="bg-white border-b">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 py-3 flex flex-col sm:flex-row items-center justify-between">
      <div class="flex items-center gap-2">
        <div class="h-9 w-9 rounded-xl bg-blue-100 ring-1 ring-blue-200 flex items-center justify-center">
          <span class="text-blue-600 text-lg">🎓</span>
        </div>
        <div class="leading-tight">
          <p class="text-slate-800 font-semibold">SICEP</p>
          <p class="text-[11px] text-slate-500 -mt-0.5">Panel del Alumno</p>
        </div>
      </div>

      <!-- Centro: nombre y foto -->
      <div class="flex flex-col items-center gap-2 flex-1">
        <div class="h-12 w-12 rounded-full overflow-hidden bg-slate-200 ring-1 ring-white mx-auto">
          @if($alumno->profile_photo)
            <img src="{{ asset('storage/'.$alumno->profile_photo) }}" class="w-full h-full object-cover" alt="Foto">
          @else
            <div class="w-full h-full flex items-center justify-center text-slate-600 font-semibold">
              {{ strtoupper(substr($alumno->name,0,1)) }}
            </div>
          @endif
        </div>

        <div class="text-center leading-tight">
          <p class="text-sm text-slate-800 font-medium">{{ $alumno->name }}</p>
          <p class="text-[11px] text-slate-400 -mt-0.5">Alumno</p>
        </div>
       
      </div>

      <div class="flex items-center gap-3">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
              class="inline-flex items-center gap-1.5 text-xs font-medium rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-rose-700 hover:bg-rose-100">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M15 12H3m0 0l4-4m-4 4l4 4m8-8v8a4 4 0 004 4h0a4 4 0 004-4V8a4 4 0 00-4-4h0a4 4 0 00-4 4z"/>
              </svg>
              Cerrar sesión
          </button>
        </form>
      </div>
    </div>
  </header>

  <main class="mx-auto max-w-6xl px-4 sm:px-6 py-4 space-y-4 sm:space-y-6">

    <!-- MIS DATOS -->
    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="flex items-center justify-between px-4 sm:px-5 py-3 border-b border-slate-100">
        <h2 class="text-slate-800 font-semibold">Mis Datos</h2>

        @if(!$editando)
          <button wire:click="habilitarEdicion"
                  class="inline-flex items-center gap-1.5 text-slate-600 hover:text-slate-800 text-xs font-medium rounded-lg border border-slate-200 bg-white px-2.5 py-1.5">
            <svg class="h-4 w-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4h2m-1 0v4m0 0l7 7M4 13l7-7"/></svg>
            Editar
          </button>
        @endif
      </div>

      <div class="px-4 sm:px-6 py-5">
        <!-- AVATAR -->
        <div class="mb-4">
          @if($alumno->profile_photo)
            <img src="{{ asset('storage/'.$alumno->profile_photo) }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-blue-50" alt="Foto">
          @else
            <div class="h-16 w-16 rounded-full bg-slate-200 ring-2 ring-slate-100 flex items-center justify-center text-slate-600 font-semibold">
              {{ strtoupper(substr($alumno->name,0,1)) }}
            </div>
          @endif
        </div>

        @if (session()->has('mensaje'))
          <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-emerald-800 text-sm">
            {{ session('mensaje') }}
          </div>
        @endif

        @if(!$editando)
          <!-- LECTURA -->
          <div class="grid sm:grid-cols-2 gap-4">
            @php
              $dni = $alumno->dni ?? null;
              $fecha = $alumno->fecha_nacimiento ?? null; // usa el nombre real del campo
            @endphp

            <div class="space-y-1">
              <label class="text-[12px] text-slate-500">Nombre completo</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800">{{ $nombre ?? $alumno->name }}</div>
            </div>

            <div class="space-y-1">
              <label class="text-[12px] text-slate-500">Correo electrónico</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800 truncate">{{ $email ?? $alumno->email }}</div>
            </div>

            <div class="space-y-1">
              <label class="text-[12px] text-slate-500">WhatsApp</label>
              <div class="relative">
                <div class="rounded-xl border border-slate-200 bg-slate-50 pl-3 pr-9 py-2.5 text-sm text-slate-800">{{ $whatsapp ?: ($alumno->whatsapp ?? '—') }}</div>
                <span class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500">
                  <!-- ícono globo -->
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a4 4 0 01-4 4H7l-4 4V7a4 4 0 014-4h10a4 4 0 014 4v8z" stroke-width="2"/></svg>
                </span>
              </div>
            </div>

          <div class="space-y-1">
              <label class="text-[12px] text-slate-500">Curso</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800">
                {{ $alumno->course ? $alumno->course->name : '—' }}
              </div>
            </div>

            <div class="space-y-1">
              <label class="text-[12px] text-slate-500">DNI</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800">{{ $dni ?: '—' }}</div>
            </div>

            <div class="space-y-1">
              <label class="text-[12px] text-slate-500">Carrera</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800">{{ $carrera ?: ($alumno->carrera ?? '—') }}</div>
            </div>

        

            <div class="space-y-1 sm:col-span-2">
              <label class="text-[12px] text-slate-500">Fecha de nacimiento</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800">
                {{ $fecha ? \Illuminate\Support\Carbon::parse($fecha)->format('d/m/Y') : '—' }}
              </div>
            </div>

            <div class="space-y-1 sm:col-span-2">
              <label class="text-[12px] text-slate-500">Redes sociales</label>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800">
                @php
                  $sp = $alumno->socialProfiles->first();
                @endphp
                @if($sp && ($sp->linkedin || $sp->github || $sp->gitlab || $sp->wordpress || $sp->notion))
                  <div class="flex flex-wrap gap-2">
                    @if($sp->linkedin)
                      <a href="{{ $sp->linkedin }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-blue-700 bg-white hover:bg-slate-50">
                        <span class="i">in</span> LinkedIn
                      </a>
                    @endif
                    @if($sp->github)
                      <a href="{{ $sp->github }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-slate-700 bg-white hover:bg-slate-50">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .5C5.73.5.98 5.24.98 11.5c0 4.85 3.14 8.96 7.49 10.41.55.11.75-.24.75-.53 0-.26-.01-1.12-.02-2.03-3.05.66-3.7-1.3-3.7-1.3-.5-1.27-1.23-1.6-1.23-1.6-.99-.68.08-.67.08-.67 1.1.08 1.68 1.14 1.68 1.14.97 1.67 2.55 1.19 3.18.91.1-.7.38-1.19.68-1.46-2.44-.28-5-1.22-5-5.43 0-1.2.43-2.18 1.14-2.95-.11-.28-.5-1.41.11-2.94 0 0 .94-.3 3.08 1.13a10.6 10.6 0 0 1 2.8-.38c.95 0 1.91.13 2.8.38 2.14-1.43 3.08-1.13 3.08-1.13.61 1.53.22 2.66.11 2.94.71.77 1.14 1.75 1.14 2.95 0 4.22-2.57 5.15-5.01 5.42.39.34.73 1.01.73 2.03 0 1.46-.01 2.63-.01 2.99 0 .29.2.64.76.53 4.34-1.45 7.48-5.56 7.48-10.41C23.02 5.24 18.27.5 12 .5z"/></svg>
                        GitHub
                      </a>
                    @endif
                    @if($sp->gitlab)
                      <a href="{{ $sp->gitlab }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-orange-700 bg-white hover:bg-slate-50">
                        GitLab
                      </a>
                    @endif
                    @if($sp->wordpress)
                      <a href="{{ $sp->wordpress }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-indigo-700 bg-white hover:bg-slate-50">
                        WordPress
                      </a>
                    @endif
                    @if($sp->notion)
                      <a href="{{ $sp->notion }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-black bg-white hover:bg-slate-50">
                        Notion
                      </a>
                    @endif
                  </div>
                @else
                  <span class="text-slate-400">No hay redes sociales configuradas</span>
                @endif
              </div>
            </div>
          </div>
        @else
          <!-- EDICIÓN (respetando tus bindings) -->
          <div class="grid lg:grid-cols-2 gap-6">
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 text-sm">
              <p class="text-slate-500 mb-2">Tus datos actuales</p>
              <div class="space-y-1">
                <p><span class="text-slate-500">Nombre:</span> <span class="font-medium text-slate-800">{{ $alumno->name }}</span></p>
                <p><span class="text-slate-500">Email:</span> <span class="font-medium text-slate-800">{{ $alumno->email }}</span></p>
                @if($alumno->whatsapp)<p><span class="text-slate-500">WhatsApp:</span> <span class="font-medium text-slate-800">{{ $alumno->whatsapp }}</span></p>@endif
                @if($alumno->comision)<p><span class="text-slate-500">Comisión:</span> <span class="font-medium text-slate-800">{{ $alumno->comision }}</span></p>@endif
                @if($alumno->carrera)<p><span class="text-slate-500">Carrera:</span> <span class="font-medium text-slate-800">{{ $alumno->carrera }}</span></p>@endif
              </div>
            </div>

            <form wire:submit.prevent="actualizarDatos" class="space-y-4" enctype="multipart/form-data">
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">Nombre completo</label>
                <input type="text" wire:model.defer="nombre" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100">
                @error('nombre') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">Correo electrónico</label>
                <input type="email" wire:model.defer="email" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100">
                @error('email') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
              </div>
              <div class="grid sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-[12px] text-slate-600 mb-1">WhatsApp</label>
                  <input type="text" wire:model.defer="whatsapp" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100">
                </div>
                <div>
                  <label class="block text-[12px] text-slate-600 mb-1">Comisión</label>
                  <input type="text" wire:model.defer="comision" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100">
                </div>
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">Carrera</label>
                <input type="text" wire:model.defer="carrera" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100">
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">Foto de perfil</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                  <input type="file" wire:model="nuevaFoto" accept="image/*"
                         class="block w-full text-sm file:mr-4 file:rounded-xl file:border-0 file:bg-slate-800 file:px-3 file:py-2 file:text-white hover:file:bg-slate-700">
                  <button type="button" wire:click="actualizarFoto"
                          class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-100">
                    Actualizar foto
                  </button>
                </div>
                @error('nuevaFoto') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
                @if($nuevaFoto)
                  <img src="{{ $nuevaFoto->temporaryUrl() }}" class="h-14 w-14 rounded-full object-cover mt-3 ring-2 ring-blue-100" alt="Preview">
                @endif
              </div>

              <div>
                <label class="block text-[12px] text-slate-600 mb-1">LinkedIn</label>
                <input type="url" wire:model.defer="linkedin" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100" placeholder="https://linkedin.com/in/usuario">
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">GitHub</label>
                <input type="url" wire:model.defer="github" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100" placeholder="https://github.com/usuario">
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">GitLab</label>
                <input type="url" wire:model.defer="gitlab" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100" placeholder="https://gitlab.com/usuario">
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">WordPress</label>
                <input type="url" wire:model.defer="wordpress" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100" placeholder="https://usuario.wordpress.com">
              </div>
              <div>
                <label class="block text-[12px] text-slate-600 mb-1">Notion</label>
                <input type="url" wire:model.defer="notion" class="w-full rounded-xl border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-blue-100" placeholder="https://notion.so/usuario">
              </div>

              <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-blue-700">
                  Guardar cambios
                </button>
                <button type="button" wire:click="cancelarEdicion" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                  Cancelar
                </button>
              </div>
            </form>
          </div>
        @endif
      </div>
    </section>

    <!-- PERFIL DEL PROFESOR -->
<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
  <div class="px-4 sm:px-5 py-3 border-b border-slate-100">
    <h2 class="text-slate-800 font-semibold">Perfil del Profesor</h2>
  </div>

  @if(isset($profesores) && $profesores->count() === 0)
    <div class="p-6 text-slate-600">No se encontraron profesores con ese criterio.</div>
  @else
    <div class="p-4 sm:p-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($profesores as $prof)
        <article class="p-4 rounded-2xl border border-slate-200 bg-white hover:shadow-sm transition">
          <div class="flex items-center gap-3">
            @if($prof->profile_photo)
              <img src="{{ asset('storage/'.$prof->profile_photo) }}"
                   class="h-12 w-12 rounded-full object-cover ring-2 ring-slate-100" alt="Foto">
            @else
              <div class="h-12 w-12 rounded-full bg-slate-200 ring-2 ring-slate-100 flex items-center justify-center text-slate-600 font-semibold">
                {{ strtoupper(substr($prof->name,0,1)) }}
              </div>
            @endif
            <div class="leading-tight">
              <h3 class="text-slate-800 font-medium">Prof. {{ $prof->name }}</h3>
              <p class="text-[11px] text-slate-500 -mt-0.5">Profesor</p>
              <a class="text-xs text-blue-600 underline" href="mailto:{{ $prof->email }}">{{ $prof->email }}</a>
              @if($prof->comision)
                <div class="text-xs text-slate-500">Comisión: {{ $prof->comision }}</div>
              @endif
              @if($prof->carrera)
                <div class="text-xs text-slate-500">Carrera: {{ $prof->carrera }}</div>
              @endif
            </div>
          </div>

          <div class="mt-3 text-sm text-slate-700 space-y-1">
            @if($prof->whatsapp)
              @php $numero = preg_replace('/\D/', '', $prof->whatsapp); @endphp
              <p class="inline-flex items-center gap-1">
                <span class="text-slate-500 font-medium">WhatsApp:</span>
                <a href="https://wa.me/{{ $numero }}" target="_blank" class="text-emerald-700 underline">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#25D366" class="inline-block" viewBox="0 0 24 24">
                    <path d="M12.004 2.002c-5.523 0-10 4.477-10 10 0 1.768.463 3.484 1.343 5.002l-1.406 5.001 5.001-1.406c1.518.88 3.234 1.343 5.002 1.343 5.523 0 10-4.477 10-10s-4.477-10-10-10zm0 18c-1.563 0-3.09-.406-4.418-1.176l-.316-.183-2.967.834.834-2.967-.183-.316c-.77-1.328-1.176-2.855-1.176-4.418 0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8zm4.285-6.348c-.236-.118-1.396-.688-1.611-.767-.215-.079-.371-.118-.528.118-.157.236-.607.767-.744.924-.137.157-.274.177-.51.059-.236-.118-.996-.367-1.897-1.171-.701-.624-1.175-1.396-1.313-1.632-.137-.236-.015-.363.103-.481.106-.106.236-.274.354-.411.118-.137.157-.236.236-.393.079-.157.039-.295-.02-.413-.059-.118-.528-1.276-.724-1.748-.191-.459-.385-.397-.528-.405-.137-.007-.295-.009-.452-.009s-.413.059-.629.295c-.216.236-.827.809-.827 1.973s.847 2.285.965 2.447c.118.157 1.667 2.548 4.043 3.469.566.195 1.007.312 1.352.399.567.144 1.083.124 1.491.075.455-.054 1.396-.571 1.594-1.123.197-.552.197-1.025.138-1.123-.059-.098-.215-.157-.451-.275z"/>
                  </svg>
                </a>
              </p>
            @endif
          </div>

          @php $sp = $prof->socialProfiles->first(); @endphp
          @if($sp && ($sp->linkedin || $sp->github))
            <div class="mt-3 pt-3 border-t border-slate-100">
              <p class="text-sm font-medium text-slate-800 mb-2">Redes sociales:</p>
              <div class="flex flex-wrap gap-2">
                @if($sp->linkedin)
                  <a href="{{ $sp->linkedin }}" target="_blank"
                     class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-slate-700 bg-white hover:bg-slate-50">
                    <span class="i">in</span> LinkedIn
                  </a>
                @endif
                @if($sp->github)
                  <a href="{{ $sp->github }}" target="_blank"
                     class="inline-flex items-center gap-1.5 rounded-xl border px-3 py-1.5 text-xs border-slate-200 text-slate-700 bg-white hover:bg-slate-50">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .5C5.73.5.98 5.24.98 11.5c0 4.85 3.14 8.96 7.49 10.41.55.11.75-.24.75-.53 0-.26-.01-1.12-.02-2.03-3.05.66-3.7-1.3-3.7-1.3-.5-1.27-1.23-1.6-1.23-1.6-.99-.68.08-.67.08-.67 1.1.08 1.68 1.14 1.68 1.14.97 1.67 2.55 1.19 3.18.91.1-.7.38-1.19.68-1.46-2.44-.28-5-1.22-5-5.43 0-1.2.43-2.18 1.14-2.95-.11-.28-.5-1.41.11-2.94 0 0 .94-.3 3.08 1.13a10.6 10.6 0 0 1 2.8-.38c.95 0 1.91.13 2.8.38 2.14-1.43 3.08-1.13 3.08-1.13.61 1.53.22 2.66.11 2.94.71.77 1.14 1.75 1.14 2.95 0 4.22-2.57 5.15-5.01 5.42.39.34.73 1.01.73 2.03 0 1.46-.01 2.63-.01 2.99 0 .29.2.64.76.53 4.34-1.45 7.48-5.56 7.48-10.41C23.02 5.24 18.27.5 12 .5z"/></svg>
                    GitHub
                  </a>
                @endif
              </div>
            </div>
          @endif
        </article>
      @endforeach
    </div>

    <div class="px-4 sm:px-6 pb-5">
      {{ $profesores->withQueryString()->links() }}
    </div>
  @endif
</section>
