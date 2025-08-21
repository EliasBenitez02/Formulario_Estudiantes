<?php
namespace App\Livewire\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\SocialProfile;
use App\Models\Role;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
class StudentDashboard extends Component
{
    use WithPagination, WithFileUploads;

    // props del perfil
    public User $alumno;
    public bool $editando = false;
    public string $nombre = '';
    public string $email = '';
    public ?string $whatsapp = null;
    public ?string $comision = null;
    public ?string $carrera  = null;

    // props de la grilla de profesores
    public string $q = '';
    public int $perPage = 8;

    public $nuevaFoto; // Para el archivo subido

    protected $queryString = ['q'];

    public function mount()
    {
        $this->alumno = auth()->user();

        // Llenamos las propiedades desde el modelo
        $this->fill([
            'nombre'   => $this->alumno->name ?? '',
            'email'    => $this->alumno->email ?? '',
            'whatsapp' => $this->alumno->whatsapp,
            'comision' => $this->alumno->comision,
            'carrera'  => $this->alumno->carrera,
        ]);
    }

    public function updatingQ() { $this->resetPage(); }

    public function habilitarEdicion() { $this->editando = true; }

    public function cancelarEdicion()
    {
        // volvemos a los datos del modelo
        $this->mount();
        $this->editando = false;
    }

    public function actualizarDatos()
    {
        $this->validate([
            'nombre'   => ['required','string','max:255'],
            'email'    => ['required','email','max:255', Rule::unique('users','email')->ignore($this->alumno->id)],
            'whatsapp' => ['nullable','string','max:50'],
            'comision' => ['nullable','string','max:50'],
            'carrera'  => ['nullable','string','max:100'],
        ]);

        // Guardamos en BD
        $this->alumno->update([
            'name'      => $this->nombre,
            'email'     => $this->email,
            'whatsapp'  => $this->whatsapp,
            'comision'  => $this->comision,
            'carrera'   => $this->carrera,
        ]);

        // MUY IMPORTANTE: sincronizar modelo y props para que la UI cambie sin refrescar
        $this->alumno->refresh();

        // Re-llenamos props por si hay casts/mutators/normalizaciones
        $this->fill([
            'nombre'   => $this->alumno->name,
            'email'    => $this->alumno->email,
            'whatsapp' => $this->alumno->whatsapp,
            'comision' => $this->alumno->comision,
            'carrera'  => $this->alumno->carrera,
        ]);

        $this->editando = false;
        session()->flash('mensaje', 'Datos actualizados correctamente.');
    }

    public function actualizarFoto()
    {
        $this->validate([
            'nuevaFoto' => 'nullable|image|max:2048', // 2MB máximo
        ]);

        if ($this->nuevaFoto) {
            $ruta = $this->nuevaFoto->store('profile-photos', 'public');
            $this->alumno->profile_photo = $ruta;
            $this->alumno->save();
            $this->alumno->refresh();
            session()->flash('mensaje', 'Foto de perfil actualizada.');
        }
    }

    public function render()
    {
        $profRoleId = Role::where('name','profesor')->value('id');

        $profesores = User::with('socialProfiles')
            ->where('role_id', $profRoleId)
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

        return view('livewire.student.student-dashboard', compact('profesores'));
    }
}
