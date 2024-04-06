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
    return view('welcome');
});

Auth::routes();

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/correo', [UsersController::class, 'correo'])->name('user.correo');
Route::get('/correoenviar', [UsersController::class, 'pruebaCorreo'])->name('user.enviarcorreo');
Route::get('/import', [UsersController::class, 'cargarImport'])->name('users.import');
Route::post('/import', [UsersController::class, 'import'])->name('users.import');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
