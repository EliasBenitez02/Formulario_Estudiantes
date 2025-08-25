<?php

namespace App\Livewire\Profesor;

use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

class Dashboard extends Component
{
    use WithPagination;

    public $q = '';
    public $alumnoSeleccionado = null;
    public $mostrarEditarPerfil = false;
    public $mostrarAcercaDe = false;
    public $profesorEdit = [];
    public $fotoPerfilProfesor;

    protected $paginationTheme = 'tailwind';

    public function updatedQ()
    {
        $this->resetPage();
    }

    public function verAlumno($id)
    {
        $this->alumnoSeleccionado = User::find($id);
    }

    public function eliminarAlumno($id)
    {
        User::find($id)?->delete();
        $this->alumnoSeleccionado = null;
        session()->flash('mensaje', 'Alumno eliminado correctamente.');
    }

    // Mostrar formulario de edición
    public function editarPerfil()
    {
        $this->profesorEdit = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'dni' => auth()->user()->dni ?? '',
            'whatsapp' => auth()->user()->whatsapp ?? '',
            'fecha_nacimiento' => auth()->user()->fecha_nacimiento ?? '',
            'comision' => auth()->user()->comision ?? '',
            'carrera' => auth()->user()->carrera ?? '',
        ];
        $this->mostrarEditarPerfil = true;
    }

    // Guardar cambios del perfil
    public function guardarPerfil()
    {
        $user = auth()->user();
        $user->name = $this->profesorEdit['name'];
        $user->email = $this->profesorEdit['email'];
        $user->dni = $this->profesorEdit['dni'];
        $user->whatsapp = $this->profesorEdit['whatsapp'];
        $user->fecha_nacimiento = $this->profesorEdit['fecha_nacimiento'];
        $user->comision = $this->profesorEdit['comision'];
        $user->carrera = $this->profesorEdit['carrera'];
        if ($this->fotoPerfilProfesor) {
            $path = $this->fotoPerfilProfesor->store('perfiles', 'public');
            $user->foto_perfil = '/storage/' . $path;
        }
        $user->save();
        $this->mostrarEditarPerfil = false;
        session()->flash('mensaje', 'Perfil actualizado correctamente.');
    }

    // Mostrar modal/card de Acerca de
    public function acercaDe()
    {
        $this->mostrarAcercaDe = true;
    }

    // Cerrar modales
    public function cerrarModales()
    {
        $this->mostrarEditarPerfil = false;
        $this->mostrarAcercaDe = false;
    }

    public function render()
    {
        $alumnos = User::where('role_id', 2)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->q}%")
                    ->orWhere('email', 'like', "%{$this->q}%");
            })
            ->paginate(5);

        $sugerencias = [];
        if (strlen($this->q) >= 4) {
            $sugerencias = User::where('role_id', 2)
                ->where('name', 'like', "%{$this->q}%")
                ->limit(5)
                ->get();
        }

        return view('livewire.profesor.dashboard', [
            'alumnos' => $alumnos,
            'sugerencias' => $sugerencias
        ])->layout('layouts.app');
    }
}