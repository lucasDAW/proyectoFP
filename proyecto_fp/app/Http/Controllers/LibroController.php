<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    //
    
    public function index()
    {       
            $libros=Libro::all();
//            var_dump($libros)        
        return view('todoslibros',['libros'=>$libros]);
    
    }
    
    public function crearVistaLibro()
    {
        
        return view('libro.crear');

    }
}
