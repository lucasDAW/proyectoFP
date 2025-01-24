@extends('layouts.base')
@section('titulo','Mostrando todos los libros')
@section('contenido')
            
    <div class='busqueda_libros'>
           <form method="POST" action="#" class="formularioBusqueda">
                @csrf
                <input type="text" placeholder="🔍 Busqueda de libro por titulo o autor..." id="busqueda" name="busqueda">
            </form>
    </div>
            <div class='libros'>
                
            @if (isset($libros))

           
                    @foreach ($libros as $libro)
                        <div class='libro'>
                            
                        <a href="/libros/detalle/{{$libro->id}}">
                            <h3>{{$libro->titulo}}</h3>
                            @if (isset($libro->imagen_url))
                                <img src="{{$libro->imagen_url}}" alt='{{$libro->titulo}}'/>
                            @else
                                <img src="{{asset("image/libro_not_found.png")}}"/>
                            @endif
                            <h5>{{$libro->autor}}</h5>
                            <div class="precio">
                                <span>{{ number_format($libro->precio,2,',')}} €</span>
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
                        </a>
                               
                        </div>
                       
                    @endforeach
            @endif
                    
            
        

            </div>
                <div class="paginacion">
                        {{ $libros->links() }}
                </div>
       
       
       @endsection


