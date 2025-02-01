
@extends('layouts.base')
@section('titulo','Buscar')
@section('contenido')
<form action='{{route("comentar",['comentario_id'=>$comentario->id])}}' method="post" >
     @csrf
     <!--comentario-->
     <div>
        <label for="comentario">Comentario: </label>
        <input type="text" placeholder="Comentario" id='comentario' name="comentario" value="{{$comentario->comentario}}"/>
     </div>
        
        <input type='hidden' name='libro_id' id='libro_id' value='{{$comentario->libro_id}}'/>
        <input type='hidden' name='usuario_id' id='usuario_id' value='{{$comentario->usuario_id}}'/>
        <input type="submit" value="Modificar comentario" class="boton"/>
   
 </form>
@endsection