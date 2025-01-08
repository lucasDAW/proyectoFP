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
        
        return view('libro.publicar');

    }
    
    public function detalle(Libro $libro){
        
        
        return view('libro.detalle',['libro'=>$libro]);

        
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
        
        return redirect()->route('todoslibros')->with('mensaje', $mensaje);
    }
    
    public function editar(Libro $libro){
        
//       var_dump($request);
//       $id = GET['id'];
        
//       $libro=Libro::find($id);
//       var_dump($libro);
//       exit();
       return view('libro.publicar',['libro'=>$libro]);

    }
      public function borrar(Libro $libro){
        
      
//       $id = GET['id'];
        
//       $libro=Libro::find($id);
//       var_dump($libro);
//       exit();
       return view('libro.eliminar',['libro'=>$libro]);

    }
      public function borrarBBDD(Libro $libro, Request $request){
        
      
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

        return redirect()->route('todoslibros')->with('mensaje', $mensaje);

    }
}
