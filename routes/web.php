<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OrganizadorController;
use App\Http\Controllers\CircuitoController;
use App\Http\Controllers\RodadaController;
use App\Http\Controllers\InscripcionController;

Route::get('/', function () {
    return view('auth.login');
});


Route::resource('usuarios', UsuarioController::class)->middleware('auth');
Route::resource('organizadores', OrganizadorController::class)->middleware('auth');
Route::resource('circuitos', CircuitoController::class)->middleware('auth');
Route::resource('rodadas', RodadaController::class)->middleware('auth');
Route::resource('inscripciones', InscripcionController::class)->middleware('auth');

Route::get('/calendario', function () {
    return view('calendario.index');
})->middleware('auth');

Route::get('/rodadas-json', [RodadaController::class, 'rodadasJson'])->middleware('auth');

Auth::routes();








Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
