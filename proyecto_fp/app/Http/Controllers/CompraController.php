<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CompraController extends Controller
{
    
    public function index(Request $request){
        
        $libros=[];
//        var_dump($request->carro);
        parse_str($request->carro,$libros);
//        var_dump($libros);
        
        if(Auth::check()){
//            var_dump(Auth::user()->id);
            
            $total_compra=0.0;
            foreach($libros as $l){
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
                foreach($libros as $l){
//                    var_dump($l['id']);
                    $insertpedidos= DB::table('pedidos')->insert([
                    'compra_id' => $id,
                    'libro_id'=>$l['id'],
                    'precio'=>$l['precio'],
                    ]);
                }
                if($insertpedidos){
//                   echo "se ha insertado el pedido en la base de datos"; 
                    $request->session()->forget('cart');
                   return view('pedidos.index');
                }
                
            }
            
            
            
        }else{
            return back()->with('mensaje','Debe iniciar sesión para realizar pedido.'); 
        }
        
    }
    
    
    
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
}
