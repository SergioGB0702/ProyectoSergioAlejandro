<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;
use App\Models\Incidencia;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;

use function PHPUnit\Framework\assertIsNumeric;

class IncidenciasController extends Controller
{
    public function index() {
        $incidencias = Incidencia::select("*")->where('habilitado','=',true);
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
        return back()->with('success', 'Incidencia creada con éxito');
    }

    public function editar(Request $request, $id) {
        $request->validate([
            'cambioIncidencia' => ['required', 'string', 'min:3', 'max:80'],
        ]);
        $nuevaDescripcion = $request->cambioIncidencia;
        if ($id > 0 && $id < 1000) {
            if (Incidencia::find($id) != null) {
                $incidenciaEditar = Incidencia::find($id);
                $incidenciaEditar->descripcion = $nuevaDescripcion;
                $incidenciaEditar->save();
                return back()->with('success', 'Incidencia editada con éxito');
            }
        }
        return back()->with('success', 'Error al editar la incidencia');
    }

    public function eliminar($id) {
        if ($id > 0 && $id < 1000) {
            if (Incidencia::find($id) != null) {
                Incidencia::destroy($id);
                return redirect('/gestion/incidencias')->with('success', 'La incidencia se ha eliminado con éxito');
            }
            return redirect('/gestion/incidencias')->with('success', 'La incidencia a eliminar no existe');
        }
        return redirect('/gestion/incidencias')->with('success', 'Error al eliminar la incidencia');
    }

    public function habilitar(Request $request) {
        $id = $request->id;
        $incidencia = Incidencia::select('*')->where('id','=',$id)->get()[0];
        Incidencia::where('id','=',$id)->update(['habilitado' =>  !($incidencia->habilitado)]);
        return back()->with('success', 'Incidencia deshabilitada');
    }

}
