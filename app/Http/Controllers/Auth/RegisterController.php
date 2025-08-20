<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\SocialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'whatsapp' => 'required|string',
            'comision' => 'required|string',
            'dni' => 'required|string|unique:users',
            'carrera' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'role_id' => 'required|exists:roles,id',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Validación para que solo exista un profesor
if ($request->role_id == Role::where('name', 'Profesor')->first()->id) {
    if (User::where('role_id', $request->role_id)->exists()) {
        return back()->with('alert', 'Ya existe un usuario con rol Profesor.');
    }
}


        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile_photo' => $photoPath,
                'whatsapp' => $request->whatsapp,
                'comision' => $request->comision,
                'dni' => $request->dni,
                'carrera' => $request->carrera,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'role_id' => $request->role_id,
            ]);

            SocialProfile::create([
                'user_id' => $user->id,
                'linkedin' => $request->linkedin ?? null,
                'github' => $request->github ?? null,
                'gitlab' => $request->gitlab ?? null,
                'wordpress' => $request->wordpress ?? null,
                'notion' => $request->notion ?? null,
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Registro exitoso.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error en el registro.'])->withInput();
        }
    }
}
