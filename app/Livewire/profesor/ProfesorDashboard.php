<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;

class ProfesorDashboard extends Component
{
    use WithPagination;

    public $q = '';
    public $alumnoSeleccionado = null;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $alumnos = User::where('role_id', 2)
            ->where(function($query){
                $query->where('name', 'like', "%{$this->q}%")
                      ->orWhere('email', 'like', "%{$this->q}%");
            })
            ->paginate(6);

      // $profesor = User::where('role_id', 1)->first();

   return view('livewire.profesor.profesor-dashboard', [
    'alumnos' => $alumnos,
    'profesor' => auth()->user(),
]);

    }

    public function verAlumno($id)
    {
        $this->alumnoSeleccionado = User::find($id);
    }

    public function cerrarModal()
    {
        $this->alumnoSeleccionado = null;
    }

    public function eliminarAlumno($id)
    {
        $alumno = User::find($id);
        if($alumno){
            $alumno->delete();
            $this->cerrarModal();
            session()->flash('mensaje', 'Alumno eliminado correctamente.');
        }
    }
}
