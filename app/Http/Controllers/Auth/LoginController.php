<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validamos credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Obtenemos el usuario autenticado
            $user = Auth::user();

            // Redirigir según rol
            if ($user->role_id == 1) { // Profesor
                return redirect()->route('profesor.dashboard');
            } elseif ($user->role_id == 2) { // Alumno
                return redirect()->route('student.student-dashboard');
            }

            // Por si acaso no tiene rol asignado
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
