@extends('layouts.base')
@section('titulo','Publicar Libro')

@section('contenido')

                    <main class="mt-6">
                        
                        
@if (isset($libro))
        <h3>Modificar libro </h3>
@else
        <h3>Publicar libro </h3>
@endif
                   
                        
                 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif       
    <form action='{{route("almacenandoarchivo")}}' method="post" enctype="multipart/form-data" class="archivo">
        @csrf
        <!--titulo-->
        <div>
           <label for="titulo">Titulo: </label>


           <input type="text" id='titulo' name="titulo" placeholder="Introduzca titulo...">


        </div>
        <div>     
           <!--Precio-->
           <label for="precio">Precio: </label>
           <input type="text" id='precio' name="precio" placeholder="Introduzca precio..." >
        </div>
        <div>        
            <label for="portada">Portada: </label>
            <input type="file" id="portada" name="portada" accept=".jpg, .jpeg, .png"/>
        </div>
        <div>        
            <label for="archivo">Archivo: </label>
            <input type="file" id="archivo" name="archivo" accept='.pdf'/>
        </div>
           <input type="submit" value="SUBIR" class="boton"/>
    </form>
                        



                 
<form action='{{route("descargar")}}' method="post" class="archivo">
        @csrf
        <!--titulo-->
        <div>
           <label for="titulo">Titulo: </label>
           <input type="text" id='titulo' name="titulo" placeholder="Introduzca titulo...">
        </div>
        <div>
            <select name="tituloLibro" id='tituloLibro'>
                @foreach ($libros as $libro)
                    <option value="{{$libro->id}}">{{$libro->titulo}}</option>
                @endforeach
            </select>
            
        </div>
        
           <input type="submit" value="BAJAR" class="boton"/>
    </form>

    <h4>LIBROS BBDD</h4>
<div style="display: flex;    flex-direction: row;    justify-content: space-around;    background: antiquewhite;">
    @foreach ($libros as $libro)
    <div style="display: flex;    flex-direction: column; border:2px solid coral; padding:50px 20px; align-items:center;" >
                      
            <h3>{{$libro->titulo}}</h3> <a href="/libro/detalle/{{$libro->id}}">
            @if (isset($libro->imagen_url))
                <img src="{{$libro->imagen_url}}" alt='{{$libro->titulo}}' width='50px' height='100px'/>
            @else
                <img src="{{asset("image/libro_not_found.png")}}" alt='{{$libro->titulo}}' width='50px' height='100px'/>
            @endif
            </a>
        <a href="{{$libro->archivo_url}}" target="_blank">Leer Online</a>                
        <a href="{{$libro->archivo_url}}" download='{{$libro->titulo}}'>Descargar</a>  
    </div>
    @endforeach
</div>
    <form method="POST" action="{{route('facturaorden')}}">
        @csrf
        <!--la orden 37 contiene 2 libros, mi vida en la rulas (12.5) y Espejos rotos (22.99) ->35.49 -->
        <input type="hidden" id="compra_id" name="compra_id" value="37"/>
    <input type="submit" value="Comprar - Orden - Email"/>
    </form>

</main>

@endsection
  

