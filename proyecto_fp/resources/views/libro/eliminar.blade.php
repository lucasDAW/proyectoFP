@extends('layouts.base')
@section('titulo','Borrar Libro')

@section('contenido')

@if (isset($id_libro))
        <h3>Eliminar libro </h3>
        <h6>Se va eliminar el libro de la base de datos, pulse en eliminar para confirmar la eliminación.</h6>
@endif
                   
                        
      
 <form action='{{route("confirmareliminar")}}' method="post" class="publicarLibro">
     @csrf     
        <input type='hidden' name='id' id='id' value='{{$id_libro}}'/>
        <input type="submit" id='eliminar' value="Eliminar" class="boton"/>        
 </form>
                        

@endsection
  
