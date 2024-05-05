<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Conductanegativa;
use Illuminate\Http\Request;

class ConductasNegativasController extends Controller
{
    public function index() {
        $conductas = Conductanegativa::select("*");
        $tandaConductas = $conductas->paginate(5);
        return view('gestion.negativas', ["conductas" => $tandaConductas]);
    }

    public function crear(Request $request) {
        $request->validate([
            'nuevaConducta' => ['required', 'string', 'min:3', 'max:80'],
            'nuevaConductaTipo' => ['required', 'string', 'min:3', 'max:20', 'in:Contraria,Grave'],
        ]);
        $conducta = Conductanegativa::create([
            'descripcion' => $request['nuevaConducta'],
            'tipo' => $request['nuevaConductaTipo'],
        ]);
        return back()->with('success', 'Conducta Negativa creada con éxito');
    }

    public function editar(Request $request, $id) {
        $request->validate([
            'cambioConducta' => ['required', 'string', 'min:3', 'max:80'],
            'cambioConductaTipo' => ['required', 'string', 'min:3', 'max:20', 'in:Contraria,Grave'],
        ]);
        $nuevaDescripcion = $request->cambioConducta;
        $nuevaDescripcionTipo = $request->cambioConductaTipo;
        if ($id > 0 && $id < 1000) {
            if (Conductanegativa::find($id) != null) {
                $conductaEditar = Conductanegativa::find($id);
                $conductaEditar->descripcion = $nuevaDescripcion;
                $conductaEditar->tipo = $nuevaDescripcionTipo;
                $conductaEditar->save();
                return back()->with('success', 'Conducta negativa editada con éxito');
            }
        }
        return back()->with('success', 'Error al editar la conducta');
    }

    public function eliminar($id) {
        if ($id > 0 && $id < 1000) {
            if (Conductanegativa::find($id) != null) {
                Conductanegativa::destroy($id);
                return redirect('/gestion/conductasnegativas')->with('success', 'La conducta negativa se ha eliminado con éxito');
            }
            return redirect('/gestion/conductasnegativas')->with('success', 'La conducta negativa a eliminar no existe');
        }
        return redirect('/gestion/conductasnegativas')->with('success', 'Error al eliminar la conducta negativa');
    }
}
