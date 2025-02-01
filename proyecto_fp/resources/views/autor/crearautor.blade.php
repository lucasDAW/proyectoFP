@extends('layouts.base')
@section('titulo','Crear Autor')

@section('contenido')

                        
                        
      
 <form action='{{route('guardarAutor')}}' method="post"  enctype="multipart/form-data">
        @if(isset($autor))
             <legend>Modificar Autor</legend>
        @else
             <legend>Crear Autor</legend>
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
        @if(isset($autor))
            <input type="text" id='nombre' name="nombre" placeholder="Introduzca nombre..." value='{{$autor->nombre}}'>
        @else 
            <input type="text" id='nombre' name="nombre" placeholder="Introduzca nombre...">
        @endif
       
    </div>
    <div >
     <!--descripcion-->
        <label for="descripcion">Descripción: </label>
        @if(isset($autor))
            <textarea name="descripcion" id="descripcion" rows="10" cols="50" placeholder='{{$autor->descripcion}}'>{{$autor->descripcion}}</textarea>
        @else 
            <textarea name="descripcion" id="descripcion" rows="10" cols="50" placeholder='Descripción'></textarea>
        @endif


    </div> 
    
    <div> 
        <!--fecha nacimiento-->
        <label for="fecha">Fecha de Nacimiento: </label>
        @if (isset($autor))
            <input type="text" id='fecha' name="fecha" placeholder="Introduzca fecha de Nacimiento(AAAA-MM-DD)..." value='{{$autor->fecha_nacimiento}}'>
        @else
            <input type="text" id='fecha' name="fecha" fecha="Introduzca fecha de lanzamiento..." >
        @endif
        
    </div>
    <div> 
        <!--referencias-->
        <label for="referencias">Referencias: </label>
        @if (isset($autor))
            <input type="text" id='referencias' name="referencias" placeholder="Introduzca referencias..." value='{{$autor->referencias}}'>
        @else
            <input type="text" id='referencias' name="referencias" fecha="Introduzca referencias..." >
        @endif
        
    </div>
    <div> 
        <!--foto-->
        <label for="imagen">Imagen: </label>
            <input type="file" id='imagen' name="imagen"/>        
    </div>
        
        @if (isset($autor))
            <input type='hidden' name='id_autor' id='id_autor' value='{{$autor->id}}'/>
            <input type="submit" value="Modificar" class="boton"/>
        @else
        <input type="submit" value="Crear Autor" class="boton"/>
            @endif
 </form>
                        

@endsection
  

