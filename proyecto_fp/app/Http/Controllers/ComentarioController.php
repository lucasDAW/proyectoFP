<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Libro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ComentarioController extends Controller
{
    //
    
    public function comentar(Request $request){
        
        $reglas=[
            'comentario'=>'required',
            'user_id'=>'required',
            'libro_id'=>'required',
            
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute no se puede dejar vacío',
        ];
        
        $datosvalidados=$request->validate($reglas,$mensajeError);
        $libro_id= $request->input('libro_id');
        $libro = Libro::find($libro_id);
        if(Auth::check()){
            $comentario = $request->input('comentario');
            $user_id= $request->input('user_id');
//            var_dump($comentario,$libro_id,$user_id);
            
            $comentarioBBDD = new Comentario;
            $comentarioBBDD->comentario = $comentario;
            $comentarioBBDD->libro_id = $libro_id;
            $comentarioBBDD->user_id= $user_id;
//            var_dump($comentarioBBDD);
//            exit();
            $comentarioBBDD->save();
            
            $mensaje = 'Comentario realizado.';
        }else{
            $mensaje = 'Debe iniciar sesión para comentar.';
        }
        return redirect()->route('detallelibro',['libro'=>$libro])->with('mensaje', $mensaje);
        //si no se rellenan los campos
        
        
        return 'comentar';
    }
    
    public function mostrarComentario(Comentario $comentario){
        
        
    }
    
    public function delete(Comentario $comentario){
        
        
        return view('comentarios.borrarComentario',['comentario'=>$comentario]);
    }
    
    
    public function confirmarBorrado(Comentario $comentario, Request $request){
        
//        var_dump($comentario);
//        var_dump($request);

        
        
        if(Auth::check()){
            $libro_id = $request->input('libro_id');
            $user_id = $request->input('user_id');
            $comentario_id = $request->input('id');
//            var_dump($libro_id,$user_id,$comentario_id);
//            var_dump($comentario);
            if (isset($comentario_id)){
                $comentario = Comentario::find($comentario_id);
                $comentario->delete();
//                $libro = Libro::find($libro_id);
    //            var_dump($libro);
    //            exit();
                $mensaje =  'Se ha eliminado el comentario de forma correcta';
            }
        }else{
                $mensaje =  'Debe iniciar sesión para borrar el comentario.';
        }
        
        return redirect()->route('detallelibro',['libro'=>$libro_id])->with('mensaje', $mensaje);        
    }
    
    public function valorar(Request $request){
        
        $valor=$request->input('valoracion');
        $user_id=$request->input('user_id');
        $libro_id=$request->input('libro_id');
        
        DB::table('calificaciones')
        ->updateOrInsert(
         ['user_id' => $user_id,'libro_id' => $libro_id],
        ['calificacion' => $valor]
        );
        
        
        return redirect()->route('detallelibro',['libro'=>$libro])->with('mensaje', 'calificación envidada');

    }
}
