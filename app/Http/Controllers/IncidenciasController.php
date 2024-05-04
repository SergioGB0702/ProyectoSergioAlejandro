<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;
use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciasController extends Controller
{
    public function index() {
        $incidencias = Incidencia::select("*");
        $tandaIncidencias = $incidencias->paginate(5);
        return view('gestion.incidencias', ["incidencias" => $tandaIncidencias]);
    }

    public function crear(Request $request) {
        $request->validate([
            'nuevaIncidencia' => ['required', 'string', 'min:3', 'max:80'],
        ]);
        $incidencia = Incidencia::create([
            'descripcion' => $request['nuevaIncidencia'],
        ]);
        return back();
    }

}
