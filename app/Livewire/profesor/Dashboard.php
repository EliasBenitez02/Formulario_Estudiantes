<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Dashboard extends Component
{
    use WithPagination;

    public $q = '';
    public $alumnoSeleccionado = null;

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