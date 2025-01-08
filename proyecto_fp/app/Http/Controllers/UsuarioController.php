<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
      public function crear()
    {       
            
//            var_dump($libros)        
        return view('usuario.crear');
    
    }
}
