<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
      public function crear()
    {       
            
//            var_dump($libros)        
        return view('usuario.crear');
    
    }
    
    public function show(User $user){
        
//        var_dump($user);
//        $user = User::find(7);
        
        return view('usuario.perfil',['user'=>$user]);
        
        
    }
}
