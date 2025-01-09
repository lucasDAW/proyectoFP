<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;

Route::get('/', function () {
    return view('index');
});


Route::get('/',function () {
    return view('index');})->name('inicio');

Route::get('/page2',function () {
    return view('page2');})->name('page2');
    
//    LIBRO
//READ    
Route::get('/libros',[LibroController::class,'index'])->name('todoslibros');
Route::get('/libro/detalle/{libro}',[LibroController::class,'detalle'])->name('detallelibro');
////CREATE
//Route::get('/publicar',[LibroController::class,'crearVistaLibro'])->name('publicarLibro');
//Route::post('/publicando',[LibroController::class,'publicarlibro'])->name('publicar');
////UPDATE
//Route::get('/libro/editar/{libro}',[LibroController::class,'editar'])->name('editarlibro');
//
////DELETE
//Route::get('/libro/borrar/{libro}',[LibroController::class,'borrar'])->name('borrar');
//Route::post('/libro/borrar/confirmar',[LibroController::class,'borrarBBDD'])->name('confirmareliminar');




//  USUARIO

Route::get('/create',[UsuarioController::class,'crear'])->name('crearUsuario');
Route::get('/miperfil/{user}',[UsuarioController::class,'show'])->name('verUsuario');
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//pruebas para Route en index
//Route::get('/prueba',function (){ return  'esto es una prueba';})->name('prueba');

require __DIR__.'/auth.php';


//solo los usuarios que han iniciado sesisión pueden acceder a las rutas siguientes
//Route::middleware('auth')->group(function () {
    
    //CREATE
Route::get('/publicar',[LibroController::class,'crearVistaLibro'])->name('publicarLibro');
Route::post('/publicando',[LibroController::class,'publicarlibro'])->name('publicar');
    //UPDATE
    Route::get('/libro/editar/{libro}', [LibroController::class, 'editar'])->name('editarlibro');

//DELETE
    Route::get('/libro/borrar/{libro}', [LibroController::class, 'borrar'])->name('borrar');
    Route::post('/libro/borrar/confirmar', [LibroController::class, 'borrarBBDD'])->name('confirmareliminar');
    
//    return redirect()->route('inicio')->with('mensaje', 'Rol cambiado a administrador correctamente.');
//});
    
    
//    COMENTARIOS 
Route::post('/libro/comentar',[ComentarioController::class,'comentar'])->name('comentar');
Route::get('/comentario/borrar/{comentario}',[ComentarioController::class,'delete'])->name('eliminarComentario');
Route::post('/comentario/borrar/confirmar',[ComentarioController::class,'confirmarBorrado'])->name('confirmareliminarcomentario');