<?php

namespace Database\Factories;

use App\Models\Profesor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesorFactory extends Factory
{
    protected $model = Profesor::class;

    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->bothify('########?'),
            'nombre' => $this->faker->name(),
            'telefono' => $this->faker->numerify('###-##-##-##'),
            'correo' => $this->faker->email(),
        ];
    }
}
