<?php

namespace App\Http\Controllers;

use App\DataTables\AlumnoDataTable;
use App\Models\Alumno;
use App\Models\AnioAcademico;
use App\Models\Correo;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorAlumnoController extends Controller
{
    public function index(AlumnoDataTable $dataTable, Request $request) {
        $anoAcademico = AnioAcademico::all();
        $profesores = Profesor::select("*")->where('habilitado','=',true);
        $tandaProfesores = $profesores->paginate(5);
        $paginaActual = $request->page;
        if ($paginaActual != null) {
            return $dataTable->render('gestion.profesoralumno', ['anoAcademico' => $anoAcademico, "profesores" => $tandaProfesores, "paginaProfesor" => $paginaActual]);
        } else return $dataTable->render('gestion.profesoralumno', ['anoAcademico' => $anoAcademico, "profesores" => $tandaProfesores]);
    }

    public function reinciarPuntos() {
        // Update general mediante Eloquent para todos los puntos
        Alumno::query()->update([
            'puntos' => 12,
        ]);
        return back()->with('success', 'Los puntos de todos los alumnos se han restaurado a 12');
    }

    public function obtenerCorreos(Request $request) {
        $dniAlumno = $request->dni;
        $listaCorreos = Correo::select("correo","tipo")->where("alumno_dni","=",$dniAlumno)->get();
        return $listaCorreos;
    }

    public function habilitar(Request $request) {
        $dniProfesor = $request->dni;
        $profesor = Profesor::select('*')->where('dni','=',$dniProfesor)->get()[0];
        Profesor::where('dni','=',$dniProfesor)->update(['habilitado' =>  !($profesor->habilitado)]);
        return back()->with('success', 'Profesor deshabilitado');
    }

}
