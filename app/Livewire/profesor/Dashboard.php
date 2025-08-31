<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\SocialProfile;
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

    /** Flag para ignorar ?ver= cuando el usuario limpia el buscador */
    public bool $forceIgnoreVer = false;

    protected $paginationTheme = 'tailwind';

    public function updatedQ(): void
    {
        $this->resetPage();

        if (strlen($this->q) === 0) {
            // Si el usuario borró la búsqueda: ocultamos el detalle y
            // NO re-leemos ?ver= aunque siga en la URL.
            $this->forceIgnoreVer = true;
            $this->alumnoSeleccionado = null;
        } else {
            $this->forceIgnoreVer = false;
        }
    }


    public function buscarAhora()
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
            // Evita el GET a /livewire/update: navegación controlada por Livewire
            return $this->redirect(url()->current() . '?ver=' . $first->id . '#detalle-alumno', navigate: true);
        }
    }




    public function seleccionarAlumno($id): void
    {
        $this->forceIgnoreVer = false;
        $this->alumnoSeleccionado = User::find($id);
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

        $this->confirmarEliminarId = null;
        $this->alumnoSeleccionado  = null;
        session()->flash('mensaje', 'Alumno eliminado correctamente.');
        $this->resetPage();
    }

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
            // guarda ruta relativa (profile_photos/xxx.jpg) en disco 'public'
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

    public function ocultar(): void
    {
        $this->forceIgnoreVer = true;
        $this->alumnoSeleccionado = null;
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

        // Selección desde ?ver= (salvo que estemos ignorándolo por limpieza de búsqueda)
        $verId = request()->integer('ver');
        if (!$this->forceIgnoreVer && $verId) {
            $this->alumnoSeleccionado = User::find($verId);
        }

        $alumnos = User::with('socialProfile')
            ->where('role_id', 2)
            ->where(function ($query) {
                $q = $this->q;
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->paginate(5);

        $sugerencias = collect();
        if (strlen($this->q) >= 4) {
            $sugerencias = User::with('socialProfile')
                ->where('role_id', 2)
                ->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->q}%")
                        ->orWhere('email', 'like', "%{$this->q}%");
                })
                ->orderBy('name')
                ->limit(8)
                ->get();
        }

        return view('livewire.profesor.dashboard', [
            'alumnos'     => $alumnos,
            'sugerencias' => $sugerencias,
        ])->layout('layouts.content');
    }
}
