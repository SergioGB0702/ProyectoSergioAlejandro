<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correccionaplicada extends Model
{
    public $timestamps = false;

    protected $fillable = ['descripcion'];
    protected $table = 'correccionaplicadas';
    use HasFactory;

    protected $fillable = [
        'descripcion',
    ];

}
