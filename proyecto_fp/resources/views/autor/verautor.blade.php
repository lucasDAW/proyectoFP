@extends('layouts.base')
@section('titulo','Ver Autor ')

@section('contenido')

    <div class="contenedor-autor-detalles">
        <div class='nombre-autor'>
            @if (isset($autor))
                <a href="{{$autor->referencias}}">{{$autor->nombre}}</a>
            @endisset
        </div>
        <div class='imagen-autor'>
            @if (isset($autor->imagen_url))
                <img src="{{$autor->imagen_url}}" alt='{{$autor->nombre}}'/>
            @else
                <img src="{{asset("image/banner.webp")}}"/>
            @endif
        </div>
        <div class='fecha-autor'><p>Fecha Nacimiento</p><p>{{$autor->fecha_nacimiento}}</p></div>
        <div class='descripcion-autor'>
            <p>{{$autor->descripcion}}</p>
        </div>
        <div class="libros-autor">
            <h3>Libros del autor</h3>
            
            @foreach($autorlibros as $libro)
                <div class='libro'>
                        <a href="/libros/detalle/{{$libro->libro_id}}">
                            <h3>{{$libro->titulo}}</h3>
                            @if (isset($libro->imagen_url))
                                <img src="{{$libro->imagen_url}}" alt='{{$libro->titulo}}'/>
                            @else
                                <img src="{{asset("image/libro_not_found.png")}}"/>
                            @endif
                            <h5><a href='{{route('detalleCategoriaAdmin',['categoria'=>$libro->categoria_id])}}'>{{$libro->nombre}}</a></h5>
                        </a>
                        </div>
            @endforeach
        </div>
       
    </div>
@endsection



