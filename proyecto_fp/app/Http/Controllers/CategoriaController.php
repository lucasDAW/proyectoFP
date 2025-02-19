<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra un listado de categorías (para administración).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Auth::user()->rol==2){
            
            $categorias= Categoria::all();
            return view('administracion.categorias',['categorias'=>$categorias]);
        }
    }
     /**
     * Muestra todas las categorías (para el público).
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarTodasCategorias(){
        
        $categorias = Categoria::all();
        return view('categoria.mostrar',['categorias'=>$categorias]);
    }

     /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear una nueva categoría (para administración).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
         
        if(Auth::user()->rol==2){
            if($request->categoria){
                $categoria=Categoria::find($request->categoria);
                return view('categoria.crear',['categoria'=>$categoria]);
            }
            return view('categoria.crear');
        }
    }

     /**
     * Store a newly created resource in storage.
     * Guarda una nueva categoría en la base de datos (para administración).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
     
        if(Auth::user()->rol==2){
            
            $reglas=[
                'nombre'=>'required|max:100',
            ];
            $mensajeError = [
                'required' => 'Cuidado!! el campo :attribute esta vacío',
            ];

            //si no se rellenan los campos
            $datosvalidados=$request->validate($reglas,$mensajeError);
            if ($request->categoria){
                $categoria = Categoria::find($request->categoria);
                $categoria->nombre = $request->nombre;
                
                $categoria->save();
                    $mensaje = 'Se ha modificado';
            }else{
                $categoria = new Categoria();
                $categoria->nombre = $request->nombre;
                
                $categoria->save();
                $mensaje = 'Se ha creado';
            }


           return redirect()->route('verCategoriaAdmin')->with('mensaje',($mensaje. ' la categoría en la base de datos'));
        }
           return redirect()->route('inicio')->with('mensaje',('No tiene permisos'));
    }

     /**
     * Display the specified resource.
     * Muestra la información de una categoría específica y sus libros.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        $libros = DB::table('categoria')
                ->join('libro','libro.categoria_id','=','categoria.id')
                ->join('autor','libro.autor_id','=','autor.id')
                ->select('libro.*','autor.nombre as autor_nombre','categoria.nombre as categoria')
                ->where('categoria.id','=',$categoria->id)->simplePaginate(12);
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
        
        return view('categoria.ver',['libros'=>$libros,'categoria'=>$libros[0]->categoria]);
    }

    /**
     * Show the form for editing the specified resource.
     * ya implementado en create
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * * ya implementado en create
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Elimina una categoría (para administración).
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        if(Auth::user()->rol==2){

              
              $categoria->delete();
              $mensaje = 'Se ha borrado ';
              return redirect()->route('verCategoriaAdmin')->with('mensaje',($mensaje. 'la categoria en la base de datos'));
          }
         return redirect()->route('inicio')->with('mensaje',('No tiene permisos'));
    }
}
