<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;

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
//CREATE
Route::get('/publicar',[LibroController::class,'crearVistaLibro'])->name('publicarLibro');
Route::post('/publicando',[LibroController::class,'publicarlibro'])->name('publicar');
//UPDATE
Route::get('/libro/editar/{libro}',[LibroController::class,'editar'])->name('editarlibro');

//DELETE
Route::get('/libro/borrar/{libro}',[LibroController::class,'borrar'])->name('borrar');
Route::post('/libro/borrar/confirmar',[LibroController::class,'borrarBBDD'])->name('confirmareliminar');
//  USUARIO
Route::get('/create',[UsuarioController::class,'crear'])->name('crearUsuario');

