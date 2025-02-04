<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class UsuarioController extends Controller
{
      public function crear()
    {       
            
//            var_dump($libros)   
 
        return view('usuario.register');
    
    }
      public function login()
    {       
            
//            var_dump($libros)        
        return view('usuario.login');
    
    }
    
    public function editarperfil(Request $request){
        
//     
        
        if(Auth::user()->rol==2 && $request->id){
            $usuario = User::find($request->id);
            return view('usuario.editar',['usuario'=>$usuario]);
        }
            
        
     return view('usuario.editar');
        
    }
    public function modificarperfil(Request $request){
        
//        modificando un usuario desde el panel de admin
        if($request->id_usuario && Auth::user()->rol==2){
  
            $reglas=[
                'nombre' => ['required', 'string', 'max:255'],
                'password' => ['required'],
                'email' => 'required|unique:Users,email',
            ];
            $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute esta vacío',
            'unique'=>'Ya existe el correo introducido en la base de datos',
        ];
        
        //si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);

            $usuario = User::find($request->id_usuario);
            $usuario->nombre=$request->name;
            $usuario->email=$request->email;
            $usuario->password=Hash::make($request->password);
            $usuario->save();
            
            return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se han modificado los datos del usuario correctamente');
 
        }
        if(Auth::check()){
            if($request->email == Auth::user()->email){
                $reglas=[
                    'nombre' => ['required'],
                    'password' => ['required'],
                ];
        
                $mensajeError = [
                    'required' => 'Cuidado!! el campo :attribute esta vacío',
                    'unique'=>'Ya existe el correo introducido en la base de datos',
                ];
            }else{
                 $reglas=[
                    'nombre' => ['required', 'string', 'max:255'],
                    'password' => ['required'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                ];
                $mensajeError = [
                    'required' => 'Cuidado!! el campo :attribute esta vacío',
                    'unique'=>'Ya existe el correo introducido en la base de datos',
                ];
            }
            
            $datosvalidados=$request->validate($reglas,$mensajeError);
            
            $usuario = User::find(Auth::user()->id);
            $usuario->nombre=$request->nombre;
            $usuario->email=$request->email;
            $usuario->password=Hash::make($request->password);
           
            $usuario->save();
            
            
             return view('usuario.perfil',['usuario'=>$usuario])->with('mensaje', 'Se han modificado los datos del usuario correctamente');
 
        }else{
             return view('usuario.perfil',['usuario'=>$usuario])->with('mensaje', 'Se ha producido un fallo en la modificación de los datos del usuario. Por favor, contacte con administración');
            
        }
    }
    
    public function show(User $user,Request $request){
        
        $user = User::find($request->usuario_id);
        
       $valoraciones = DB::table('calificaciones')
               ->join('usuario','usuario.id','=','calificaciones.usuario_id')
               ->join('libro','libro.id','=','calificaciones.libro_id')
               ->select('libro.id','libro.titulo','calificaciones.*')
               ->where('usuario.id','LIKE',$request->usuario_id)->get();
    
        $user->valoraciones=$valoraciones;

        return view('usuario.perfil',['usuario'=>$user]);
        
        
    }
    
    public function showMispublicaciones(Request $request){
        $libros =DB::table('archivos')
                ->join('libro','archivos.libro_id','=','libro.id')
                ->join('autor','autor.id','=','libro.autor_id')
                ->select('libro.id','libro.titulo','autor.nombre as autor','libro.precio')->where('archivos.usuario_id',Auth::user()->id)
                ->get();
        
        return view('usuario.mipublicaciones',['libros'=>$libros]);
    }
    
  
    public function eliminar(Request $request){
       
//        eliminando desde admin
         if(Auth::user()->rol==2 && $request->id_usuario){
//            $usuario = User::find($request->id);
//            return view('usuario.editar',['usuario'=>$usuario]);
            return view('usuario.eliminar',['id'=>$request->id_usuario]);    
        }
        return view('usuario.eliminar');    

    }
    
    public function eliminarbbdd(Request $request){
        
//        var_dump($request->id);
        $usuario = User::find($request->id);
//        var_dump($usuario);
        $usuario->delete();
        if(isset($request->adminaccion)){
            return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se ha eliminado el usuario correctamente');
        }
        $request->session()->invalidate();
        Auth::guard('web')->logout();
        $request->session()->regenerateToken();
        return redirect()->route('todoslibros')->with('mensaje', 'Se ha borrado el usuario correctamente de la base de datos');
        
    }
    
    
    public function addlistadeseos(Request $request){
        
        if(Auth::check()){
            
            $user_id=Auth::user()->id;
            $libro_id=$request->libro_id;
            $libro_ya_en_lista=$request->lista_deseos;
            if($libro_ya_en_lista){
                $deleted = DB::table('listadeseos')
                        ->where('usuario_id', '=', $user_id)
                        ->where('libro_id','=',$libro_id)
                        ->delete();
            }else{

    //         
                DB::table('listadeseos')
                ->updateOrInsert(
                 ['usuario_id' => $user_id,'libro_id' => $libro_id]
                );
            }
        } else {
             
            return json_encode(array('mensaje'=>'Debe iniciar sesion.'));

        }
        
//        return json_encode(array('success' => 1,'libro'=>$libro_ya_en_lista));
        return json_encode(array('libro'=>$libro_ya_en_lista));

    }
    
    public function showlistadeseos(){
        

        $libros =DB::table('listadeseos')
                ->join('libro','listadeseos.libro_id','=','libro.id')
                ->join('autor','libro.autor_id','=','autor.id')
                ->select('libro.id','libro.titulo','autor.nombre as autor','libro.precio')->where('listadeseos.usuario_id',Auth::user()->id)
                ->get();
        return view('usuario.listadeseos',['libros'=>$libros]);    
        
    }
    
    public function borrarlibrolistadeseos(Request $request){
        if(Auth::check()){
            
            $user_id=Auth::user()->id;
            $libro_id=$request->id;
        
            $deleted = DB::table('listadeseos')
                   ->where('usuario_id', '=', $user_id)
                   ->where('libro_id','=',$libro_id)
                   ->delete();
            
           $libros =DB::table('listadeseos')
                ->join('libro','listadeseos.libro_id','=','libro.id')
                ->join('autor','libro.autor_id','=','autor.id')
                ->select('libro.id','libro.titulo','autor.nombre as autor','libro.precio')->where('listadeseos.usuario_id',Auth::user()->id)
                ->get();
            return view('usuario.listadeseos',['libros'=>$libros]);
        }
        
    }
    
    
    public function calificarLibro(Request $request){

        if($request->isMethod('POST')){
            
            if(Auth::check()){
    //            //           

                    DB::table('calificaciones')
                        ->updateOrInsert(
                         ['usuario_id' => Auth::user()->id,'libro_id' => $request->libro],
                         ['calificacion'=>$request->valoracion,]
                        );
    //            
                return json_encode(array('mensaje'=>'calificacion OK.'));
            }
        }
        
        if($request->isMethod('GET')){
            
            DB::table('calificaciones')->where('id', '=', $request->comentario_id)->delete();
            return redirect()->back()->with('mensaje','Se ha borrado la califacación');

        }
        
    }
//    acciones que solo puede hacer el usuario de clase admin
    public function accionesAdmin(){
        
        if(Auth::check() && Auth::user()->rol==2){
            
            
            $autoresaviso = DB::table('autor')->where('descripcion','=','NULL')->orWhere('fecha_nacimiento','=','NULL')->count();
                   
            return view('administracion.index',['avisoautor'=>$autoresaviso>0]);
//            return view('administracion.usuario',['avisoautor'=>$autoresaviso>0]);
        }else{
            return redirect()->back()->with('mensaje','No tiene permiso para entrar aqui.');
        }
    }
    
    public function showall(Request $request){
        
        if ($request->isMethod('post') && Auth::user()->rol==2)
        {
            $usuarios = DB::table('usuario')->select('*')->where('nombre','LIKE','%'.$request->busqueda_admin.'%')->orWhere('email','LIKE','%'.$request->busqueda_admin.'%')->simplePaginate(3);
        }
       
        if(Auth::check() && Auth::user()->rol==2 && $request->isMethod('get')){
               $usuarios=   DB::table('usuario')->simplePaginate(3);
        }
        if(Auth::check() && Auth::user()->rol==2){ 
            return view('administracion.usuario',['usuarios'=>$usuarios]);
        }else{
            return redirect()->back()->with('mensaje','No tiene permiso para entrar aqui.');
        }
    }
    
    public function hacerAdmin(User $user){
        $user->rol=2;
        $user->save();
        return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se ha concedido el rol de administrador al usuario');

    }
    
    
    public function enviarCorreoform(Request $request,User $user){
        
        $user = User::find($request->user_id);
//     
        return view('administracion.correo',['usuario'=>$user]);
        
    }
   
    
    public function enviarCorreo(Request $request,User $user){

        
        if(Auth::user()->rol==2){
            

            $usuario=json_decode($request->usuario);
            $body=$request->cuerpo;
            $titulo=$request->asunto;
            $emaildestinatario=$usuario->email;
            $email = new EmailController('Mensaje de SENECA Administracion',$body);
            $email->sendEmail($emaildestinatario,$titulo,$body);

            return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se ha enviado el mensaje al usuario');
      }
            return redirect()->back();

        
    }

     public function contactoCorreo(Request $request){
      
            $body=$request->cuerpo;
            $titulo=$request->asunto;
            $emaildestinatario='dawlucas1993@gmail.com';
            $email = new EmailController('Mensaje para SENECA Administracion',$body);
            $email->sendEmail($emaildestinatario,$titulo,$body);
            return redirect()->route('inicio')->with('mensaje','Correo enviado!');
    }
    public function mostrarInteracciones(Request $request){
        
        $usuario_id=intval($request->id_usuario);
        $comentarios= DB::table('comentario')->join('usuario','comentario.usuario_id','=','usuario.id')->join('libro','comentario.libro_id','=','libro.id')->select('comentario.id','comentario.comentario','comentario.libro_id','libro.titulo')->where('usuario.id','=',$request->id_usuario)->get();
        $valoraciones= DB::table('calificaciones')->join('usuario','calificaciones.usuario_id','=','usuario.id')->join('libro','calificaciones.libro_id','=','libro.id')->select('calificaciones.id','calificaciones.calificacion','calificaciones.libro_id','libro.titulo')->where('usuario.id','=',$request->id_usuario)->get();
        $compras=DB::table('compras')->join('usuario','compras.usuario_id','=','usuario.id')->select('compras.id','compras.*')->where('usuario.id','=',$request->id_usuario)->get();
        $usuario = User::find($usuario_id);
        return view('administracion.interacciones',['comentarios'=>$comentarios,'calificaciones'=>$valoraciones,'pedidos'=>$compras,'usuario'=>$usuario]);
    }
    public function verTodospedidos(){
        if(Auth::user()->rol==2){
            
        
        $compras= DB::table('compras')->join('usuario','compras.usuario_id','=','usuario.id')->select('compras.*','usuario.nombre','usuario.email')->simplePaginate(5);        
            foreach($compras as $compra){
                $librospedidos =DB::table('pedidos')->join('libro','pedidos.libro_id','=','libro.id')->select('libro.id','libro.titulo','libro.precio')->where('pedidos.compra_id','=',$compra->id)->get();
                $compra->libros=$librospedidos;
                
            }
            
            return view('administracion.pedidos',['compras'=>$compras]);
        }else{
            return redirect()->route('todoslibros')->with('mensaje', 'NO tiene permisos para ver la direccion introducida');
        }
    }
    
    
     public function busquedaAdmin(Request $request){
        
        
        if(Auth::user()->rol==2){
            
          $usuarios = DB::table('usuario')->select('*')->where('nombre','LIKE','%'.$request->busqueda.'%')->orWhere('email','LIKE','%'.$request->busqueda.'%')->get();
            
       
             $response = [
                    "success"=>true,
                    "mensaje"=>'Consulta correcta. Busqueda usuario',
                    "busqueda"=>$request->busqueda,
                    "usuarios"=>$usuarios
                     ];
//        $response(['data' => 'Error al realizar la búsqueda','respuesta'=>'respuesta a get','libros'=>$libros]);
        return response()->json($response);
        }   
        
    }
    
    public function busquedapedidoAdmin(Request $request){
        
        
            $compras= DB::table('compras')->join('users','compras.usuario_id','=','users.id')->select('compras.*','users.name','users.email')->where('compras.id','LIKE','%'.$request->busqueda.'%')->get();        
            foreach($compras as $compra){
                $librospedidos =DB::table('pedidos')->join('libro','pedidos.libro_id','=','libro.id')->select('libro.id','libro.titulo','libro.precio')->where('pedidos.compra_id','=',$compra->id)->get();
                $compra->libros=$librospedidos;
                
            }
//       
         $response = [
                    "success"=>true,
                    "mensaje"=>'Consulta correcta.Pedidos',
                    "pedidos"=>$compras,
                    "busqueda"=>$request->busqueda,
                     ];
            return response()->json($response);
    }
    
    //estadisticas libros
    public function estadisticas(){
        
        return view('administracion.estadisticas');
    }

}