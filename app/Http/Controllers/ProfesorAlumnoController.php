<?php

namespace App\Http\Controllers;

use App\DataTables\AlumnoDataTable;
use App\Models\Alumno;
use App\Models\AnioAcademico;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorAlumnoController extends Controller
{
    public function index(AlumnoDataTable $dataTable) {
        $anoAcademico = AnioAcademico::all();
        $profesores = Profesor::select("*");
        $tandaProfesores = $profesores->paginate(5);
        return $dataTable->render('gestion.profesoralumno', ['anoAcademico' => $anoAcademico, "profesores" => $tandaProfesores]);
    }

    public function reinciarPuntos() {
        // Update general mediante Eloquent para todos los puntos
        Alumno::query()->update([
            'puntos' => 12,
        ]);
        return back()->with('success', 'Los puntos de todos los alumnos se han restaurado a 12');
    }

}
