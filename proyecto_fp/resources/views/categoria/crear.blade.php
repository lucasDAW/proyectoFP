@extends('layouts.base')
@section('titulo','Crear Autor')

@section('contenido')

                        
                        
      
 <form action='{{route('guardarCategoriaAdmin')}}' method="post" >
        @if (isset($categoria))
             <legend>Modificar Categoria</legend>
        @else
             <legend>Crear Categoria</legend>
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
     @csrf
     <!--nombre-->
    <div>
        <label for="nombre">Nombre: </label>
        @if(isset($categoria))
            <input type="text" id='nombre' name="nombre" placeholder="Introduzca nombre..." value='{{$categoria->nombre}}'>
        @else 
            <input type="text" id='nombre' name="nombre" placeholder="Introduzca nombre...">
        @endif
       
    </div>
   
        
        @if (isset($categoria))
            <input type='hidden' name='categoria' id='categoria' value='{{$categoria->id}}'/>
            <input type="submit" value="Modificar" class="boton"/>
        @else
        <input type="submit" value="Crear Categoria" class="boton"/>
            @endif
 </form>
                        

@endsection
  

