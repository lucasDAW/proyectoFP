<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
//subida archivos
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


class LibroController extends Controller
{
    //
    
    public function index()
    {       
            $libros=Libro::all();
//            var_dump($libros)        
        return view('libro.todoslibros',['libros'=>$libros]);
    
    }
    
    public function crearVistaLibro()
    {
        
        return view('libro.publicar');

    }
    
    public function detalle(Libro $libro){
//        ,Comentario $comentario
//        $comentarios = Libro::find(1)->comentarios;
//        var_dump($libro->id);
//        $comentarios =Comentario::where('libro_id','=',$libro->id)->get();
//        var_dump($comentarios);
//        $comentarios='';
//        var_dump($libro->comentarios);
//        $comentarios = $libro->comentarios;
//        var_dump($comentarios->comentarios);
        
        $comentarios = DB::select('SELECT c.id as id,c.comentario as comentario,u.name as name,u.id as user_id FROM comentarios c , users u, libros l where l.id=c.libro_id and u.id=c.user_id and l.id=:libro_id;', ['libro_id'=>$libro->id]);
//        $valoracion = DB::select('SELECT c.* FROM calificaciones c, users u ,libros l where c.libro_id=l.id and u.id=c.user_id and c.libro_id=:libro_id;', ['libro_id'=>$libro->id]);
        $valoracionmedia = DB::select("SELECT round(avg(calificacion),0) as media,round(avg(calificacion),2)as mediafloat FROM calificaciones WHERE libro_id=:libro_id", ['libro_id'=>$libro->id]);
        $valoracionmedia = DB::select("SELECT round(avg(calificacion),0) as media,round(avg(calificacion),2)as mediafloat FROM calificaciones WHERE libro_id=:libro_id", ['libro_id'=>$libro->id]);
//       
        if(Auth::check()){
//            $listadeseos = DB::select("SELECT count(*) FROM `listadeseos` WHERE user_id=:user_id and libro_id=:libro_id", ['libro_id'=>$libro->id,'user_id'=>Auth::user()->id]);
            $listadeseos = DB::table('listadeseos')
            
            ->select(DB::raw('count(*) as existe'))
                    ->where('user_id','=',Auth::user()->id)->where('libro_id','=',$libro->id)
            ->get()[0];
           
        }
        
        if(empty($comentarios)){
            $comentarios=null;
        }
        if(empty($valoracion)){
            $valoracion=null;
        } if(empty($listadeseos)){
            $listadeseos=null;
        }
        
        return view('libro.detalle',['libro'=>$libro,'comentarios'=>$comentarios,'valoracion'=>$valoracionmedia[0],'listadeseos'=>$listadeseos]);

        
    }
    public function publicarlibro(Request $request){
        
        
        
//        var_dump($request);
        
        $reglas=[
            'titulo'=>'required|max:100',
            'descripcion'=>'required',
            'autor'=>'required|max:100',
            'isbn'=>'required|max:100',
            'paginas'=>'int',
            'precio'=>'required|min:0|numeric',
            
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute no se puede dejar vacío',
            'integer'=>'Cuidado!! el campo :attribute debe ser un número entero',
            'numeric'=>'Cuidado!! el campo :attribute debe ser numérico(ej:10.50)',
        ];
        
        //si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);
        $titulo = $request->input('titulo');
        $descripcion= $request->input('descripcion');
        $autor= $request->input('autor');
        $precio= $request->input('precio');
        $isbn = $request->input('isbn');
        $num_paginas = $request->input('paginas');
        $fecha = $request->input('fecha');
        
        $id = $request->input('id');
        if (isset($id)){
            //modificar
            $libroEditar = Libro::find($id);
            

            $libroEditar->titulo = $titulo;
            $libroEditar->descripcion = $descripcion;
            $libroEditar->isbn = $isbn;
            $libroEditar->autor = $autor;
            $libroEditar->numero_paginas = $num_paginas;
            $libroEditar->fecha_lanzamiento = $fecha;
            $libroEditar->precio = $precio;
            $libroEditar->save();
            $mensaje =  'Se ha modificado el libro de forma correcta';
//            echo 'modificar';
        }else{
//            publicar
//            echo 'Publicar';
            $libro = new Libro;
            $libro->titulo = $titulo;
            $libro->descripcion = $descripcion;
            $libro->isbn = $isbn;
            $libro->autor = $autor;
            $libro->numero_paginas = $num_paginas;
            $libro->fecha_lanzamiento = $fecha;
            $libro->precio = $precio;
            $libro->save();
            $mensaje =  'Se ha publicado el libro de forma correcta';
        }
        
        return redirect()->route('libro.todoslibros')->with('mensaje', $mensaje);
    }
    
