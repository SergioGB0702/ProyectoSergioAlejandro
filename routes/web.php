<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/resumen', [UsersController::class, 'resumen'])->name('parte.resumen');
    Route::post('/upload', [UsersController::class, 'upload']);
    Route::get('/cursos', [UsersController::class, 'getCursos']);
    Route::get('/unidades', [UsersController::class, 'getUnidades']);
    Route::get('/alumnos', [UsersController::class, 'getAlumnos']);
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/indexParte', [UsersController::class, 'indexParte'])->name('parte.index');
    Route::post('/createParte', [UsersController::class, 'crearParte'])->name('parte.create');
    Route::get('/descargarPartePDF/{id}', [UsersController::class, 'descargarPartePDF'])->name('descargarPartePDF');
    Route::post('/updateParte/{id}', [UsersController::class, 'editarParte'])->name('parte.update');
    Route::get('/deleteParte/{id}', [UsersController::class, 'eliminarParte'])->name('parte.delete');
    Route::get('/correo', [UsersController::class, 'correo'])->name('user.correo');
    Route::get('/correoenviar', [UsersController::class, 'pruebaCorreo'])->name('user.enviarcorreo');
    Route::get('/import', [UsersController::class, 'cargarImport'])->name('users.import');
    Route::post('/import', [UsersController::class, 'import'])->name('users.import');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/prueba', [App\Http\Controllers\HomeController::class, 'prueba'])->name('prueba');
    Route::get('/prueba2', [App\Http\Controllers\HomeController::class, 'prueba2'])->name('prueba2');

    Route::get('/gestion/incidencias', [App\Http\Controllers\IncidenciasController::class, 'index'])->name('gestion.incidencias');
    Route::post('/gestion/incidencias', [App\Http\Controllers\IncidenciasController::class, 'crear'])->name('gestion.incidencias.crear');
    Route::get('/gestion/incidencias/editar/{id}', [App\Http\Controllers\IncidenciasController::class, 'editar'])->name('gestion.incidencias.editar');
    Route::get('/gestion/incidencias/eliminar/{id}', [App\Http\Controllers\IncidenciasController::class, 'eliminar'])->name('gestion.incidencias.eliminar');

    Route::get('/gestion/correccionesaplicadas', [App\Http\Controllers\CorreccionesAplicadasController::class, 'index'])->name('gestion.correcciones');
    Route::post('/gestion/correccionesaplicadas', [App\Http\Controllers\CorreccionesAplicadasController::class, 'crear'])->name('gestion.correcciones.crear');
    Route::get('/gestion/correccionesaplicadas/editar/{id}', [App\Http\Controllers\CorreccionesAplicadasController::class, 'editar'])->name('gestion.correcciones.editar');
    Route::get('/gestion/correccionesaplicadas/eliminar/{id}', [App\Http\Controllers\CorreccionesAplicadasController::class, 'eliminar'])->name('gestion.correcciones.eliminar');

    Route::get('/get-course-unit', [App\Http\Controllers\UsersController::class, 'getCourseUnit']);
    Route::get('/getParte/{id}', [App\Http\Controllers\UsersController::class, 'getParte']);

    Route::get('/gestion/profesoralumno', [App\Http\Controllers\ProfesorAlumnoController::class, 'index'])->name('gestion.profesoralumno');
    Route::get('/gestion/obtenerCorreos', [App\Http\Controllers\ProfesorAlumnoController::class, 'obtenerCorreos'])->name('gestion.obtenerCorreos');

    Route::get('/gestion/conductasnegativas', [App\Http\Controllers\ConductasNegativasController::class, 'index'])->name('gestion.negativas');
    Route::post('/gestion/conductasnegativas', [App\Http\Controllers\ConductasNegativasController::class, 'crear'])->name('gestion.negativas.crear');
    Route::get('/gestion/conductasnegativas/editar/{id}', [App\Http\Controllers\ConductasNegativasController::class, 'editar'])->name('gestion.negativas.editar');
    Route::get('/gestion/conductasnegativas/eliminar/{id}', [App\Http\Controllers\ConductasNegativasController::class, 'eliminar'])->name('gestion.negativas.eliminar');

    Route::get('/gestion/puntos', function () {
        return view("gestion.puntos");
    })->name('gestion.puntos');
    Route::get('/gestion/profesoralumno/reiniciarpuntos', [App\Http\Controllers\ProfesorAlumnoController::class, 'reinciarPuntos'])->name('gestion.reinciarpuntos');
});
