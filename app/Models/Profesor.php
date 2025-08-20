<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profesor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'whatsapp', 'linkedin', 'github'];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}
