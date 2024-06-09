<?php

namespace App\Http\Controllers;

use App\DataTables\ResumenParteDataTable;

use App\Imports\AlumnosImport;
use App\DataTables\ParteDataTable;
use App\Mail\CorreoJefaturaParte;
use App\Mail\CorreoPuntosParte;
use App\Mail\CorreoTutoresParte;
use App\Models\Alumno;
use App\Models\AlumnoParte;
use App\Models\AnioAcademico;
use App\Models\Conductanegativa;
use App\Models\Correccionaplicada;
use App\Models\Correo;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{

    public function index(ParteDataTable $dataTable)
    {
        $anoAcademico = AnioAcademico::all();
        $profesores = Profesor::all();

        $tramos = Tramohorario::all();

        $cursos = Curso::all();

        $incidencias = Incidencia::all();

        $conductasNegativas = Conductanegativa::all();

        $correcionesAplicadas = Correccionaplicada::all();
        return $dataTable->render('users.index', ['anoAcademico' => $anoAcademico, 'profesores' => $profesores, 'tramos' => $tramos, 'cursos' => $cursos, 'incidencias' => $incidencias, 'conductasNegativas' => $conductasNegativas, 'correcionesAplicadas' => $correcionesAplicadas]);
    }

    public function getCourseUnit(Request $request)
    {
        // Obtener los valores de los parámetros curso y unidad de la solicitud
        $curso = $request->query('curso');
        $unidad = $request->query('unidad');

        // Lógica adicional para procesar los valores de curso y unidad si es necesario
        // Por ejemplo, puedes obtener información adicional de la base de datos aquí

        return response()->json(['curso' => $curso, 'unidad' => $unidad]);
    }


    public function resumen(ResumenParteDataTable $dataTable)
    {
        $anoAcademico = AnioAcademico::all();
        return $dataTable->render('users.resumen', ['anoAcademico' => $anoAcademico]);
    }

    public function crearParte(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Profesor' => 'required',
            'TramoHorario' => 'required',
//            'Curso' => 'required',
//            'Unidad' => 'required',
            'Alumno' => 'required',
            'Puntos' => 'required',
//            'Colectivo' => 'required',

            'Fecha' => 'required',
            'Incidencia' => 'required',
            'ConductasNegativa' => 'required',
            'CorrecionesAplicadas' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fechaInput = request('Fecha');


        $fecha = Carbon::parse($fechaInput)->format('Y-m-d H:i');

        $parte = Parte::create([
            'profesor_dni' => request('Profesor'),
            'tramo_horario_id' => request('TramoHorario'),
            'colectivo' => count(request('Alumno')) > 1 ? 'Si' : 'No',
            'created_at' => $fecha,
            'puntos_penalizados' => intval(request('Puntos')),
            'descripcion_detallada' => request('DescripcionDetallada'),
        ]);

        ParteIncidencia::create([
            'parte_id' => $parte->id,
            'incidencia_id' => request('Incidencia'),
        ]);

        ParteCorreccionsaplicada::create([
            'parte_id' => $parte->id,
            'correccionaplicadas_id' => request('CorrecionesAplicadas'),
        ]);

        foreach (request('ConductasNegativa') as $conducta) {
            ParteConductanegativa::create([
                'parte_id' => $parte->id,
                'conductanegativas_id' => $conducta,
            ]);
        }


        foreach (request('Alumno') as $alumno) {


            AlumnoParte::create([
                'alumno_dni' => $alumno,
                'parte_id' => $parte->id,
            ]);


            $alumnoModel = Alumno::where('dni', $alumno)->first();
            $puntosARestar = intval(request('Puntos'));

            if ($alumnoModel->puntos <= $puntosARestar) {
                $alumnoModel->puntos = 0;
                foreach ($alumnoModel->correos as $correo) {
//                Mail::to($correo->correo)->queue(new CorreoPuntosParte($alumnoModel));
                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoPuntosParte($alumnoModel));
                }
            } else {
                $alumnoModel->decrement('puntos', $puntosARestar);
            }

            $alumnoModel->save();
            foreach ($alumnoModel->correos as $correo) {
//                Mail::to($correo->correo)->queue(new CorreoTutoresParte($alumnoModel, $parte));
                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoTutoresParte($alumnoModel, $parte));
            }

        }
        Mail::to('alejandrocbt@hotmail.com')->send(new CorreoJefaturaParte($parte));

        return redirect()->route('parte.index')
            ->with('success', 'Parte creado correctamente.');
    }


    public function editarParte(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Profesor' => 'required',
            'TramoHorario' => 'required',
//            'Curso' => 'required',
//            'Unidad' => 'required',
            'Alumno' => 'required',
            'Puntos' => 'required',
//            'Colectivo' => 'required',
            'Fecha' => 'required',
            'Incidencia' => 'required',
            'ConductasNegativa' => 'required',
            'CorrecionesAplicadas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Obtén el parte basado en el id
        $parte = Parte::find($request->input('id'));

        // Obtén la lista actual de alumnos asociados con el parte
        $alumnosActuales = $parte->alumnos->pluck('dni')->toArray();

        // Obtén la lista de alumnos seleccionados en el select
        $alumnosSeleccionados = $request->input('Alumno');

        // Encuentra los alumnos que necesitan ser eliminados
        $alumnosAEliminar = array_diff($alumnosActuales, $alumnosSeleccionados);

        // Elimina las relaciones para los alumnos que necesitan ser eliminados
        foreach ($alumnosAEliminar as $dniAlumno) {
            $alumno = Alumno::where('dni', $dniAlumno)->first();
            if ($alumno) {
                $parte->alumnos()->detach($alumno->dni);
                $parte->alumnos()->increment('puntos', $parte->puntos_penalizados);
                foreach ($alumno->correos as $correo) {
//                Mail::to($correo->correo)->queue(new CorreoTutoresParte($alumnoModel, $parte));
                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoTutoresParte($alumno, $parte, true));
                }

            }


        }

        $fechaInput = request('Fecha');


        $fecha = Carbon::parse($fechaInput)->format('Y-m-d H:i');

        // Actualiza los demás campos del parte
        $parte->update([
            'created_at' => $fecha,
            'colectivo' => count(request('Alumno')) > 1 ? 'Si' : 'No',
            'profesor_dni' => $request->input('Profesor'),
            'tramo_horario_id' => $request->input('TramoHorario'),
            'puntos_penalizados' => $request->input('Puntos'),
            'descripcion_detallada' => $request->input('DescripcionDetallada'),
        ]);

        //$parteIncidencia = ParteIncidencia::where('parte_id', $parte->id)->first();

        $parte->incidencias()->update([
            'incidencia_id' => $request->input('Incidencia'),
        ]);


