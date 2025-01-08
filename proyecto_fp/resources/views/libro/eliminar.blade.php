@extends('layouts.base')
@section('titulo','Publicar Libro')

@section('contenido')

@if (isset($libro))
        <h3>Eliminar libro </h3>
        <h6>Se va eliminar el libro de la base de datos, pulse en eliminar para confirmar la eliminación.</h6>
@endif
                   
                    <main class="mt-6">
                        
      
 <form action='{{route("confirmareliminar")}}' method="post" class="publicarLibro">
     @csrf
     
     
        <input type='hidden' name='id' id='id' value='{{$libro->id}}'/>
        <input type="submit" id='eliminar' value="Eliminar" class="boton"/>
       
        
        
 </form>
                        
                    </main>

@endsection
  
