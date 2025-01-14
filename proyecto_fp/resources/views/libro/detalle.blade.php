@extends('layouts.base')
@section('titulo','Detalle Libro')

@section('contenido')


                        
    @if (isset($libro))
        <h3>Detalles libro </h3>
        <div class="detalles_libro">               
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
        </div>
    @else
        <h6>No exite el libro.</h6>
    @endif
                       
    <div class='valoracion'>
        
        @include('calificacion.index')
    </div>    
    <div class='comentario'>
        
        @include('comentarios.crearcomentario')
    </div>
@endsection




 
