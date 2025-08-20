<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_completo',
        'email',
        'whatsapp',
        'dni',
        'fecha_nacimiento',
        'comision',
        'carrera',
        'linkedin',
        'github',
        'foto_url',
        'profesor_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
