
@extends('layouts.base')
@section('titulo','Borrar comentario')



@section('contenido')

@if (isset($comentario))
        <!--<h3>Eliminar libro </h3>-->
                   
                        
      
 <form action='{{route("confirmareliminarcomentario",['comentario'=>$comentario])}}' method="post">
    <h6>Se va eliminar comentario de la base de datos, pulse en eliminar para confirmar la eliminación.</h6>
     @csrf
     
        <input type='hidden' name='id' id='id' value='{{$comentario}}'/>
        <input type="submit" id='eliminar' value="Eliminar Comentario" class="boton"/>
       
        
        
 </form>
@endif
                        

@endsection
