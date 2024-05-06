<?php

namespace Database\Factories;

use App\Models\Correccionaplicada;
use App\Models\Parte;
use App\Models\ParteCorreccionsaplicada;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ParteCorreccionsaplicadaFactory extends Factory
{
    protected $model = ParteCorreccionsaplicada::class;

    public function definition(): array
    {

        do {
            $parte_id = Parte::inRandomOrder()->first()->id;
            $correccionaplicadas_id = Correccionaplicada::inRandomOrder()->first()->id;
        } while ((ParteCorreccionsaplicada::where('parte_id', $parte_id)->where('correccionaplicadas_id', $correccionaplicadas_id)->exists()));

        return [
            'parte_id' => $parte_id,
            'correccionaplicadas_id' => $correccionaplicadas_id,
        ];
    }
}
