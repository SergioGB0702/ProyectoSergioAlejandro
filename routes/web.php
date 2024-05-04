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
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/correo', [UsersController::class, 'correo'])->name('user.correo');
    Route::get('/correoenviar', [UsersController::class, 'pruebaCorreo'])->name('user.enviarcorreo');
    Route::get('/import', [UsersController::class, 'cargarImport'])->name('users.import');
    Route::post('/import', [UsersController::class, 'import'])->name('users.import');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/prueba', [App\Http\Controllers\HomeController::class, 'prueba'])->name('prueba');
    Route::get('/prueba2', [App\Http\Controllers\HomeController::class, 'prueba2'])->name('prueba2');

    Route::get('/gestion/incidencias', [App\Http\Controllers\IncidenciasController::class, 'index'])->name('gestion.incidencias');
    Route::post('/gestion/incidencias', [App\Http\Controllers\IncidenciasController::class, 'crear'])->name('gestion.incidencias.crear');
    Route::patch('/gestion/incidencias', [App\Http\Controllers\IncidenciasController::class, 'crear'])->name('gestion.incidencias.editar');

    Route::get('/gestion/conductasnegativas', [App\Http\Controllers\HomeController::class, 'prueba2'])->name('gestion.negativas');
    Route::get('/gestion/correccionesaplicadas', [App\Http\Controllers\HomeController::class, 'prueba2'])->name('gestion.correcciones');
});
