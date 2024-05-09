<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parte extends Model
{
    protected $table = 'partes';
    use HasFactory;

    protected $fillable = ['alumno_dni', 'profesor_dni', 'colectivo', 'descripcion_detallada', 'tramo_horario_id'];

    public function incidencias(): BelongsToMany
    {
        return $this->belongsToMany(Incidencia::class, 'parte_incidencias', 'parte_id', 'incidencia_id');
    }
}
