<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::factory()->create([
            'name' => 'jefatura',
            'email' => 'jefatura',
            'password' => Hash::make('je21700010'),
        ]);

        User::factory()->create([
            'name' => 'profesor',
            'email' => 'profesor',
            'password' => Hash::make('21700010'),
        ]);

        Alumno::factory(20)->create();
        Profesor::factory(20)->create();
    }
}
