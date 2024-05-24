<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    public $timestamps = false;
    protected $table = 'unidades';
    use HasFactory;

    public function curso () {
        return $this->belongsTo(Curso::class);
    }

    public function alumnos () {
        return $this->hasMany(Alumno::class);
    }

}
