<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;

class CarritoController extends Controller
{
    
    public function showTabla(){
        $cart = session()->get('cart');
        $total=0;
        
      if(!empty($cart)){
          
        foreach($cart as $libro){
            $total += $libro['precio']*$libro['cantidad'];
        }
      }
        
        
        return view('usuario.carro',['carro'=>$cart,'total'=>$total]);
    }
    public function add(Request $request, Libro $libro){
        
        
        $cart =session()->get('cart');
        
        if(!$cart){
            $cart = [
                $libro->id=>[
                    'id'=>$libro->id,
                    'titulo'=>$libro->titulo,
                    'precio'=>$libro->precio,
                    'portada'=>'portada',
                    'cantidad'=>1
                ]
            ];
            
            session()->put('cart',$cart);
            
            return back()->with(['mensaje'=>'Libro añadido a la cesta']);
        }
        if(isset($cart[$libro->id])){
            $cart[$libro->id]['cantidad']++;
            session()->put('cart',$cart);
            return back()->with(['mensaje'=>'Se ha aumentado en una unidad el libro de la cesta.']);

        }
        $cart[$libro->id]=[
                    'id'=>$libro->id,
                    'titulo'=>$libro->titulo,
                    'precio'=>$libro->precio,
                    'portada'=>'portada',
                    'cantidad'=>1
        ];
        
        session()->put('cart',$cart);
        
        if(request()->wantsJson()){
            return response()->json(['mensaje'=>'Producto añadido']);
        }
        
        return back()->with(['mensaje'=>'Libro añadido a la cesta.']);

       
    }
    
    public function borrarProducto(Request $request){
        if($request->id){
            $cart = session()->get('cart');
            if(isset($cart[$request->id])){
                unset($cart[$request->id]);
                session()->put('cart',$cart);
            }
            session()->flash('sucess','Producto eliminado');
        }
    }
    
    public function eliminarlibro(Request $request){
                
        $cart = session()->get('cart');

        if($request->id){
            $cart = session()->get('cart');
            if(isset($cart[$request->id])){
                unset($cart[$request->id]);
                session()->put('cart',$cart);
            }
            session()->flash('sucess','Producto eliminado');
        }
                 return back();

    }
    
    public function vaciarcarrito(Request $request){
        
//        
//        var_dump($request);
////        exit();
        $request->session()->forget('cart');
        
        return view('usuario.carro');

        
    }
    
    public function showProduct(){
        $cart = session()->get('cart');

        var_dump($cart);
        return view('usuario.carro', compact('cart'));
        
    }
    
    public function aumentar(Request $request){
        
        
        $cart =session()->get('cart');
        if($cart[strval($request->id)] and $cart[strval($request->id) ]['cantidad']<=10 ){
            $cart[strval($request->id) ]['cantidad']++;
        }
        var_dump($cart);
        session()->put('cart',$cart);

//        return view('usuario.carro',['carro'=>$cart]);    
                 return back();

    }
    
    
    public function descrementar(Request $request){
        $cart =session()->get('cart');
        if($cart[strval($request->id)]){
            if ($cart[strval($request->id) ]['cantidad']>1){
                
//                $cart = array_diff($cart,$cart[strval($request->id)]);
                $cart[strval($request->id) ]['cantidad']--;
            }else{
                unset($cart[$request->id]) ;               
            }
        }
//        var_dump($cart);
        session()->put('cart',$cart);

         return back();
    }
}
