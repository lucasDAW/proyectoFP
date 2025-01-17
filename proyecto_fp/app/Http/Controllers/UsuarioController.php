<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
    
    public function addlistadeseos(Request $request){
        
        if(Auth::check()){
            
            $user_id=Auth::user()->id;
            $libro_id=$request->libro_id;
            $libro_ya_en_lista=$request->lista_deseos;
            if($libro_ya_en_lista){
                $deleted = DB::table('listadeseos')
                        ->where('user_id', '=', $user_id)
                        ->where('libro_id','=',$libro_id)
                        ->delete();
            }else{

    //         
                DB::table('listadeseos')
                ->updateOrInsert(
                 ['user_id' => $user_id,'libro_id' => $libro_id]
                );
            }
        } else {
             
            return json_encode(array('mensaje'=>'Debe iniciar sesion.'));

        }
        
//        return json_encode(array('success' => 1,'libro'=>$libro_ya_en_lista));
        return json_encode(array('libro'=>$libro_ya_en_lista));

    }
    
    public function showlistadeseos(){
        
//        echo Auth::user()->id;
        
        $libros =DB::table('listadeseos')
                ->join('libros','listadeseos.libro_id','=','libros.id')
                ->select('libros.id','libros.titulo','libros.autor','libros.precio')->where('listadeseos.user_id',Auth::user()->id)
                ->get();
//        var_dump($libros);
        return view('usuario.listadeseos',['libros'=>$libros]);    
        
    }
}
