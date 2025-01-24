@extends('layouts.base')
@section('titulo','Detalle Libro')

@section('contenido')

    @if (isset($libro))
    @auth
        @if (isset($autor) and $autor->existe==1 or Auth::user()->role = 'admin')
            <div class="accionesdetallelibro">

                <a href="{{route('editarlibro',['libro'=>$libro])}}" class="btn_edit">Modificar libro</a>
                <a href="{{route('borrar',['libro'=>$libro])}}" class="btn_eliminar">Eliminar libro</a>
            </div>
        @endif
    @endauth
        <div class="detalles_libro">  
                    <div class="portada">
                        @if (isset($archivo['imagen_url']))
                            <a href="{{$archivo['imagen_url']}}">
                                <img src="{{$archivo['imagen_url']}}" alt='{{$libro->titulo}}'/>
                            </a>
                        @else
                           <img src="{{asset("image/libro_not_found.png")}}"/>
                        @endif
                    </div>
                    <div>
                        <div class="titulo">
                        <p>Titulo: <span>{{$libro->titulo}}</span></p>
                        </div>
                   
                        <div class="autor">
                             <p>Autor: <span>{{$libro->autor}}</span></p>
                        </div>
                        <div class="descripcion">
                            <p>Descripción: <span>{{$libro->descripcion}}</span></p>
                        </div>
                        <div class="autor">
                             <p>Autor: <span>{{$libro->autor}}</span></p>
                        </div>
                        <div class="precio">
                            <p>Precio: <span>{{$libro->precio}} €</span></p>
                        </div>

                        <div class="carrocompra">

                        <a href='{{route("addCarrito",['libro'=>$libro])}}' style='text-decoration: none;'>
                                         <div class="add-to-cart">
                                                 <span class="cart-text">Añadir a la cesta</span>
                                                 <div class="cart-icon">🛒</div>
                                         </div>
                         </a>
                        </div>
                        @isset($archivo)
                            <a href="{{$archivo['archivo_url']}}">Ver Libro</a>
                        @endisset
                        <div class="iconodeseos">
                    @auth
                    <div class="popup">
                        @if (isset($listadeseos->existe) and $listadeseos->existe==1)
                            <span class="listadeseos marcado material-symbols-outlined">favorite</span>
                        @else
                            <span class="listadeseos  material-symbols-outlined">favorite</span>
                        @endif
                            <span class="popuptext" id="myPopup">Se ha añadido el libro a la lista de deseos!</span>
                    </div>
                    @endauth
                </div>
                    </div>
            
                
    
       <div class='valoracion'>
        
                @include('calificacion.index')
        </div>
    </div>
    @else
        <h6>No exite el libro.</h6>
    @endif
              
    <div class='comentario'>
        
        @include('comentarios.crearcomentario')
    </div>
@endsection




 
