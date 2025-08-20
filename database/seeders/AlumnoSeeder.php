<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first(); // usa el primer usuario existente
        $profe = \App\Models\Profesor::first();

        if (!$user || !$profe) return;

        \App\Models\Alumno::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nombre_completo'   => $user->name ?? 'Estudiante',
                'email'             => $user->email,
                'whatsapp'          => '3704898850',
                'dni'               => '12345678',
                'fecha_nacimiento'  => '2000-10-09',
                'comision'          => '2',
                'carrera'           => 'TUP',
                'linkedin'          => 'https://linkedin.com/in/estefi',
                'github'            => 'https://github.com/Estefimb/mapagti1',
                'foto_url'          => null, // o poné una URL directa
                'profesor_id'       => $profe->id,
            ]
        );
    }
}
