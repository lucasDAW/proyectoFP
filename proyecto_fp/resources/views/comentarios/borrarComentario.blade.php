
@extends('layouts.base')
@section('titulo','Borrar comentario')



@section('contenido')

@if (isset($comentario))
        <!--<h3>Eliminar libro </h3>-->
        <h6>Se va eliminar comentario de la base de datos, pulse en eliminar para confirmar la eliminación.</h6>
@endif
                   
                    <main class="mt-6">
                        
      
 <form action='{{route("confirmareliminarcomentario")}}' method="post">
     @csrf
     
     
        <input type='hidden' name='id' id='id' value='{{$comentario->id}}'/>
        <input type='hidden' name='user_id' id='user_id' value='{{$comentario->user_id}}'/>
        <input type='hidden' name='libro_id' id='libro_id' value='{{$comentario->libro_id}}'/>
        <input type="submit" id='eliminar' value="Eliminar Comentario" class="boton"/>
       
        
        
 </form>
                        
                    </main>

@endsection
