<?php
namespace App\Livewire\Admin;
use Livewire\Component;
    use App\Models\User;
    use App\Models\Course;

    class AdminDashboard extends Component
    {
        public $showProfesorModal = false;
        public $showCursoModal = false;
        public $profesor = [
            'name' => '',
            'email' => '',
            'password' => '',
            'course_id' => '',
        ];
        public $curso = [
            'name' => '',
            'description' => '',
        ];

        public function mount()
        {
            // No es necesario aquí, se obtiene en render
        }

        public function showAddProfesorModal()
        {
            $this->showProfesorModal = true;
        }

        public function hideAddProfesorModal()
        {
            $this->showProfesorModal = false;
        }

        public function showAddCursoModal()
        {
            $this->showCursoModal = true;
        }

        public function hideAddCursoModal()
        {
            $this->showCursoModal = false;
        }

        public function agregarProfesor()
        {
            $this->validate([
                'profesor.name' => 'required|string|max:255',
                'profesor.email' => 'required|email|unique:users,email',
                'profesor.password' => 'required|string|min:6',
                'profesor.course_id' => 'required|exists:courses,id',
            ]);
            User::create([
                'name' => $this->profesor['name'],
                'email' => $this->profesor['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($this->profesor['password']),
                'role_id' => 2,
                'course_id' => $this->profesor['course_id'],
            ]);
            $this->profesor = ['name' => '', 'email' => '', 'password' => '', 'course_id' => ''];
            $this->hideAddProfesorModal();
        }

        public function agregarCurso()
        {
            $this->validate([
                'curso.name' => 'required|string|max:255',
                'curso.description' => 'required|string',
            ]);
            Course::create([
                'name' => $this->curso['name'],
                'description' => $this->curso['description'],
            ]);
            $this->curso = ['name' => '', 'description' => ''];
            $this->hideAddCursoModal();
        }

        public function eliminarProfesor($id)
        {
            User::where('id', $id)->where('role_id', 2)->delete();
            session()->flash('mensaje', 'Profesor eliminado correctamente.');
        }

        public function eliminarCurso($id)
        {
            Course::where('id', $id)->delete();
            session()->flash('mensaje', 'Curso eliminado correctamente.');
        }

        public function render()
        {
            $profesores = User::where('role_id', 2)->with('course')->get();
            $cursos = Course::all();
            return view('livewire.admin.dashboard', compact('profesores', 'cursos'));
        }
    }
