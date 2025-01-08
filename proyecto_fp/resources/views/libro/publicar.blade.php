@extends('layouts.base')
@section('titulo','Publicar Libro')

@section('contenido')

@if (isset($libro))
        <h3>Modificar libro </h3>
@else
        <h3>Publicar libro </h3>
@endif
                   
                    <main class="mt-6">
                        
                 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif       
 <form action='{{route("publicar")}}' method="post" class="publicarLibro">
     @csrf
     <!--titulo-->
     <div>
        <label for="titulo">Titulo: </label>
       
       @if(isset($libro))
       
        <input type="text" id='titulo' name="titulo" placeholder="Introduzca titulo..." value='{{$libro->titulo}}'>
       @else 
        <input type="text" id='titulo' name="titulo" placeholder="Introduzca titulo...">
        @endif
       
     </div>
      <div style='display: flex;'>
     <!--descripcion-->
        <label for="descripcion">Descripción: </label>
<!--        <input type="text" id='descripcion' name="descripcion" placeholder="Introduzca descripción...">-->

               @if(isset($libro))
        <textarea name="descripcion" id="descripcion" rows="10" cols="50" placeholder='{{$libro->descripcion}}'>{{$libro->descripcion}}</textarea>
               @else 
        <textarea name="descripcion" id="descripcion" rows="10" cols="50" placeholder='Descripción'></textarea>
                       @endif


      </div> 
      <div> 
        <!--autor-->
        <label for="autor">Autor/es: </label>
               @if(isset($libro))

        <input type="text" id='autor' name="autor" placeholder="Introduzca autor..." value='{{$libro->autor}}'>
               @else 
        <input type="text" id='autor' name="autor" placeholder="Introduzca autor...">
                @endif
        </div>
    
     <div>
        <!--ISBN-->
        <label for="isbn">ISBN: </label>
                       @if(isset($libro))

        <input type="text" id='isbn' name="isbn" placeholder="Introduzca ISBN..." value='{{$libro->ISBN}}'>
                                      @else 

        <input type="text" id='isbn' name="isbn" placeholder="Introduzca ISBN...">
                @endif
     </div>
      <div>
     <!--numero páginas-->
        <label for="paginas">Número de páginas: </label>
        
        @if (isset($libro))
        
        <input type="text" id='paginas' name="paginas" placeholder="Introduzca número de páginas..." value='{{$libro->numero_paginas}}'>
        @else
        <input type="text" id='paginas' name="paginas" placeholder="Introduzca número de páginas...">
        @endif
     </div>
     <div> 
     <!--fecha lanzamiento-->
        <label for="fecha">Fecha de lanzamiento: </label>
        @if (isset($libro))
        <input type="date" id='fecha' name="fecha" placeholder="Introduzca fecha de lanzamiento..." value='{{$libro->fecha_lanzamiento}}'>
        @else
        <input type="date" id='fecha' name="fecha" placeholder="Introduzca fecha de lanzamiento..." >
        @endif
        
     </div>
     <div>     
        <!--Precio-->
        <label for="precio">Precio: </label>
        @if (isset($libro))
        <input type="text" id='precio' name="precio" placeholder="Introduzca precio..." value='{{$libro->precio}}'>
        @else
        <input type="text" id='precio' name="precio" placeholder="Introduzca precio...">
        @endif
     </div>
     
        @if (isset($libro))
        <input type='hidden' name='id' id='id' value='{{$libro->id}}'/>
        <input type="submit" value="Modificar" class="boton"/>
        @else
        <input type="submit" value="Publicar" class="boton"/>
        @endif
 </form>
                        
                    </main>

@endsection
  