    public function editar(Libro $libro){
        
//       var_dump($request);
//       $id = GET['id'];
        
//       $libro=Libro::find($id);
//       var_dump($libro);
//       exit();
        
        if(Auth::check()){
            
            return view('libro.publicar',['libro'=>$libro]);
        }else{
            return redirect()->route('login')->with('mensaje', 'Debe iniciar sesión');

        }

    }
    public function borrar(Libro $libro){
        
      
//       $id = GET['id'];
        
//       $libro=Libro::find($id);
//       var_dump($libro);
//       exit();
       return view('libro.eliminar',['libro'=>$libro]);

    }
    public function borrarBBDD(Libro $libro, Request $request){
        
      
          if(Auth::check() && Auth::user()->role=='admin'){
            $id = $request->input('id');
            if (isset($id)){
                $libro = Libro::find($id);
                $libro->delete();
    //            var_dump($libro);
    //            exit();
                $mensaje =  'Se ha eliminado el libro de forma correcta';
            }else{
                $mensaje =  'Error al eliminar el libro.';

              }
          
        }else{
            $mensaje = 'Debe tener permiso de admin para borrar el elemento';
        }

        return redirect()->route('todoslibros')->with('mensaje', $mensaje);

    }
    
    public function busqueda(){
        return view('libro.busqueda');
    }
    
    public function busquedaBBDD(Request $request){
        
//        
        
        $campo_busqueda= $request->input('busqueda');
        $libros = DB::table('libros')->where('titulo','like','%'.$campo_busqueda.'%')->orWhere('autor','like','%'.$campo_busqueda.'%')->orWhere('ISBN','like','%'.$campo_busqueda.'%')->get();
            
        $arrayLibros=[];
            
        foreach($libros as $l){
            $libroObject = new Libro;
            $libroObject->id= $l->id;
            $libroObject->titulo = $l->titulo;
            $libroObject->descripcion = $l->descripcion;
            $libroObject->isbn = $l->ISBN;
            $libroObject->autor = $l->autor;
            $libroObject->numero_paginas = $l->numero_paginas;
            $libroObject->fecha_lanzamiento = $l->fecha_lanzamiento;
            $libroObject->precio = $l->precio;

            $arrayLibros[$l->id]=$libroObject;
        }
            
            
        return view('libro.busqueda',['libros'=>$arrayLibros]);
                
                    
                    
         
                    //        ESTO es para FECTJ con js
                    //        
                    //        
                                        //        $response = [
                    //            "success"=>false,
                    //            "mensaje"=>'Ha ocurrido un error.'
                    //        ];
//        
                    //            $response = [
                    //            "success"=>true,
                    //            "mensaje"=>'Consulta correcta.',
                    //            "data"=>$libros
                    //             ];
                    //        return response()->json($response);
            

        
    }
    
//    TEST, probando para subida de archivos y adjuntado a email
    public function publicar(){
        
        $libros = DB::table('archivos_test')->get();
        
        
        foreach($libros as $libro){
//            var_dump($libro);
            $urlarchivo = Storage::disk('archivos')->url($libro->archivo);
            if($libro->portada){
                
                $urlportada = Storage::disk('archivos')->url($libro->portada);
                $libro->imagen_url = $urlportada;
            }
            
            $libro->archivo_url = $urlarchivo;
        }
        
//            var_dump($libros);
//            $libros->imagen_url=$url;
//        exit();
        
        return view('libro.archivo',['libros'=>$libros])->with('mensaje','Pagina de publicar libro');
    }
    
    public function subir(Request $request){
        
        $reglas=[
            'titulo'=>'required|max:100',
            
            'archivo'=>'required|mimes:pdf',
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute no se puede dejar vacío',
            'mimes' => 'El archivo deber un PDF.'
        ];  
//      si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);
    
        $titulo = $request->titulo;
        $precio = $request->precio;
      
        
        //archivo PDF
        $documento = $request->file('archivo');
        
        if($request->file('portada')){
            
            $imagen_portada = $request->file('portada');
            
        }else{
            $imagen_portada = null;
        }
//        var_dump($documento,$imagen_portada);
//        
        if(!empty($documento)){
            $nombreArchivo = $documento->store('/archivo','archivos');
            if($imagen_portada){
                
                $portadaArchivo = $imagen_portada->store('/portada','archivos');
            }else{
                $portadaArchivo=null;
            }
        }

//        exit();
        //        BBDD
        
        $tituloLibro=$titulo;
        $precioLibro=$precio;
        $archivoLibro=$nombreArchivo;
        $portadaLibro=$portadaArchivo;
        DB::table('archivos_test')->insert([
            'titulo' => $tituloLibro,
            'precio' => $precioLibro,
            'archivo'=>$nombreArchivo,
            'portada' =>$portadaArchivo,
        ]);
        return redirect()->route('subirarchivo')->with('mensaje', 'SE HA SUBIDO EL LIBRO');//        
        
    }
    
    public function bajar(Request $request){
        
        var_dump($request->tituloLibro);
        $libro = DB::table('archivos_test')->where('id',$request->tituloLibro)->get()[0];
        var_dump($libro);
        
        $nombre=$libro->archivo;
        $nombre = explode('/',$nombre);
//        var_dump($nombre[count($nombre)-1]);
        $nombrealamacen = $nombre[count($nombre)-1];
//        $url = Storage::url($nombre);
//        
//        
//      
//        var_dump($url);
        $contents = Storage::disk('public')->get($nombrealamacen);
        var_dump($contents);
//        return Storage::download($nombrealamacen);
    }
    public function correo(){}
}
