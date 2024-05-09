<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    public $timestamps = false;
    protected $table = 'incidencias';

    protected $fillable = ['descripcion'];
    use HasFactory;


}
