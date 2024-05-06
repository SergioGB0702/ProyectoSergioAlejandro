<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParteCorreccionsaplicada extends Model
{
    public $timestamps = false;
    protected $table = 'parte_correccionaplicadas';

    protected $fillable = ['parte_id', 'correccionaplicadas_id'];
    use HasFactory;
}
