<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tramosHorarios = [
            ["nombre" => "En clase"],
            ["nombre" => "En el intercambio de clases"],
            ["nombre" => "Entrada/Salida"],
            ["nombre" => "Recreo"],
            ["nombre" => "Fuera del centro"],
            ["nombre" => "En el comedor"],
            ["nombre" => "En el aula matinal"],
            ["nombre" => "Durante las actividades extraescolares"],
            ["nombre" => "Otros"],
        ];

        foreach ($tramosHorarios as $tramoHorario) \App\Models\Tramohorario::create($tramoHorario);

         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'alejandro',
             'email' => 'alejandro@hotmail.com',
         ]);
    }
}
