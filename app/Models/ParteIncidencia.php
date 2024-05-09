<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParteIncidencia extends Model
{
    public $timestamps = false;
    protected $table = 'parte_incidencias';
    use HasFactory;

    protected $fillable = ['parte_id', 'incidencia_id'];
}
