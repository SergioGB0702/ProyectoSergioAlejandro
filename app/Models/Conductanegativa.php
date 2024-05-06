<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductanegativa extends Model
{
    public $timestamps = false;
    protected $table = 'conductanegativas';
    protected $fillable = ['descripcion', 'tipo'];
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'tipo',
    ];

}
