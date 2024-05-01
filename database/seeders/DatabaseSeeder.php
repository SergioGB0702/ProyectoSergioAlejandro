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

        $incidentes = [
            ["descripcion" => "Jugar en clase"],
            ["descripcion" => "Pelea con un compañero"],
            ["descripcion" => "Malos modos"],
            ["descripcion" => "Jugar en clase"],
            ["descripcion" => "Uso del móvil sin permiso"],
            ["descripcion" => "Uso indebido del PC"],
        ];

        foreach ($incidentes as $incidente) \App\Models\Incidencia::create($incidente);

        $conductasNegativas = [
            ["descripcion" => "Perturbación del normal desarrollo de las actividades de la clase", "tipo" => "Contraria"],
            ["descripcion" => "Agresión física a un miembro de la comunidad educativa.", "tipo" => "Grave"],
            ["descripcion" => "Falta de colaboración sistemática en la realización de las actividades.", "tipo" => "Contraria"],
            ["descripcion" => "Impedir o dificultar el estudio a sus compañeros.", "tipo" => "Contraria"],
            ["descripcion" => "Actuaciones incorrectas hacia algún miembro de la comunidad educativa.", "tipo" => "Contraria"],
            ["descripcion" => "Reiteración en un mismo curso de conductas contrarias a las normas de convivencia.", "tipo" => "Grave"],
        ];
        foreach ($conductasNegativas as $conductaNegativa) \App\Models\Conductanegativa::create($conductaNegativa);

        $correcionesAplicadas = [
            ["descripcion" => "Suspender el derecho de asistencia al centro entre 1 y 3 días."],
            ["descripcion" => "Suspender el derecho de asistencia al centro entre 4 y 30 días."],
            ["descripcion" => "Realizar tareas fuera del horario lectivo del Centro."],
        ];
        foreach ($correcionesAplicadas as $correcionAplicada) \App\Models\Correccionaplicada::create($correcionAplicada);


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
