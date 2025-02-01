@extends('layouts.base')
@section('titulo','Mostrando todos los libros')
@section('contenido')
            
    <div class='busqueda_libros'>
           <form method="POST" action="#" onsubmit="event.preventDefault();" class="formularioBusquedaLibros">
                @csrf
                <input type="text" placeholder="🔍 Busqueda de libro por titulo o autor..." id="busqueda" name="busqueda">
            </form>
    </div>
    <div class='libros'>
    @if (isset($libros))
            @foreach ($libros as $libro)
                <div class='libro'>
                    <a  href="{{route('detallelibro',['libro'=>$libro->id])}}">     
                        
                        <h3>{{$libro->titulo}}</h3>
                        @if (isset($libro->imagen_url))
                            <img src="{{$libro->imagen_url}}" alt='{{$libro->titulo}}'/>
                        @else
                            <img src="{{asset("image/libro_not_found.png")}}"/>
                        @endif
                        <h5>{{$libro->escritor->nombre}}</h5>
                        <span class="precio">{{ number_format($libro->precio,2,',')}} €</span>
                        <h5 class="valoracion">Valoración:{{ number_format($libro->valoracion,2,'.')}} </h5>
                        <div>
                            
                        <a href='{{route("addCarrito",['libro'=>$libro])}}'>
                                <span class="add-to-cart">
                                        <span class="cart-text">Añadir a la cesta</span>
                                        <div class="cart-icon">🛒</div>
                                </span>
                            </a>
                        </div>
                        
                     </a>    
                </div>

            @endforeach
    @endif




        </div>
        <div class="paginacion">
                {{ $libros->links() }}
        </div>

       
       @endsection


