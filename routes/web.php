<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

//Rota de vizualização do form e 
Route::get('formulario', [HomeController::class, 'formulario'])->name('formulario');
Route::get('formulario/{slug}', [HomeController::class, 'formCep'])->name('formCep');
Route::post('SendForm', [HomeController::class, 'SendForm' ])->name('SendForm');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
