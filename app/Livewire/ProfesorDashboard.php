<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

#[Layout('layouts.app')]
class ProfesorDashboard extends Component
{
    public User $profesor;
    public $alumnos = [];
    public $search = '';
    public $alumnoSeleccionado = null;

    public function mount()
    {
        // Profesor logueado
        $this->profesor = auth()->user();

        // Cargar alumnos
        $this->cargarAlumnos();
    }

    private function cargarAlumnos()
    {
        $this->alumnos = User::with('socialProfile')
            ->where('role_id', 2)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('whatsapp', 'like', "%{$this->search}%")
                      ->orWhere('comision', 'like', "%{$this->search}%")
                      ->orWhere('dni', 'like', "%{$this->search}%")
                      ->orWhere('carrera', 'like', "%{$this->search}%");
            })
            ->get();
    }

    public function verAlumno($id)
    {
        // Traemos el alumno con su perfil social
        $this->alumnoSeleccionado = User::with('socialProfile')->findOrFail($id);
    }

    public function eliminarAlumno($id)
    {
        $alumno = User::find($id);

        if ($alumno) {
            $alumno->delete();
            session()->flash('mensaje', 'Alumno eliminado correctamente.');
            $this->cargarAlumnos(); // refresca lista sin recargar página
        }
    }

    public function cerrarModal()
    {
        $this->alumnoSeleccionado = null;
    }

    public function updatingSearch()
    {
        $this->cargarAlumnos();
    }

    public function render()
    {
        return view('livewire.profesor.dashboard', [
            'alumnos' => $this->alumnos,
        ]);
    }
}


