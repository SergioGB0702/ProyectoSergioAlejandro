<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Unidad;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    public function definition(): array
    {
        return [
            'id_unidad' => Unidad::InRandomOrder()->first()->id,
            'dni' => strtoupper($this->faker->unique()->bothify('########?')),
            'nombre' => $this->faker->name(),
            'puntos' => $this->faker->numberBetween(0, 12),
        ];
    }
}
