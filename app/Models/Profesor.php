<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    public $timestamps = false;
    protected $table = 'profesors';
    use HasFactory;

    protected $fillable = ['dni', 'nombre'];

    public function parte () {
        return $this->hasMany(Parte::class);
    }

}
