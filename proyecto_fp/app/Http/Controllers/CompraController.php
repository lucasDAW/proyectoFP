<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EmailController;

class CompraController extends Controller
{
    
    
    
    
    
    public function verPedidos(Request $request){
        
//        var_dump($request->id);
        $compras= DB::table('compras')->where('user_id',$request->id)->get();
        
        if(Auth::check()){
            
            return view('pedidos.mispedidos',['pedidos'=>$compras]);
        }else{
            return back()->with('mensaje','Debe iniciar sesión para realizar pedido.');
        }

    }
    
    public function verLibrosPedido(Request $request){
        
        $libros= DB::table('pedidos')
                ->join('libros','pedidos.libro_id','=','libros.id')
                ->select('libros.*')->where('compra_id',$request->compra_id)
                ->get();
        
        if(!empty($libros)){
            return view('pedidos.mislibros',['libros'=>$libros,'id_pedido'=>$request->compra_id]);

        }else{
            return back()->with('mensaje','Debe iniciar sesión para realizar pedido.');

        }
    }
    
    public function confirmarPedido(Request $request){
        
        $carro = session()->get('cart');
        if(!$carro){
            return back();
        }
        return view('pedidos.detalles',['carro'=>$carro]);     
    }  
    
    
    public function realizarcompra(Request $request){
//        
        $reglas=[
            'nombre'=>'required|max:100',
            'email'=>'required|max:100',
            'pais'=>'required|max:100',
            'calle'=>'required|max:100',
            'domicilio'=>'required|max:100',
            'codigopostal'=>'required|size:5',
            'poblacion'=>'required|max:100',
            
        ];
        $mensajeError = [
            'required' => 'Cuidado!! el campo :attribute no se puede dejar vacío',
            'size' => 'Cuidado!! el campo :attribute debe ser numerico e igual a 5',
        ];  
        
////      si no se rellenan los campos
        $datosvalidados=$request->validate($reglas,$mensajeError);
        
        //direccion
        $direccion=[];
        $direccion['pais'] = $request->pais;
        $direccion['calle'] = $request->calle;
        $direccion['domicilio'] = $request->domicilio;
        $direccion['planta'] =$request->planta;
        $direccion['codigopostal'] = $request->codigopostal;
        $direccion['poblacion'] =$request->poblacion;
        //pago;
        $pago=[];
        $pago['numero_tarjeta']=$request->numero_tarjeta;
        $pago['nombre_titulo']=$request->titular_tarjeta;
        $pago['cvv_tarejta']=$request->cvv_tarjeta;
                
        $carro = session()->get('cart');
        
//        var_dump($direccion,$pago,$carro);

        
        if(Auth::check()){
//            var_dump(Auth::user()->id);
            
            $total_compra=0.0;
            foreach($carro as $l){
//                var_dump($l);
//                var_dump($l['precio']*$l['cantidad']);
                $total_compra +=$l['precio']*$l['cantidad'];
            }
//            var_dump($total_compra);

            $id= DB::table('compras')->insertGetId([
                'user_id' => Auth::user()->id,
                'total_compra' => $total_compra
            ]);
            if($id){//se ha guardado en la tabla de compras de la base de datos
                foreach($carro as $l){
//                    var_dump($l['id']);
                    $insertpedidos= DB::table('pedidos')->insert([
                    'compra_id' => $id,
                    'libro_id'=>$l['id'],
                    'precio'=>$l['precio'],
                    ]);
                }
                
                if($insertpedidos){
                    
//                    MAILING
//                   echo "se ha insertado el pedido en la base de datos"; 
                    
                    
                    
                    
                    $body='Su compra asciende al total de '.$total_compra.' €';
                    $email = new EmailController('Compra realizada',$body);
//                                        exit();
                    $email->sendFactura( $id,Auth::user()->name,Auth::user()->email,$direccion,$carro);
                   
                    //borra la sesion del carro de compra
                    $request->session()->forget('cart');
                    
                    return redirect()->route('todoslibros')->with('mensaje', 'Compra efectuada correctamente!! :)');
//                   return view('emails.welcome',['title'=>'compra','body'=>$body])->with('mensaje', 'Se ha enviado el correo!!');
                }
                
            }
            
            
            
        }else{
            return back()->with('mensaje','Debe iniciar sesión para realizar pedido.'); 
        }
        
    }
}
