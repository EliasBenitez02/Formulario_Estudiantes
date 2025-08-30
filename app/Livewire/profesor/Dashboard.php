<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination, WithFileUploads;

    public $q = '';
    public ?User $alumnoSeleccionado = null;

    public $mostrarEditarPerfil = false;
    public $mostrarAcercaDe = false;

    public $profesorEdit = [];
    public $fotoPerfilGrande = null;
    public $fotoPerfilProfesor;
    public ?int $confirmarEliminarId = null;

    protected $paginationTheme = 'tailwind';

    public function updatedQ(): void
    {
        $this->resetPage();
    }

    /** Enter en el buscador => seleccionar primer match y bajar al detalle */
    public function buscarAhora(): void
    {
        if (strlen($this->q) < 4) return;

        $first = User::where('role_id', 2)
            ->where(function ($qq) {
                $qq->where('name', 'like', "%{$this->q}%")
                   ->orWhere('email', 'like', "%{$this->q}%");
            })
            ->orderBy('name')
            ->first();

        if ($first) {
            $this->alumnoSeleccionado = $first;
            // el scroll lo hace el anchor del botón "Ver" en Blade, sin JS
        }
    }

    public function verAlumno($id): void
    {
        $this->alumnoSeleccionado = User::find($id);
    }

    public function toggleVerAlumno($id): void
    {
        if ($this->alumnoSeleccionado && $this->alumnoSeleccionado->id === $id) {
            $this->alumnoSeleccionado = null;
        } else {
            $this->alumnoSeleccionado = User::find($id);
        }
    }

    public function confirmarEliminar(int $id): void
    {
        $this->confirmarEliminarId = $id;
    }

    public function cancelarEliminar(): void
    {
        $this->confirmarEliminarId = null;
    }

    public function eliminarAlumno($id): void
    {
        User::find($id)?->delete();

        $this->confirmarEliminarId = null;   // cierra modal
        $this->alumnoSeleccionado  = null;   // limpia card detalle
        session()->flash('mensaje', 'Alumno eliminado correctamente.');
        $this->resetPage();                  // evita página vacía al paginar
    }

    /** Dispara modal de edición con datos del profe */
    public function editarPerfil(): void
    {
        $u = Auth::user();
        $this->profesorEdit = [
            'name'             => $u->name,
            'email'            => $u->email,
            'dni'              => $u->dni ?? '',
            'whatsapp'         => $u->whatsapp ?? '',
            'fecha_nacimiento' => $u->fecha_nacimiento ?? '',
            'comision'         => $u->comision ?? '',
            'carrera'          => $u->carrera ?? '',
        ];
        $this->mostrarEditarPerfil = true;
    }

    /** Guarda perfil del profe (guarda ruta relativa en storage/public) */
    public function guardarPerfil(): void
    {
        $user = Auth::user();

        $user->name             = $this->profesorEdit['name'] ?? $user->name;
        $user->email            = $this->profesorEdit['email'] ?? $user->email;
        $user->dni              = $this->profesorEdit['dni'] ?? null;
        $user->whatsapp         = $this->profesorEdit['whatsapp'] ?? null;
        $user->fecha_nacimiento = $this->profesorEdit['fecha_nacimiento'] ?? null;
        $user->comision         = $this->profesorEdit['comision'] ?? null;
        $user->carrera          = $this->profesorEdit['carrera'] ?? null;

        if ($this->fotoPerfilProfesor) {
            $this->validate([
                'fotoPerfilProfesor' => 'image|max:2048',
            ]);
            // Guarda solo ruta relativa (ej: profile_photos/xxxx.jpg) en disco 'public'
            $path = $this->fotoPerfilProfesor->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        $this->mostrarEditarPerfil = false;
        $this->fotoPerfilProfesor  = null;

        session()->flash('mensaje', 'Perfil actualizado correctamente.');
    }

    public function verFotoPerfil($url): void
    {
        $this->fotoPerfilGrande = $url;
    }

    public function cerrarFotoPerfil(): void
    {
        $this->fotoPerfilGrande = null;
    }

    public function acercaDe(): void
    {
        $this->mostrarAcercaDe = true;
    }

    public function cerrarModales(): void
    {
        $this->mostrarEditarPerfil = false;
        $this->mostrarAcercaDe     = false;
    }

    /** Borra el flash verde usando solo Livewire (wire:poll en Blade) */
    public function clearFlash(): void
    {
        if (session()->has('mensaje')) {
            session()->forget('mensaje');
        }
    }

    public function render()
    {
        if (!Auth::check() || Auth::user()->role_id != 1) {
            abort(403, 'No tienes permiso para acceder a este módulo.');
        }

        if (!$this->alumnoSeleccionado && request()->has('ver')) {
            $this->alumnoSeleccionado = User::find((int) request('ver'));
        }

        $alumnos = User::where('role_id', 2)
            ->where(function ($query) {
                $q = $this->q;
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->paginate(5);

        $sugerencias = collect();
        if (strlen($this->q) >= 4) {
            $sugerencias = User::where('role_id', 2)
                ->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->q}%")
                       ->orWhere('email', 'like', "%{$this->q}%");
                })
                ->limit(8)
                ->get();
        }

        return view('livewire.profesor.dashboard', [
            'alumnos'     => $alumnos,
            'sugerencias' => $sugerencias,
        ])->layout('layouts.content');
    }
}
