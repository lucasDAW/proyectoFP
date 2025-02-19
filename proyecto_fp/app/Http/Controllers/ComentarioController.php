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
    /**
     * Permite a un usuario comentar un libro o editar un comentario existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comentar(Request $request){
        
        $reglas=[
            'comentario'=>'required',
            
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute no se puede dejar vacío',
        ];
        
        
        $datosvalidados=$request->validate($reglas,$mensajeError);
        $libro_id= $request->input('libro_id');
        $libro = Libro::find($libro_id);
           
        if(Auth::check()){
            if($request->comentario_id){
                echo 'entra atui';
                $comentarioBBDD = Comentario::find($request->comentario_id);
                $comentarioBBDD->comentario = $request->comentario;
                $comentarioBBDD->libro_id = $request->libro_id;;
                $comentarioBBDD->usuario_id= $request->usuario_id;
    //            var_dump($comentarioBBDD);
    //            exit();
//                var_dump($comentarioBBDD);
//                exit();
                $comentarioBBDD->save();
                $mensaje = 'Comentario modificado.';
            }else{
                $comentario = $request->input('comentario');
                $user_id= Auth::user()->id;
                $comentarioBBDD = new Comentario;
                $comentarioBBDD->comentario = $comentario;
                $comentarioBBDD->libro_id = $libro_id;
                $comentarioBBDD->usuario_id= $user_id;
    //            var_dump($comentarioBBDD);
    //            exit();
                $comentarioBBDD->save();

                $mensaje = 'Comentario realizado.';
            }
        
        }else{
            $mensaje = 'Debe iniciar sesión para comentar.';
        }
        return redirect()->route('detallelibro',['libro'=>$libro])->with('mensaje', $mensaje);
        //si no se rellenan los campos
        
        
        return 'comentar';
    }
     /**
     * Muestra el formulario para editar un comentario.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function editarComentario(Comentario $comentario){
        
        return view('comentarios.editar',['comentario'=>$comentario]);
        
    }
     /**
     * Muestra la página de confirmación para borrar un comentario.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function delete(Comentario $comentario){
        
        
        return view('comentarios.borrarComentario',['comentario'=>$comentario]);
    }
    
     /**
     * Confirma el borrado de un comentario.
     *
     * @param  \App\Models\Comentario  $comentario
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmarBorrado(Comentario $comentario, Request $request){
        
//     
        
        if(Auth::check()){
                $libro_id =$comentario->libro_id;
                $comentario->delete();
                $mensaje =  'Se ha eliminado el comentario de forma correcta';
            
        }else{
                $mensaje =  'Debe iniciar sesión para borrar el comentario.';
        }
        
        return redirect()->route('detallelibro',['libro'=>$libro_id])->with('mensaje', $mensaje);        
    }
    
}
