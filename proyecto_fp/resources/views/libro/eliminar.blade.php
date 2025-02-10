@extends('layouts.base')
@section('titulo','Borrar Libro')

@section('contenido')

 <form action='{{route("confirmareliminar")}}' method="post">
     @csrf     
    @if (isset($libro))
            @if(Auth::user()->role==2)
                <h6>Tienes el rol de admin </h6>
            @endif
            <h3>Eliminar libro </h3>
            <h4>Se va eliminar el libro de la base de datos, pulse en eliminar para confirmar la eliminación.</h4>
    @endif

                        
      
        <input type='hidden' name='id' id='id' value='{{$libro}}'/>
        <input type="submit" id='eliminar' value="Eliminar" class="boton"/>        
 </form>
                        

@endsection
  
