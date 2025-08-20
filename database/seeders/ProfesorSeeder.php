<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Profesor::firstOrCreate(
            ['email' => 'profesor@sicep.edu'],
            [
                'nombre'   => 'Prof. María González',
                'whatsapp' => '+543705000000',
                'linkedin' => 'https://linkedin.com/in/prof-maria',
                'github'   => 'https://github.com/prof-maria',
            ]
        );
    }
}
