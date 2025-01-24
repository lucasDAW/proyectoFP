@extends('layouts.base')
@section('titulo','Borrar Usuario')

@section('contenido')
    <h3>Eliminar usuario </h3>
        @if (isset($id))
            <h4 style="color: #3a0101; margin: 0 auto; margin: tex;width: 50% ;text-align: center;  padding: 5px;  border: 3px solid #8b0505;    background: #d34343;">
                Esta acción la esta realizando con rol de admnistrador</h4>
        @endif
    <h5>Se va eliminar el usuario de la base de datos, pulse en eliminar para confirmar la eliminación.</h5>      
    <form action='{{route("confirmareliminarusuario")}}' method="post" class="">
        @csrf
        @if(isset($id))
            <input type='hidden' name='id' id='id' value='{{$id}}'/>
            <input type='hidden' name='adminaccion' id='adminaccion' value='True'/>
        @else
            <input type='hidden' name='id' id='id' value='{{Auth::user()->id}}'/>
        @endif
        <input type="submit" id='eliminar' value="Eliminar Usuario" class="btn_eliminarusuario"/>  
    </form>
                        

@endsection
  