// Obtén la instancia de ParteCorreccionsaplicada que deseas actualizar
        //$parteCorreccion = ParteCorreccionsaplicada::where('parte_id', $parte->id)->first();

        $parte->correccionesaplicadas()->update([
            'correccionaplicadas_id' => $request->input('CorrecionesAplicadas'),
        ]);


        // Obtén las conductas negativas actuales asociadas con el parte
        $conductasActuales = ParteConductanegativa::where('parte_id', $parte->id)->pluck('conductanegativas_id')->toArray();

        // Obtén las conductas negativas seleccionadas en la solicitud
        $conductasSeleccionadas = $request->input('ConductasNegativa');

        // Encuentra las conductas que necesitan ser eliminadas
        $conductasAEliminar = array_diff($conductasActuales, $conductasSeleccionadas);

        // Elimina las relaciones para las conductas que necesitan ser eliminadas
        foreach ($conductasAEliminar as $conductaId) {
            $conducta = Conductanegativa::where('id', $conductaId)->first();
            if ($conducta) {
                $parte->conductanegativas()->detach($conducta->id);
            }
        }

        // Encuentra las conductas que necesitan ser añadidas
        $conductasAAñadir = array_diff($conductasSeleccionadas, $conductasActuales);

        // Añade las nuevas relaciones para las conductas que necesitan ser añadidas
        foreach ($conductasAAñadir as $conductaId) {
            ParteConductanegativa::create([
                'parte_id' => $parte->id,
                'conductanegativas_id' => $conductaId,
            ]);
        }

        // Actualiza las relaciones para los alumnos seleccionados


        $alumnosAAñadir = array_diff($alumnosSeleccionados, $alumnosActuales);

        foreach (request('Alumno') as $alumno) {

            if (in_array($alumno, $alumnosAAñadir)) {
                AlumnoParte::create([
                    'alumno_dni' => $alumno,
                    'parte_id' => $parte->id,
                ]);
                $alumnoModel = Alumno::where('dni', $alumno)->first();
                $puntosARestar = intval(request('Puntos'));

                $alumnoModel->increment('puntos', $parte->puntos_penalizados);
                if ($alumnoModel->puntos <= $puntosARestar) {
                    $alumnoModel->puntos = 0;

                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoPuntosParte($alumnoModel));
                } else {
                    $alumnoModel->decrement('puntos', $puntosARestar);
                }

                $alumnoModel->save();
                foreach ($alumno->correos as $correo) {
//                Mail::to($correo->correo)->queue(new CorreoTutoresParte($alumnoModel, $parte));
                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoTutoresParte($alumno, $parte));
                }
            } else {

                $alumnoModel = Alumno::where('dni', $alumno)->first();
                $puntosARestar = intval(request('Puntos'));

                $alumnoModel->increment('puntos', $parte->puntos_penalizados);
                if ($alumnoModel->puntos <= $puntosARestar) {
                    $alumnoModel->puntos = 0;

                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoPuntosParte($alumnoModel));
                } else {
                    $alumnoModel->decrement('puntos', $puntosARestar);
                }

                $alumnoModel->save();

                foreach ($alumnoModel->correos as $correo) {
//                Mail::to($correo->correo)->queue(new CorreoTutoresParte($alumnoModel, $parte));
                    Mail::to('alejandrocbt@hotmail.com')->send(new CorreoTutoresParte($alumnoModel, $parte, false, true));
                }
            }


        }


        Mail::to('alejandrocbt@hotmail.com')->send(new CorreoJefaturaParte($parte, false, true));

        return redirect()->route('parte.index')
            ->with('success', 'Parte creado correctamente.');
    }

    public function eliminarParte($id)
    {
        $parte = Parte::find($id);

        $alumnos = AlumnoParte::where('parte_id', $parte->id)->get();

        foreach ($alumnos as $alumno) {
            $alumnoModel = Alumno::where('dni', $alumno->alumno_dni)->first();
            $alumnoModel->increment('puntos', $parte->puntos_penalizados);
            $alumnoModel->save();
            foreach ($alumnoModel->correos as $correo) {
//                Mail::to($correo->correo)->queue(new CorreoTutoresParte($alumnoModel, $parte));
                Mail::to('alejandrocbt@hotmail.com')->send(new CorreoTutoresParte($alumnoModel, $parte, true));
            }

        }
        Mail::to('alejandrocbt@hotmail.com')->send(new CorreoJefaturaParte($parte, true));
        $parte->delete();

        return redirect()->route('parte.index')
            ->with('success', 'Parte eliminado correctamente.');
    }

    public function getParte($id)
    {
        $parteId = $id;
        $parte = Parte::find($parteId);

        $alumnos = AlumnoParte::where('parte_id', $parteId)->get();
        $profesor = Profesor::where('dni', $parte->profesor_dni)->first()->get();
        $incidencia = ParteIncidencia::where('parte_id', $parteId)->get();
        $conductasNegativas = ParteConductanegativa::where('parte_id', $parteId)->get();
        $correcionesAplicadas = ParteCorreccionsaplicada::where('parte_id', $parteId);


        return response()->json([
            'id' => $parte->id,
            'fecha' => Carbon::parse($parte->created_at)->format('Y-m-d H:i'), // Formato 'Y-m-d' para que funcione con el componente 'date' de Vue
            'alumnos' => $alumnos,
            'profesor' => $profesor->first()->dni,
            'incidencia' => $incidencia->first()->incidencia_id,
            'conductasNegativas' => $conductasNegativas,
            'correcionesAplicadas' => $correcionesAplicadas->first()->correccionaplicadas_id,
            'tramoHorario' => $parte->tramo_horario_id,
            'puntos' => $parte->puntos_penalizados,
            'descripcionDetallada' => $parte->descripcion_detallada,

        ]);
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

    public function descargarPartePDF($id)
    {
        // Obtén el parte basado en el ID
        $parte = Parte::find($id);

        // Comprueba si la descripción detallada está vacía
        if (!empty($parte->descripcion_detallada)) {
            // Crea una nueva instancia de DOMDocument
            $dom = new \DOMDocument();

            // Carga el contenido HTML en DOMDocument
            @$dom->loadHTML($parte->descripcion_detallada, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Encuentra todas las imágenes en el contenido HTML
            $images = $dom->getElementsByTagName('img');

            // Itera sobre todas las imágenes
            foreach ($images as $image) {
                // Obtén la ruta de la imagen
                $src = $image->getAttribute('src');

                // Si la ruta de la imagen es relativa, conviértela en una ruta absoluta
                if (!filter_var($src, FILTER_VALIDATE_URL)) {
                    $absolutePath = public_path($src);

                    // Comprueba si el archivo existe antes de intentar obtener su contenido
                    if (file_exists($absolutePath)) {
                        // Codifica la imagen en base64
                        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
                        $data = file_get_contents($absolutePath);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                        // Reemplaza la ruta de la imagen con la cadena base64
                        $image->setAttribute('src', $base64);
                    }

                    // Agrega la clase CSS a la imagen
                    $image->setAttribute('class', 'responsive-image');
                }
            }

            // Guarda el contenido HTML con las rutas de las imágenes actualizadas
            $parte->descripcion_detallada = $dom->saveHTML();
        }

        // Genera el PDF a partir de una vista (reemplaza 'pdf' con el nombre de tu vista)
        $pdf = PDF::loadView('users.partePDF', ['parte' => $parte]);

        // Devuelve el PDF como una respuesta
        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="parte.pdf"',
        ]);
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



    public function correo()
    {
        return view('users.correo');
    }

    public function import(Request $request)
    {
        // Comprueba si se ha pasado un archivo
        if (!$request->hasFile('import_file')) {
            return redirect()->route('users.import')
                ->with('error', 'No se ha subido ningún archivo.');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Correo::truncate();
        Alumno::truncate();
        Curso::truncate();
        Unidad::truncate();
        AnioAcademico::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = $request->file('import_file');

        Excel::import(new AlumnosImport, $file);

        return redirect()->route('users.import')
            ->with('Satisfactorio', 'Datos importados correctamente.');
    }

    public function cargarImport()
    {
        return view('users.import-excel');
    }


    public function pruebaCorreo()
    {
        Mail::to('alejandrocbt@hotmail.com')->send(new CorreoTutoresParte());
        return redirect()->route('user.correo');
    }
}
