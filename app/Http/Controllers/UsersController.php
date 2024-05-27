<?php

namespace App\Http\Controllers;

use App\DataTables\ResumenParteDataTable;
use App\Imports\UsersImport;
use App\DataTables\ParteDataTable;
use App\Mail\CorreoPrueba;
use App\Models\Alumno;
use App\Models\AnioAcademico;
use App\Models\Conductanegativa;
use App\Models\Correccionaplicada;
use App\Models\Curso;
use App\Models\Incidencia;
use App\Models\Parte;
use App\Models\ParteConductanegativa;
use App\Models\ParteCorreccionsaplicada;
use App\Models\ParteIncidencia;
use App\Models\Profesor;
use App\Models\Tramohorario;
use App\Models\Unidad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function index(ParteDataTable $dataTable)
    {
        $anoAcademico = AnioAcademico::all();
        return $dataTable->render('users.index', ['anoAcademico' => $anoAcademico]);
    }

    public function resumen(ResumenParteDataTable $dataTable)
    {
        $anoAcademico = AnioAcademico::all();
        return $dataTable->render('users.resumen', ['anoAcademico' => $anoAcademico]);
    }

    public function crearParte(Request $request)
    {
        $request->validate([
            'inputProfesor' => 'required',
            'inputTramoHorario' => 'required',
            'inputCurso' => 'required',
            'inputUnidad' => 'required',
            'inputAlumno' => 'required',
//            'inputColectivo' => 'required',
            'inputFecha' => 'required',
            'inputIncidencia' => 'required',
            'inputConductasNegativa' => 'required',
            'inputCorrecionesAplicadas' => 'required',
        ]);



        $fechaInput = request('inputFecha');


        $fecha = Carbon::parse($fechaInput);


        $parte = Parte::create([
            'profesor_dni' => request('inputProfesor'),
            'tramo_horario_id' => request('inputTramoHorario'),
            'alumno_dni' => request('inputAlumno'),
            'colectivo' => 'No',
            'fecha' => $fecha,
            'descripcion_detallada' => request('inputDescripcionDetallada'),
        ]);

        ParteIncidencia::create([
            'parte_id' => $parte->id,
            'incidencia_id' => request('inputIncidencia'),
        ]);

        ParteCorreccionsaplicada::create([
            'parte_id' => $parte->id,
            'correccionaplicadas_id' => request('inputCorrecionesAplicadas'),
        ]);

        foreach (request('inputConductasNegativa') as $conducta) {
            ParteConductanegativa::create([
                'parte_id' => $parte->id,
                'conductanegativas_id' => $conducta,
            ]);
        }


        return redirect()->route('parte.index')
            ->with('success', 'Parte creado correctamente.');
    }

    public function getCursos(Request $request)
    {
        $anoId = $request->selectedId;
        $cursos = Curso::where('id_anio_academico', $anoId)->get();

        $cursoData = [];
        foreach ($cursos as $curso) {
            $cursoData[$curso->id] = $curso->nombre;
        }

        return response()->json($cursoData);
    }

    public function getUnidades(Request $request)
    {
        $cursoId = $request->selectedId;
        $unidades = Unidad::where('id_curso', $cursoId)->get();

        $unidadData = [];
        foreach ($unidades as $unidad) {
            $unidadData[$unidad->id] = $unidad->nombre;
        }

        return response()->json($unidadData);
    }

    public function getAlumnos(Request $request)
    {
        $unidadId = $request->selectedId;
        $alumnos = Alumno::where('id_unidad', $unidadId)->get();

        $alumnoData = [];
        foreach ($alumnos as $alumno) {
            $alumnoData[$alumno->dni] = $alumno->nombre;
        }

        return response()->json($alumnoData);
    }

    public function upload(Request $request)
    {
        $file = $request->file('upload');
        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move(public_path('uploads'), $fileName);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $fileName,
            'url' => '/uploads/' . $fileName
        ]);
    }

    public function indexParte()
    {
        $profesores = Profesor::all();

        $tramos = Tramohorario::all();

        $cursos = Curso::all();

        $incidencias = Incidencia::all();

        $conductasNegativas = Conductanegativa::all();

        $correcionesAplicadas = Correccionaplicada::all();

        return view('users.createParte', [
            'profesores' => $profesores,
            'tramos' => $tramos,
            'cursos' => $cursos,
            'incidencias' => $incidencias,
            'conductasNegativas' => $conductasNegativas,
            'correcionesAplicadas' => $correcionesAplicadas
        ]);
    }

    public function correo()
    {
        return view('users.correo');
    }

    public function import(Request $request)
    {

        User::truncate();
        $file = $request->file('import_file');

        Excel::import(new UsersImport, $file);

        return redirect()->route('users.index')
            ->with('Satisfactorio', 'Usuario Creado correctamente.');
    }

    public function cargarImport()
    {
        return view('users.import-excel');
    }


    public function pruebaCorreo()
    {
        Mail::to('alejandrocbt@hotmail.com')->send(new CorreoPrueba());
        return redirect()->route('user.correo');
    }
}
