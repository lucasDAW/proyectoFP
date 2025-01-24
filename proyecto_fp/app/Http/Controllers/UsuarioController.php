<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
        
//        var_dump($request->id);
//        var_dump($usuario);
//        exit();
//        utilizamos tambien para modificar el usuario por parte de un usuario con rol admin
            //rol de admin ==2
        
        if(Auth::user()->role==2 && $request->id){
            $usuario = User::find($request->id);
            return view('usuario.editar',['usuario'=>$usuario]);
        }
            
        
     return view('usuario.editar');
        
    }
    public function modificarperfil(Request $request){
        
//        modificando un usuario desde el panel de admin
        if($request->id_usuario && Auth::user()->role==2){
  
            $reglas=[
                  'name' => ['required', 'string', 'max:255'],
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
            $usuario->name=$request->name;
            $usuario->email=$request->email;
            $usuario->password=Hash::make($request->password);
            $usuario->save();
            
            return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se han modificado los datos del usuario correctamente');
 
        }
        if(Auth::check()){
            
            $request->validate([
                  'name' => 'required', 'string', 'max:255',
                'password' => 'required',
                'email' => 'required|unique:Users,email',
            ]);
            $usuario = User::find(Auth::user()->id);
            $usuario->name=$request->name;
            $usuario->email=$request->email;
            $usuario->password=Hash::make($request->password);
            $usuario->save();
            
            
             return view('usuario.perfil',['user'=>$usuario])->with('mensaje', 'Se han modificado los datos del usuario correctamente');
 
        }
    }
    
    public function show(User $user){
        
        $user = User::find(Auth::user()->id);
        
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
    
    public function showMispublicaciones(Request $request){
        $libros =DB::table('archivos_test')
                ->join('libros','archivos_test.id_libro','=','libros.id')
                ->select('libros.id','libros.titulo','libros.autor','libros.precio')->where('archivos_test.usuario_id',Auth::user()->id)
                ->get();
        
        return view('usuario.mipublicaciones',['libros'=>$libros]);
    }
    
  
    public function eliminar(Request $request){
       
//        eliminando desde admin
         if(Auth::user()->role==2 && $request->id_usuario){
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
    
    
    
//    acciones que solo puede hacer el usuario de clase admin
    public function accionesAdmin(){
        
        if(Auth::check() && Auth::user()->role==2){
            
            return view('administracion.index');
        }else{
            return redirect()->back()->with('mensaje','No tiene permiso para entrar aqui.');
        }
    }
    
    public function showall(Request $request){
        
        if ($request->isMethod('post') && Auth::user()->role==2)
        {
            $usuarios = DB::table('users')->select('*')->where('name','LIKE','%'.$request->busqueda_admin.'%')->orWhere('email','LIKE','%'.$request->busqueda_admin.'%')->simplePaginate(3);
        }
       
        if(Auth::check() && Auth::user()->role==2 && $request->isMethod('get')){
               $usuarios=   DB::table('users')->simplePaginate(3);
        }
        if(Auth::check() && Auth::user()->role==2){ 
            return view('administracion.usuario',['usuarios'=>$usuarios]);
        }else{
            return redirect()->back()->with('mensaje','No tiene permiso para entrar aqui.');
        }
    }
    
    public function hacerAdmin(User $user){
        $user->role=2;
        $user->save();
        return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se ha concedido el rol de administrador al usuario');

    }
    
    
    public function enviarCorreoform(Request $request,User $user){
        
        $user = User::find($request->user_id);
//     
        return view('administracion.correo',['usuario'=>$user]);
        
    }
    
    public function enviarCorreo(Request $request,User $user){


        $usuario=json_decode($request->usuario);

        
         $body=$request->cuerpo;
         $titulo=$request->asunto;
         $emaildestinatario=$usuario->email;
        $email = new EmailController('Mensaje de SENECA Administracion',$body);
        $email->sendEmail($emaildestinatario,$titulo,$body);
        
       return redirect()->route('vertodosUsuarios')->with('mensaje', 'Se ha enviado el mensaje al usuario');

        
    }

    public function mostrarInteracciones(Request $request){
        
        $usuario_id=intval($request->id_usuario);
        $comentarios= DB::table('comentarios')->join('users','comentarios.user_id','=','users.id')->join('libros','comentarios.libro_id','=','libros.id')->select('comentarios.id','comentarios.comentario','comentarios.libro_id','libros.titulo')->where('users.id','=',$request->id_usuario)->get();
        $valoraciones= DB::table('calificaciones')->join('users','calificaciones.user_id','=','users.id')->join('libros','calificaciones.libro_id','=','libros.id')->select('calificaciones.id','calificaciones.calificacion','calificaciones.libro_id','libros.titulo')->where('users.id','=',$request->id_usuario)->get();
        $compras=DB::table('compras')->join('users','compras.user_id','=','users.id')->select('compras.id','compras.*')->where('users.id','=',$request->id_usuario)->get();
        $usuario = User::find($usuario_id);
        return view('administracion.interacciones',['comentarios'=>$comentarios,'calificaciones'=>$valoraciones,'pedidos'=>$compras,'usuario'=>$usuario]);
    }
    public function verTodospedidos(){
        if(Auth::user()->role==2){
            
        
        $compras= DB::table('compras')->join('users','compras.user_id','=','users.id')->select('compras.*','users.name','users.email')->simplePaginate(5);        
            foreach($compras as $compra){
                $librospedidos =DB::table('pedidos')->join('libros','pedidos.libro_id','=','libros.id')->select('libros.id','libros.titulo','libros.precio')->where('pedidos.compra_id','=',$compra->id)->get();
                $compra->libros=$librospedidos;
                
            }
            
            return view('administracion.pedidos',['compras'=>$compras]);
        }else{
            return redirect()->route('todoslibros')->with('mensaje', 'NO tiene permisos para ver la direccion introducida');
        }
    }
    
    
     public function busquedaAdmin(Request $request){
        
        
        if(Auth::user()->role==2){
            
          $usuarios = DB::table('users')->select('*')->where('name','LIKE','%'.$request->busqueda.'%')->orWhere('email','LIKE','%'.$request->busqueda.'%')->get();
            
       
            return view('administracion.usuariobusqueda',['$usuarios'=>$usuarios]);
        }   
        
    }
    
    public function busquedapedidoAdmin(Request $request){
        
        
            $compras= DB::table('compras')->join('users','compras.user_id','=','users.id')->select('compras.*','users.name','users.email')->where('compras.id','LIKE','%'.$request->busqueda.'%')->get();        
            foreach($compras as $compra){
                $librospedidos =DB::table('pedidos')->join('libros','pedidos.libro_id','=','libros.id')->select('libros.id','libros.titulo','libros.precio')->where('pedidos.compra_id','=',$compra->id)->get();
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
}