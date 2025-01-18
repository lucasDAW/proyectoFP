@extends('layouts.base')
@section('titulo','Detalle Libro')

@section('contenido')


                        
    @if (isset($libro))
        <h3>Detalles libro </h3>
        <div class="detalles_libro">  
            <div class="portada">
                                 @if (isset($libro->portada))
                                <img src="{{$libro->portada}}"/>
                            @else
                                <img src="{{asset("image/libro_not_found.png")}}"/>
                            @endif
                            </div>
            <div class="titulo">
                <p>Titulo: <span>{{$libro->titulo}}</span></p>
            </div>
            <div class="autor">
                 <p>Autor: <span>{{$libro->autor}}</span></p>
            </div>
            <div class="descripcion">
                <p>Descripción: <span>{{$libro->descripcion}}</span></p>
            </div>
            <div class="isbn">
                <p>ISBN: <span>{{$libro->ISBN}}</span></p>
            </div>
            <div class="precio">
                <p>Precio: <span>{{$libro->precio}} €</span></p>
            </div>
            
           <a href='{{route("addCarrito",['libro'=>$libro])}}' style='text-decoration: none;'>
                            <div class="add-to-cart">
                                    <span class="cart-text">Añadir a la cesta</span>
                                    <div class="cart-icon">
                                        🛒
                                    </div>
                            </div>
                                </a>
        </div>
    @else
        <h6>No exite el libro.</h6>
    @endif
           <div class="">
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
    <div class='valoracion'>
        
        @include('calificacion.index')
    </div>
       
    <div class='comentario'>
        
        @include('comentarios.crearcomentario')
    </div>
@endsection




 
