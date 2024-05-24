<?php

namespace App\Http\Controllers;

use App\DataTables\AlumnoDataTable;
use App\Models\AnioAcademico;
use Illuminate\Http\Request;

class ProfesorAlumnoController extends Controller
{
    public function index(AlumnoDataTable $dataTable) {
        $anoAcademico = AnioAcademico::all();
        return $dataTable->render('gestion.profesoralumno', ['anoAcademico' => $anoAcademico]);
    }
}
