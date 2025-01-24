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
    
    public function index(Request $request)
    {       
//      $libros=Libro::all();
        //paginación
//      $libros=Libro::paginate(9);
        $libros=Libro::simplePaginate(12);
           
            
        foreach($libros as $libro){
            $documentos= DB::table('archivos_test')->where('id_libro',$libro->id)->first();
//                var_dump($documentos);
            if($documentos){//si existe el archivo del libro en la bbdd
                if($documentos->archivo){
                    $urlarchivo = Storage::disk('archivos')->url($documentos->archivo);
                    if($documentos->portada){
                        $urlportada = Storage::disk('archivos')->url($documentos->portada);
                    }else{
                        $urlportada=null;
                    }

                }
                $libro->imagen_url = $urlportada;
                $libro->archivo_url = $urlarchivo;
            }
        }
       
             return view('libro.todoslibros',['libros'=>$libros]);
         
    
    }
    
   
    
    public function detalle(Libro $libro){
//    
        
        $comentarios = DB::select('SELECT c.id as id,c.comentario as comentario,u.name as name,u.id as user_id FROM comentarios c , users u, libros l where l.id=c.libro_id and u.id=c.user_id and l.id=:libro_id;', ['libro_id'=>$libro->id]);
//        $valoracion = DB::select('SELECT c.* FROM calificaciones c, users u ,libros l where c.libro_id=l.id and u.id=c.user_id and c.libro_id=:libro_id;', ['libro_id'=>$libro->id]);
        $valoracionmedia = DB::select("SELECT round(avg(calificacion),0) as media,round(avg(calificacion),2)as mediafloat FROM calificaciones WHERE libro_id=:libro_id", ['libro_id'=>$libro->id]);
//       
        if(Auth::check()){
            $listadeseos = DB::table('listadeseos')
            ->select(DB::raw('count(*) as existe'))
                    ->where('user_id','=',Auth::user()->id)->where('libro_id','=',$libro->id)
            ->get()[0];
            
            $autor = DB::table('archivos_test')
                    ->select(DB::raw('count(*) as existe'))
                    ->where('usuario_id','=',Auth::user()->id)->where('id_libro','=',$libro->id)
            ->first();
            
           
        }
        
        if(empty($comentarios)){
            $comentarios=null;
        }
        if(empty($valoracion)){
            $valoracion=null;
        } 
        if(empty($listadeseos)){
            $listadeseos=null;
        }
        if(empty($autor)){
            $autor=null;
        }
        
        $documentos= DB::table('archivos_test')->where('id_libro',$libro->id)->first();
        if($documentos){
            $urlarchivo = Storage::disk('archivos')->url($documentos->archivo);

            if($documentos->portada){

                $urlportada = Storage::disk('archivos')->url($documentos->portada);
            }else{
                $urlportada=null;
            }
            $archivo['imagen_url'] = $urlportada;
            $archivo['archivo_url']= $urlarchivo;
                
        }
        if(empty($archivo)){
            $archivo=null;
        }
//        var_dump($archivo,$libro);
        
       
        return view('libro.detalle',['libro'=>$libro,'archivo'=>$archivo,'comentarios'=>$comentarios,'valoracion'=>$valoracionmedia[0],'listadeseos'=>$listadeseos,'autor'=>$autor]);

        
    }
     public function crearVistaLibro()
    {
        $categorias = DB::table('categoria')->get();
        return view('libro.publicar',['categorias'=>$categorias]);

    }
    public function publicarlibro(Request $request){
        
        
       

        $reglas=[
            'titulo'=>'required|max:100',
            'descripcion'=>'required',
            'autor'=>'required|max:100',
//            'isbn'=>'required|max:100',
//            'paginas'=>'int',
            'fecha_lanzamiento'=>'regex:/^[0-9]{3,4}$/' ,
            'precio'=>'required|min:0|numeric',
            'archivo'=>'required|mimes:pdf'
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute esta vacío',
            'integer'=>'Cuidado!! el campo :attribute debe ser un número entero',
            'numeric'=>'Cuidado!! el campo :attribute debe ser numérico(ej:10.50)',
            'mimes'=>'Cuidado!! el campo :attribute debe PDF',
            'regex'=>'Cuidado!! el campo fecha debe tener 4 cifras(año)',
        ];
        
        //si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);
        
//        exit();
        
        $titulo = $request->input('titulo');
        $descripcion= $request->input('descripcion');
        $autor= $request->input('autor');
        $precio= $request->input('precio');
//        $isbn = $request->input('isbn');
//        $num_paginas = $request->input('paginas');
        $fecha = $request->input('fecha_lanzamiento');
        if($request->id){
            
            $id = $request->id;
        }
        
        //almacenar archivo y portada del libro 
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
       
        
        //almacenar archivo y portada del libro 
        if ($request->id){
            //modificar
            $libroEditar = Libro::find($id);
            

            $libroEditar->titulo = $titulo;
            $libroEditar->descripcion = $descripcion;
//            $libroEditar->isbn = $isbn;
            $libroEditar->autor = $autor;
//            $libroEditar->numero_paginas = $num_paginas;
            $libroEditar->fecha_lanzamiento = $fecha;
            $libroEditar->precio = $precio;
            $libroEditar->save();
            
            $id_libro = $request->id;
            $mensaje =  'Se ha modificado el libro de forma correcta';
//            echo 'modificar';
        }else{
//            publicar
//            echo 'Publicar';
            $libro = new Libro;
            $libro->titulo = $titulo;
            $libro->descripcion = $descripcion;
//            $libro->isbn = $isbn;
            $libro->autor = $autor;
//            $libro->numero_paginas = $num_paginas;
            $libro->fecha_lanzamiento = $fecha;
            $libro->precio = $precio;
            
//            $insertado=$libro->save();
//            $id_libro=$libro->id();
            
            $id_libro = DB::table('libros')->insertGetId(
                [
                    'titulo' => $libro->titulo,
                    'descripcion' => $libro->descripcion,
                    'autor' => $libro->autor,
                    'numero_paginas' => $libro->numero_paginas,
                    'ISBN' => $libro->isbn,
                    'precio' => $libro->precio,
                    'fecha_lanzamiento' => $libro->fecha_lanzamiento,
                    
                ]);
           
//            Almacena el archivo y la portada el del libro en la BBDD
            
            
            $mensaje =  'Se ha publicado el libro de forma correcta';
        }
        $archivoLibro=$nombreArchivo;
        $portadaLibro=$portadaArchivo;
        DB::table('archivos_test')->updateOrInsert([
                'usuario_id'=>Auth::user()->id,
                'id_libro' => $id_libro,
                'archivo'=>$nombreArchivo,
                'portada' =>$portadaArchivo,
        ]);
        
        return redirect()->route('todoslibros')->with('mensaje', $mensaje);
    }
    
    public function editar(Libro $libro){
    
        if(Auth::check()){
                    
            $categorias = DB::table('categoria')->get();
            $documentos= DB::table('archivos_test')->where('id_libro',$libro->id)->first();
//           

            return view('libro.publicar',['libro'=>$libro,'categorias'=>$categorias,'archivo'=>$documentos]);
        }else{
            return redirect()->route('login')->with('mensaje', 'Debe iniciar sesión');

        }

    }
    
    public function borrar(Libro $libro,Request $request){
//        var_dump($libro);
//        var_dump($request->id);
//        exit();
//        $libroelimnar = Libro::find();
       return view('libro.eliminar',['id_libro'=>$request->id]);

    }
    public function borrarBBDD(Libro $libro, Request $request){
        
        $autorLibro= DB::table('archivos_test')->select('usuario_id')->where('id_libro',$request->id)->first();
//        $autor = 
        
        
        if(Auth::check() && (Auth::user()->role==2 || Auth::user()->id==$autorLibro->usuario_id) ){
          $id = $request->input('id');
        
         
            if (isset($id)){
                $libro = Libro::find($id);
       
                $libro->delete();
                DB::table('archivos_test')->where('id_libro', $id)->delete();
                $mensaje =  'Se ha eliminado el libro de forma correcta';
            }else{
              $mensaje =  'Error al eliminar el libro.';

            }

        }else{
            $mensaje = 'Debe tener permiso de admin para borrar el elemento';
        }

        return redirect()->route('todoslibros')->with('mensaje', $mensaje);

    }
    
    public function busqueda(Request $request){
        
     
        $libros = DB::table('libros')->select('*')->where('titulo','LIKE','%'.$request->busqueda.'%')->orWhere('autor','LIKE','%'.$request->busqueda.'%')->get();
        
        
        foreach($libros as $libro){
                $documentos= DB::table('archivos_test')->where('id_libro',$libro->id)->first();
//                var_dump($documentos);
                if($documentos){
                    
                
                    if($documentos->archivo){

                        $urlarchivo = Storage::disk('archivos')->url($documentos->archivo);
                        if($documentos->portada){

                            $urlportada = Storage::disk('archivos')->url($documentos->portada);
                        }else{
                            $urlportada=null;
                        }
        //                var_dump($urlportada);
        //                var_dump($documentos->portada);
                    }
                    $libro->imagen_url = $urlportada;
                    $libro->archivo_url = $urlarchivo;
                }
            }
        $response = [
                    "success"=>true,
                    "mensaje"=>'Consulta correcta.',
                    "busqueda"=>$request->busqueda,
                    "data"=>$libros
                     ];
//        $response(['data' => 'Error al realizar la búsqueda','respuesta'=>'respuesta a get','libros'=>$libros]);
        return response()->json($response);

    }
    
    public function busquedavista(){
        
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
//    probando a leer documentos del escritorio
    public function leerdocumento(){
        
        echo "<h2>Leer documentos</h2>";
        $desktopPath = env('DESKTOP_PATH', 'C:\Users\Usuario\Desktop\libros'); // Cambia a la ruta de tu carpeta
        $csvFile = $desktopPath . '\portada.jpg';
        var_dump($csvFile);
        echo '<img src="'.$csvFile.'"/>';
    // Leer el archivo CSV
           if (!file_exists($csvFile)) {
               echo "El archivo data.csv no existe en la ruta especificada.\n";
               return;
           }
              if (file_exists($csvFile)) {
                $imagePath = Storage::disk('public')->putFileAs('libros', new File($csvFile), 'miportada.jpg');
            } else {
                $imagePath = null; // Si no existe la portada
            }
            
            var_dump($imagePath);
            $url = Storage::disk('public')->url('/libros/miportada.jpg');
            var_dump($url);
            echo '<img src="'.$url.'" alt="Portada">';
        
    }
    
    
    public function busquedaAdmin(Request $request){
        
        
        if(Auth::user()->role==2){
            
             $libros = DB::table('libros')->select('*')->where('titulo','LIKE','%'.$request->busqueda.'%')->orWhere('autor','LIKE','%'.$request->busqueda.'%')->get();
            foreach($libros as $libro){
                $documentos= DB::table('archivos_test')->where('id_libro',$libro->id)->first();
    //                var_dump($documentos);
                if($documentos){//si existe el archivo del libro en la bbdd
                    if($documentos->archivo){
                        $urlarchivo = Storage::disk('archivos')->url($documentos->archivo);
                        if($documentos->portada){
                            $urlportada = Storage::disk('archivos')->url($documentos->portada);
                        }else{
                            $urlportada=null;
                        }

                    }
                    $libro->imagen_url = $urlportada;
                    $libro->archivo_url = $urlarchivo;
                }
            }            
        
         $response = [
                    "success"=>true,
                    "mensaje"=>'Consulta correcta.',
                    "libros"=>$libros,
                     ];
//        $response(['data' => 'Error al realizar la búsqueda','respuesta'=>'respuesta a get','libros'=>$libros]);
        return response()->json($response);
        }   
        
    }
    
    public function indexAdmin(){
        $libros=Libro::simplePaginate(5);
           
            
        foreach($libros as $libro){
            $documentos= DB::table('archivos_test')->where('id_libro',$libro->id)->first();
//                var_dump($documentos);
            if($documentos){//si existe el archivo del libro en la bbdd
                if($documentos->archivo){
                    $urlarchivo = Storage::disk('archivos')->url($documentos->archivo);
                    if($documentos->portada){
                        $urlportada = Storage::disk('archivos')->url($documentos->portada);
                    }else{
                        $urlportada=null;
                    }

                }
                $libro->imagen_url = $urlportada;
                $libro->archivo_url = $urlarchivo;
            }
        }
       
             return view('administracion.libros',['libros'=>$libros]);
    }
}
