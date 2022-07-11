<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

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

/* ruta raiz con la vista login de jetstream */

Route::get('/', function () {
    return view('auth.login');
})->name('view.login');
Route::get('/register', function () {
    return view('auth.register');
})->name('view.register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/notas', function () {
        return view('note.index');
    })->name('dashboard');
});


/* notas */
Route::get('/notas/create', [NoteController::class, 'create'])->middleware('auth', 'verified')->name('note.create');

/* subir imagenes */
Route::post('/image/upload', [ImageController::class, 'upload'])->name('images.upload');
