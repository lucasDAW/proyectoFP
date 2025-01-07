<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;

Route::get('/', function () {
    return view('index');
});


Route::get('/',function () {
    return view('index');})->name('inicio');

Route::get('/page2',function () {
    return view('page2');})->name('page2');
    
Route::get('/libros',[LibroController::class,'index'])->name('todoslibros');
Route::get('/nuevolibro',[LibroController::class,'crearVistaLibro'])->name('nuevolibro');

