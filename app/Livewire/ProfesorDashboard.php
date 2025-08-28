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



    public function render()
    {
        return view('livewire.profesor.dashboard', [
            'alumnos' => $this->alumnos,
        ]);
    }
}


