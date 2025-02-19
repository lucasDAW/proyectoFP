<?php

namespace App\Http\Controllers;

use App\Models\Autor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AutorController extends Controller
{
   /**
     * Display a listing of the resource.
     * Muestra un listado de autores.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->isMethod('POST')){

            $autores = DB::table('autor')->select('*')->where('nombre','LIKE',$request->busqueda.'%')->get();
            foreach($autores as $autor){
                if($autor->foto){
                    $url_foto = Storage::disk('archivos')->url($autor->foto);
                }else{
                    $url_foto=null;
                }
                $autor->imagen_url=$url_foto;
            }
            
              $response = [
                    "success"=>true,
                    "mensaje"=>'Consulta correcta.Busqueda Autro',
                    "busqueda"=>$request->busqueda,
                    "autores"=>$autores
                 ];
            return response()->json($response);

        }else{

            $autores= Autor::simplePaginate(9);
            foreach($autores as $autor){
                if($autor->foto){
                    $perfil_imagen= Storage::disk('archivos')->url($autor->foto);
                    $autor->imagen_url=$perfil_imagen;
                }else{
                    
                    $autor->imagen_url=null;
                }
            }
            
           
//            return view('autor.mostrarautores',['autores'=>$autores]);
            return view('autor.todos',['autores'=>$autores]);
        }

    }
    /**
     * Muestra un listado de autores para administración.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showAutores(Request $request){
        if($request->isMethod('POST')){
                
                $autores = DB::table('autor')->select('*')->where('nombre','LIKE',$request->busqueda.'%')->get();
                
                  $response = [
                        "success"=>true,
                        "mensaje"=>'Consulta correcta.',
                        "busqueda"=>$request->busqueda,
                        "autores"=>$autores
                     ];
                return response()->json($response);

            }else{
                
                $autores= Autor::simplePaginate(8);
                $informacion = DB::table('autor')->where('descripcion','=','NULL')->orWhere('fecha_nacimiento','=','NULL')->count();

                return view('administracion.autores',['autores'=>$autores,'autoresnull'=>$informacion]);
            }
    }
    /**
     * Muestra un listado de autores con información incompleta.
     *
     * @return \Illuminate\Http\Response
     */
    public function corregirAutores(){

        $autores= DB::table('autor')->where('descripcion','=','NULL')->orWhere('fecha_nacimiento','=','NULL')->simplePaginate(8);
        $informacion = DB::table('autor')->where('descripcion','=','NULL')->orWhere('fecha_nacimiento','=','NULL')->count();

        return view('administracion.autores',['autores'=>$autores,'autoresnull'=>$informacion]);
    }
    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo autor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::user()->rol==2){
        if($request->autor){
            $autor=Autor::find($request->autor);
         return view('autor.crearautor',['autor'=>$autor]);
        }
         return view('autor.crearautor');
        }
    }

    /**
     * Store a newly created resource in storage.
     * Guarda un nuevo autor en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->rol==2){
            
            $reglas=[
                'nombre'=>'required|max:100',
                'descripcion'=>'required',
                'fecha'=>'required',
                'referencias'=>'required',
            ];
            $mensajeError = [
                'required' => 'Cuidado!! el campo :attribute esta vacío',
            ];

            //si no se rellenan los campos
            $datosvalidados=$request->validate($reglas,$mensajeError);
            
            
            
            $perfil = $request->file('imagen');
        
            if(!empty($perfil)){
                $perfilpath = $perfil->store('/imagenesperfil','archivos');
            }else{
                $perfilpath=null;
            }
            if ($request->id_autor){
                $autor = Autor::find($request->id_autor);
                $autor->nombre = $request->nombre;
                $autor->descripcion = $request->descripcion;
                $autor->fecha_nacimiento = $request->fecha;
                $autor->referencias = $request->referencias;
                $autor->foto =$perfilpath;
                $autor->save();
                    $mensaje = 'Se ha modificado';
            }else{
                $autor = new Autor();
                $autor->nombre = $request->nombre;
                $autor->descripcion = $request->descripcion;
                $autor->fecha_nacimiento = $request->fecha;
                $autor->referencias = $request->referencias;
                $autor->save();
                $mensaje = 'Se ha creado';
            }


           return redirect()->route('verAutoresAdmin')->with('mensaje',($mensaje. ' el autor en la base de datos'));
        }
           return redirect()->route('inicio')->with('mensaje',('No tiene permisos'));
    }

    /**
     * Display the specified resource.
     * Muestra la información de un autor específico.
     *
     * @param  \App\Models\Autor  $autor
     * @return \Illuminate\Http\Response
     */
    public function show(Autor $autor)
    {
        $libros =DB::table('libro')
               ->join('autor','libro.autor_id','=','autor.id')
               ->join('categoria','libro.categoria_id','=','categoria.id')
               ->select('libro.id as libro_id','libro.titulo','categoria.id as categoria_id','categoria.nombre')
                ->where('autor.id','LIKE',$autor->id)->get();

        foreach($libros as $libro){
               $documentos= DB::table('archivos')->where('libro_id',$libro->libro_id)->first();
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
        if($autor->foto){
            $urlfoto = Storage::disk('archivos')->url($autor->foto);
        }else{
            $urlfoto=null;
        }

        $autor->imagen_url = $urlfoto;

        return view('autor.verautor',['autor'=>$autor,'autorlibros'=>$libros]);
       
    }

    /**
     * Show the form for editing the specified resource.
     * funcion ya implementada en create
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * funcion ya implementada en create
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Borra el autor de la base de datos
     */
    public function destroy(Autor $autor)
    {
        if(Auth::user()->rol==2){

              
              $autor->delete();
              $mensaje = 'Se ha borrado ';
              return redirect()->route('verAutoresAdmin')->with('mensaje',($mensaje. 'el autor en la base de datos'));
          }
         return redirect()->route('inicio')->with('mensaje',('No tiene permisos'));
    }
}
