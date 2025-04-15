@extends('layouts.base')
@section('titulo','Mostrando Autores')
@section('contenido')
            
    <div class='busqueda_autor'>
           <form method="#" onsubmit="event.preventDefault();" action="#" class="formularioBusqueda">
                @csrf
                <input type="text" placeholder="🔍 Busqueda de autor..." id="busquedaautor" name="busqueda">
            </form>
    </div>
            <div class='autores'>
                
            @if (isset($autores))

           
                    @foreach ($autores as $autor)
                        <div class='autor'>
                            <a href="{{route('verAutor',['autor'=>$autor->id])}}">
                                <h3>{{$autor->nombre}}</h3>
                                 @if (isset($autor->imagen_url))
                                <img src="{{$autor->imagen_url}}" alt='{{$autor->titulo}}'/>
                                @else
                                    <img src="{{asset("image/cabecera.webp")}}"/>
                                @endif
                                <h5>{{$autor->fecha_nacimiento}}</h5>
                            </a>
                        </div>
                       
                    @endforeach
            @endif
                    
            
        

            </div>
                   <div class="paginacion">
                        {{ $autores->links() }}
                </div>
       
 

       @endsection


