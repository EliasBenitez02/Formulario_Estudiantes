<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Dashboard extends Component
{
    use WithPagination, WithFileUploads;

    public $q = '';
    public ?User $alumnoSeleccionado = null;

    public $mostrarEditarPerfil = false;
    public $mostrarAcercaDe = false;

    /* El form de cambiar contraseña */
    public array $passForm = [
        'actual'    => '',
        'nueva'     => '',
        'confirmar' => '',
    ];

    public $profesorEdit = [];
    public $fotoPerfilGrande = null;
    public $fotoPerfilProfesor;
    public ?int $confirmarEliminarId = null;

    /** Flag para ignorar ?ver= cuando el usuario limpia el buscador */
    public bool $forceIgnoreVer = false;

    protected $paginationTheme = 'tailwind';

    public function mount(): void
    {
        $verId = request()->integer('ver');
        if ($verId) $this->seleccionarAlumno($verId);
    }

    public function updatedQ(): void
    {
        $this->resetPage();

        if (strlen($this->q) === 0) {
            $this->forceIgnoreVer = true;
            $this->alumnoSeleccionado = null;
        } else {
            $this->forceIgnoreVer = false;
        }
    }

    /** Enter en el buscador */
    public function buscarAhora(): void
    {
        if (strlen($this->q) < 4) return;
        $this->resetPage();
        $this->alumnoSeleccionado = null;
    }

    public function seleccionarAlumno($id): void
    {
        $this->alumnoSeleccionado = User::with('socialProfile')->find($id);
        $this->forceIgnoreVer = false;
    }

    public function ocultarDetalle(): void
    {
        $this->alumnoSeleccionado = null;
        $this->forceIgnoreVer = true;
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
        // Solo permite imágenes hasta 2MB
        $this->validate([
            'fotoPerfilProfesor' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'fotoPerfilProfesor.required' => 'Seleccioná una imagen.',
            'fotoPerfilProfesor.image'    => 'El archivo debe ser una imagen.',
            'fotoPerfilProfesor.mimes'    => 'Formatos permitidos: JPG, JPEG, PNG, WEBP.',
            'fotoPerfilProfesor.max'      => 'La imagen no puede superar los 2 MB.',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        // Guardar en storage/app/public/profile_photos
        $path = $this->fotoPerfilProfesor->store('profile_photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        // Cerrar modal y limpiar input
        $this->mostrarEditarPerfil = false;
        $this->fotoPerfilProfesor  = null;

        session()->flash('mensaje', 'Foto de perfil actualizada correctamente.');
    }


    public function actualizarPassword(): void
    {
        $this->validate(
            [
                'passForm.actual'    => ['required', 'current_password'],
                'passForm.nueva'     => [
                    'required',
                    'string',
                    Password::min(8)->letters()->mixedCase()->numbers(),
                ],
                'passForm.confirmar' => ['required', 'same:passForm.nueva'],
            ],
            [
                'passForm.actual.required'    => 'Ingresá tu contraseña actual.',
                'passForm.actual.current_password' => 'La contraseña actual no es correcta.',
                'passForm.nueva.required'     => 'Ingresá la nueva contraseña.',
                'passForm.nueva.min'          => 'La nueva contraseña debe tener al menos :min caracteres.',
                'passForm.confirmar.same'     => 'La confirmación no coincide.',
            ]
        );

        $user = Auth::user();
        $user->password = Hash::make($this->passForm['nueva']);
        $user->save();

        $this->mostrarCambiarPass = false;
        $this->passForm = ['actual' => '', 'nueva' => '', 'confirmar' => ''];

        session()->flash('mensaje', 'Contraseña actualizada correctamente.');
    }

    protected function authenticated($request, $user)
    {
        if ($user->role_id == 1) {
            return redirect()->route('profesor.dashboard');
        }
        return redirect()->route('student.student-dashboard');
    }

    /** ========= utilidades UI ========= */

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
