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
      
        //paginación
//      $libros=Libro::paginate(9);
        $libros=Libro::simplePaginate(12);
           
//        var_dump($libros);
//        exit();
        foreach($libros as $libro){
            $documentos= DB::table('archivos')->where('libro_id',$libro->id)->first();
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
            
            $valoracion = DB::table('calificaciones')->where('libro_id',$libro->id)->avg('calificacion');
            $libro->valoracion= $valoracion;
        }
             return view('libro.todoslibros',['libros'=>$libros]);
    
    }
    
   
    
    public function detalle(Libro $libro){
//    
//  
        $comentarios = DB::select('SELECT c.id as id,c.comentario as comentario,u.nombre as name,u.id as usuario_id FROM comentario c , usuario u, libro l where l.id=c.libro_id and u.id=c.usuario_id and l.id=:libro_id;', ['libro_id'=>$libro->id]);
//        $valoracion = DB::select('SELECT c.* FROM calificaciones c, users u ,libros l where c.libro_id=l.id and u.id=c.user_id and c.libro_id=:libro_id;', ['libro_id'=>$libro->id]);
        $valoracionmedia = DB::select("SELECT round(avg(calificacion),0) as media,round(avg(calificacion),2)as mediafloat FROM calificaciones WHERE libro_id=:libro_id", ['libro_id'=>$libro->id])[0];
        $valoraciousuario = DB::select("SELECT calificacion  FROM calificaciones WHERE libro_id=:libro_id and usuario_id=:user_id", ['libro_id'=>$libro->id,'user_id'=>Auth::user()->id]);
        $autorlibro = DB::table('autor')
                ->join('libro','autor.id','=','libro.autor_id')
                ->select('autor.id','autor.nombre')
                ->first();
         $categoria = DB::table('categoria')
                ->join('libro','categoria.id','=','libro.categoria_id')
                ->select('categoria.id','categoria.nombre')
                ->first();
        
        
        if(Auth::check()){
            $listadeseos = DB::table('listadeseos')
            ->select(DB::raw('count(*) as existe'))
                    ->where('usuario_id','=',Auth::user()->id)->where('libro_id','=',$libro->id)
            ->get()[0];
            
            $autor = DB::table('archivos')
                    ->select(DB::raw('count(*) as existe'))
                    ->where('usuario_id','=',Auth::user()->id)->where('libro_id','=',$libro->id)
            ->first();
            
           
        }
        
        if(empty($comentarios)){
            $comentarios=null;
        }
        if(empty($valoracion)){
            $valoracion=null;
        } if(empty($valoraciousuario)){
            $valoraciousuario=null;
        } 
        if(empty($listadeseos)){
            $listadeseos=null;
        }
        if(empty($autor)){
            $autor=null;
        }
        
        $documentos= DB::table('archivos')->where('libro_id',$libro->id)->first();
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
        
       
        return view('libro.detalle',['libro'=>$libro,'archivo'=>$archivo,'comentarios'=>$comentarios,'valoracion'=>$valoracionmedia,'valoracionUsuario'=>$valoraciousuario,'listadeseos'=>$listadeseos,'autor'=>$autor,'categoria'=>$categoria,'autorlibro'=>$autorlibro]);

        
    }
     public function crearVistaLibro()
    {
        $categorias = DB::table('categoria')->get();
        $autores = DB::table('autor')->get();
        return view('libro.publicar',['categorias'=>$categorias,'autores'=>$autores]);

    }
    public function publicarlibro(Request $request){
        


        $reglas=[
            'titulo'=>'required|max:100',
            'descripcion'=>'required',
            'fecha_lanzamiento'=>'regex:/^[0-9]{2,4}[a-z]([\.][c][.])?$/' ,
            'precio'=>'required|min:0|numeric',
            'archivo'=>'required|mimes:pdf'
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute esta vacío',
            'integer'=>'Cuidado!! el campo :attribute debe ser un número entero',
            'numeric'=>'Cuidado!! el campo :attribute debe ser numérico(ej:10.50)',
            'regex'=>'Cuidado!! el campo :attribute debe tener 4 cifras(año)',
            'mimes'=>'Cuidado!! el campo :attribute debe ser PDF',
        ];
        
        //si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);
        
//        acciones si se encuentra el autor en la base de datos
        if($request->otroautorcheck){
            $nombre_autor=$request->input('autorlibro');
            
            $existe = DB::table('autor')->where('nombre',$nombre_autor)->exists();
//          
            if(!$existe){
                $id_autor=DB::table('autor')->insertGetId([
                    'nombre'=>$nombre_autor,
                    'descripcion'=>'null',
                    'fecha_nacimiento'=>'null',
                    'referencias'=>'null',
                    ]);
                    
            }else{
                $autorbase = DB::table('autor')->select('*')->where('nombre','LIKE','%'.$nombre_autor.'%')->first();
               $id_autor=$autorbase->id;
            }
            
        }else{
            $id_autor=$request->autorselect;
        }
//     
        $id_categoria=$request->categoriatext;
        
        
        
        $titulo = $request->input('titulo');
        $descripcion= $request->input('descripcion');
        $precio= $request->input('precio');
        $fecha = $request->input('fecha_lanzamiento');
        $autor=$id_autor;
        $categoria = $id_categoria;
        //si se modifica el libro
        if($request->id){
            
            $id = $request->id;
        }
        //almacenar archivo y portada del libro 
        //archivo PDF
        $documento = $request->file('archivo');
        
        if(!empty($documento)){
            $nombreArchivo = $documento->store('/archivo','archivos');
            
            if($request->file('portada')){
            
                $imagen_portada = $request->file('portada');
                if($imagen_portada){

                    $portadaArchivo = $imagen_portada->store('/portada','archivos');
                }else{
                    $portadaArchivo=null;
                }
                
            }else{
                $imagen_portada = null;
            }
        }
       
        //almacenar archivo y portada del libro 
        //modificar el libro si existe en la base de datos
        if ($request->id){
            //modificar
            $libroEditar = Libro::find($id);
            $libroEditar->titulo = $titulo;
            $libroEditar->descripcion = $descripcion;
//            $libroEditar->isbn = $isbn;
            $libroEditar->autor_id = $autor;
            $libroEditar->categoria_id = $categoria;
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
            $libro->categoria = $categoria;
//            $libro->numero_paginas = $num_paginas;
            $libro->fecha_lanzamiento = $fecha;
            $libro->precio = $precio;
          
           
            $id_libro = DB::table('libro')->insertGetId(
                [
                    'titulo' => $libro->titulo,
                    'descripcion' => $libro->descripcion,
                    'autor_id' => $libro->autor,
                    'categoria_id' => $libro->categoria,
//                    'numero_paginas' => $libro->numero_paginas,
//                    'ISBN' => $libro->isbn,
                    'precio' => $libro->precio,
                    'fecha_lanzamiento' => $libro->fecha_lanzamiento,
                    
                ]);
           
//            Almacena el archivo y la portada el del libro en la BBDD
            
            
            $mensaje =  'Se ha publicado el libro de forma correcta';
        }
        $archivoLibro=$nombreArchivo;
        $portadaLibro=$portadaArchivo;
        DB::table('archivos')->updateOrInsert([
                'usuario_id'=>Auth::user()->id,
                'libro_id' => $id_libro,
                'archivo'=>$nombreArchivo,
                'portada' =>$portadaArchivo,
        ]);
        
        return redirect()->route('todoslibros')->with('mensaje', $mensaje);
    }
    
    public function editar(Libro $libro){
    
        if(Auth::check()){
                    
            $categorias = DB::table('categoria')->get();
            $autores= DB::table('autor')->get();
            $documentos= DB::table('archivos')->where('libro_id',$libro->id)->first();

            return view('libro.publicar',['libro'=>$libro,'categorias'=>$categorias,'archivo'=>$documentos,'autores'=>$autores]);
        }else{
            return redirect()->route('login')->with('mensaje', 'Debe iniciar sesión');

        }

    }
    
    public function borrar(Libro $libro,Request $request){
       return view('libro.eliminar',['id_libro'=>$request->id]);

    }
    public function borrarBBDD(Libro $libro, Request $request){
        
        $autorLibro= DB::table('archivos')->select('usuario_id')->where('libro_id',$request->id)->first();
        
        
        if(Auth::check() && (Auth::user()->rol==2 || Auth::user()->id==$autorLibro->usuario_id) ){
          $id = $request->input('id');
        
         
            if (isset($id)){
                $libro = Libro::find($id);
       
                $libro->delete();
                DB::table('archivos')->where('libro_id', $id)->delete();
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
        
     
//        $libros = DB::table('libro')->select('*')->where('titulo','LIKE','%'.$request->busqueda.'%')->orWhere('autor','LIKE','%'.$request->busqueda.'%')->get();
        $libros = DB::table('libro')
                ->join('autor','libro.autor_id','=','autor.id')
                ->select('libro.id','libro.titulo','libro.precio','autor.nombre as autor')
                ->where('libro.titulo','LIKE','%'.$request->busqueda.'%')
                ->orWhere('autor.nombre','LIKE','%'.$request->busqueda.'%')
                ->get();
        
        
        
        foreach($libros as $libro){
                $documentos= DB::table('archivos')->where('libro_id',$libro->id)->first();
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
    
//    Esto de puede borrar
    public function busquedavista(){
        
        return view('libro.busqueda');
    }
//    Esto de puede borrar
    public function busquedaBBDD(Request $request){
        
//        
        
        $campo_busqueda= $request->input('busqueda');
        $libros = DB::table('libro')->where('titulo','like','%'.$campo_busqueda.'%')->orWhere('autor','like','%'.$campo_busqueda.'%')->orWhere('ISBN','like','%'.$campo_busqueda.'%')->get();
            
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
        
    }
    
//   Funciones del usuario con rol ADMIN
    
    public function busquedaAdmin(Request $request){
        
        
        if(Auth::user()->rol==2){
            
             $libros = DB::table('libro')
                     ->join('autor','libro.autor_id','=','autor.id')
                     ->select('libro.id','libro.*','autor.nombre as autor_nombre')
                     ->where('libro.titulo','LIKE','%'.$request->busqueda.'%')
                     ->orWhere('autor.nombre','LIKE','%'.$request->busqueda.'%')
                     ->get();
            foreach($libros as $libro){
                $documentos= DB::table('archivos')->where('libro_id',$libro->id)->first();
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
                    "mensaje"=>'Consulta correcta.Busqueda de libros',
                    "libros"=>$libros,
                     ];
//        $response(['data' => 'Error al realizar la búsqueda','respuesta'=>'respuesta a get','libros'=>$libros]);
        return response()->json($response);
        }   
        
    }
    
    public function indexAdmin(){
        $libros=Libro::simplePaginate(5);
           
            
        foreach($libros as $libro){
            $documentos= DB::table('archivos')->where('libro_id',$libro->id)->first();
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
    
    
    //estadisticas libros
    public function estadisticas(Request $request){
        
        $opcionespermitidas=['pedidos','comentarios','valoraciones'];
        if(Auth::user()->rol==2){
            if (in_array($request->opcion,$opcionespermitidas) !== false) {
                
                if($request->opcion=='pedidos'){
                    $libros =DB::table('libro')
                    ->join('pedidos','pedidos.libro_id','=','libro.id')
                    ->join('autor','autor.id','=','libro.autor_id')
                    ->selectRaw('count(pedidos.libro_id) as "Total", libro.id, libro.titulo,autor.nombre  as "autor"')
                    ->groupBy('libro.id', 'libro.titulo','autor.nombre')->orderBy("Total",'desc')
                    ->get();
//                    ->get();
//                    var_dump($libros);
//                    exit();
                    
                    
                }elseif($request->opcion=='comentarios'){
                     $libros =DB::table('libro')
                    ->join('comentario','comentario.libro_id','=','libro.id')
                    ->join('autor','autor.id','=','libro.autor_id')
                    ->selectRaw('count(comentario.libro_id) as "Total", libro.id, libro.titulo,autor.nombre  as "autor"')
                    ->groupBy('libro.id', 'libro.titulo','autor.nombre')->orderBy("Total",'desc')
                    ->get();
                    
                }elseif($request->opcion=='valoraciones'){
                     $libros =DB::table('libro')
                    ->join('calificaciones','calificaciones.libro_id','=','libro.id')
                    ->join('autor','autor.id','=','libro.autor_id')
                    ->selectRaw('count(calificaciones.libro_id) as "Total", libro.id, libro.titulo,autor.nombre  as "autor"')
                    ->groupBy('libro.id', 'libro.titulo','autor.nombre')->orderBy("Total",'desc')
                    ->orderByDesc('Total')
                    ->get();
                }else{
                    return back()->with('mensaje', 'opcion no contemplada');
                }
                
                return view('administracion.estadisticas',['libros'=>$libros,'opcion'=>$request->opcion]);
                
                
            }else{
                return back()->with('mensaje', 'opcion no contemplada');
            }
        return view('administracion.estadisticas');
        }else{
            return back()->with('mensaje', 'NO tiene permisos!');
        }
       ;
    }
    
}
