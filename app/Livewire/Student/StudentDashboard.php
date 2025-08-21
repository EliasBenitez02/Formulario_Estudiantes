<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rule;

class ProfesorDashboard extends Component
{
    use WithPagination;

    // props del perfil
    public User $profesor;
    public bool $editando = false;
    public string $nombre = '';
    public string $email = '';
    public ?string $whatsapp = null;
    public ?string $comision = null;
    public ?string $carrera = null;

    // props de la grilla de alumnos
    public string $q = '';
    public int $perPage = 8;

    // Para manejo de sesión o flashes
    protected $queryString = ['q'];

    public function mount()
    {
        $this->profesor = auth()->user();

        // Llenamos las propiedades desde el modelo
        $this->fill([
            'nombre' => $this->profesor->name ?? '',
            'email' => $this->profesor->email ?? '',
            'whatsapp' => $this->profesor->whatsapp,
            'comision' => $this->profesor->comision,
            'carrera' => $this->profesor->carrera,
        ]);
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function habilitarEdicion()
    {
        $this->editando = true;
    }

    public function cancelarEdicion()
    {
        $this->mount();
        $this->editando = false;
    }

    public function actualizarDatos()
    {
        $this->validate([
            'nombre' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($this->profesor->id)],
            'whatsapp' => ['nullable','string','max:50'],
            'comision' => ['nullable','string','max:50'],
            'carrera' => ['nullable','string','max:100'],
        ]);

        // Guardamos en BD
        $this->profesor->update([
            'name' => $this->nombre,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'comision' => $this->comision,
            'carrera' => $this->carrera,
        ]);

        $this->profesor->refresh();

        $this->fill([
            'nombre' => $this->profesor->name,
            'email' => $this->profesor->email,
            'whatsapp' => $this->profesor->whatsapp,
            'comision' => $this->profesor->comision,
            'carrera' => $this->profesor->carrera,
        ]);

        $this->editando = false;
        session()->flash('mensaje', 'Datos actualizados correctamente.');
    }

    public function render()
    {
        $alumnosRoleId = Role::where('name','alumno')->value('id');

        $alumnos = User::where('role_id', $alumnosRoleId)
            ->when($this->q !== '', function ($q) {
                $q->where(function ($qq) {
                    $qq->where('name','like','%'.$this->q.'%')
                        ->orWhere('email','like','%'.$this->q.'%')
                        ->orWhere('whatsapp','like','%'.$this->q.'%')
                        ->orWhere('comision','like','%'.$this->q.'%');
                });
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.profesor.profesor-dashboard', compact('alumnos'));
    }
}
