<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parte extends Model
{
    protected $table = 'partes';
    use HasFactory;

    protected $fillable = ['alumno_dni', 'profesor_dni', 'colectivo', 'descripcion_detallada', 'tramo_horario_id','puntos_penalizados', 'created_at'];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_partes', 'parte_id', 'alumno_dni');
    }

    public function incidencias(): BelongsToMany
    {
        return $this->belongsToMany(Incidencia::class,
        'parte_incidencias', 'parte_id', 'incidencia_id');
    }

    public function profesors () {
        return $this->belongsTo(Profesor::class, 'profesor_dni', 'dni');
    }


    public function tramoHorario()
    {
        return $this->belongsTo(TramoHorario::class);
    }
    public function correccionesaplicadas()
    {
        return $this->belongsToMany(Correccionaplicada::class,
         'parte_correccionaplicadas', 'parte_id', 'correccionaplicadas_id');
    }

    public function conductanegativas()
    {
        return $this->belongsToMany(Conductanegativa::class,
         'parte_conductanegativas', 'parte_id', 'conductanegativas_id');
    }

}
