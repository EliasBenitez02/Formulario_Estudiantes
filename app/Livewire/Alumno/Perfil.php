<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Perfil extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user(); // trae al alumno logueado
    }

    public function render()
    {
        return view('livewire.alumno.perfil', [
            'user' => $this->user
        ]);
    }
}
