<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Manejar login
     */
    public function login(Request $request)
    {
        // Validación del form
        $credentials = $request->validate([
<<<<<<< HEAD
            'email' => ['required', 'email'],
            'password' => ['required'],
=======
            'email' => 'required|email',
            'password' => 'required',
>>>>>>> develop
        ]);

        // Intentar loguear primero como admin
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
<<<<<<< HEAD

            $user = Auth::user();
            $alumnoRoleId = Role::where('name', 'alumno')->value('id');
            if ($user->role_id === $alumnoRoleId) {
                return redirect()->route('student.dashboard');
            }
            // Otros roles...
            return redirect()->intended('/');
=======
            return redirect()->intended('/admin/dashboard');
>>>>>>> develop
        }

        // Si no es admin, intentar como user
        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            if ($user->role_id == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role_id == 2) {
                return redirect()->intended('/profesor/dashboard');
            } else {
                return redirect()->intended('/student/dashboard');
            }
        }

        // Si no coincide en ninguna tabla
        return back()->withErrors([
<<<<<<< HEAD
            'email' => 'Las credenciales no son correctas.',
        ]);
=======
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
>>>>>>> develop
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
