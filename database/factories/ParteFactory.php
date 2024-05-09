<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Parte;
use App\Models\Profesor;
use App\Models\Tramohorario;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParteFactory extends Factory
{
    protected $model = Parte::class;

    public function definition(): array
    {
        return [
            'alumno_dni' => Alumno::InRandomOrder()->first()->dni,
            'colectivo' => $this->faker->randomElement(['Si', 'No']),
            'profesor_dni' => Profesor::InRandomOrder()->first()->dni,
            'tramo_horario_id' => Tramohorario::InRandomOrder()->first()->id,
        ];
    }
}