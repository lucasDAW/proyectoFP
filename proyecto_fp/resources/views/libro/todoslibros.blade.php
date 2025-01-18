@extends('layouts.base')
@section('titulo','Mostrando todos los libros')
@section('contenido')
            <h3>Todos los libros</h3>
            
            
            <div class='libros'>
                
            @if (isset($libros))

           
                    @foreach ($libros as $libro)

                        <div class='libro'>
                            
                        <a href="/libro/detalle/{{$libro->id}}">
                            <h3>{{$libro->titulo}}</h3>
                            @if (isset($libro->portada))
                                <img src="{{$libro->portada}}"/>
                            @else
                                <img src="{{asset("image/libro_not_found.png")}}"/>
                            @endif
                            <h5>{{$libro->autor}}</h5>
                            <div class="precio">
                                <span>{{$libro->precio}} €</span>
                            </div>      
                    <!--boton añadir al carrito, este es muy importante-->
                                <a href='{{route("addCarrito",['libro'=>$libro])}}'>
                            <div class="add-to-cart">
                                    <span class="cart-text">Añadir a la cesta</span>
                                    <div class="cart-icon">
                                        🛒
                                    </div>
                            </div>
                                </a>
                               
                        </div>
                       
                    @endforeach
            
            @endif
        

            </div>
       
       
       @endsection


