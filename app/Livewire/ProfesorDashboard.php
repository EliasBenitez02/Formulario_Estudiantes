<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('layouts.app')]
class ProfesorDashboard extends Component
{
    public User $profesor;
    public $alumnos;
    public $search = '';
    public $alumnoSeleccionado = null;

    public function mount()
    {
        // Profesor logueado
        $this->profesor = auth()->user();

        // Cargar alumnos
        $this->cargarAlumnos();
    }

    public function updatedSearch()
    {
        $this->cargarAlumnos();
    }

    private function cargarAlumnos()
    {
        // Traemos los usuarios con role_id 2 y su perfil social
        $this->alumnos = User::with('socialProfile')
            ->where('role_id', 2)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('whatsapp', 'like', "%{$this->search}%")
                      ->orWhere('comision', 'like', "%{$this->search}%")
                      ->orWhere('dni', 'like', "%{$this->search}%")
                      ->orWhere('carrera', 'like', "%{$this->search}%")
                      ->orWhere('whatsapp', 'like', "%{$this->search}%");
            })
            ->get();
    }

    public function eliminarAlumno($id)
    {
        $alumno = User::find($id);
        if ($alumno) {
            $alumno->delete();
            session()->flash('success', 'Alumno eliminado correctamente.');
        } else {
            session()->flash('error', 'Alumno no encontrado.');
        }

        $this->cargarAlumnos();
    }

    public function verAlumno($id)
    {
        // Traemos el alumno con su perfil social
        $this->alumnoSeleccionado = User::with('socialProfile')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.profesor.dashboard');
    }
}
