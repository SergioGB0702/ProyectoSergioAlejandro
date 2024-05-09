<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'alumnos';

    protected $fillable = [
        'dni', 'nombre', 'puntos', 'id_unidad'
    ];

    public function partes(): HasMany
    {
        return $this->hasMany(Parte::class, 'alumno_dni', 'dni');
    }
}
