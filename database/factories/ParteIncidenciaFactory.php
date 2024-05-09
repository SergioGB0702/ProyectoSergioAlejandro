<?php

namespace Database\Factories;

use App\Models\Incidencia;
use App\Models\Parte;
use App\Models\ParteIncidencia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ParteIncidenciaFactory extends Factory
{
    protected $model = ParteIncidencia::class;

    public function definition(): array
    {

        do {
            $parte_id = Parte::inRandomOrder()->first()->id;
            $incidencia_id = Incidencia::inRandomOrder()->first()->id;
        } while ((ParteIncidencia::where('parte_id', $parte_id)->where('incidencia_id', $incidencia_id)->exists()));

        return [
            'parte_id' => $parte_id,
            'incidencia_id' => $incidencia_id,
        ];
    }
}
