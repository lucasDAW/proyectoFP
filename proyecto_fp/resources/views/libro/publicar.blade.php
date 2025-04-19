@extends('layouts.base')
@section('titulo','Publicar Libro')

@section('contenido')

                        
<a href="{{route('mipublicaciones')}}" class="btn_mostrar_publicaciones">Mis publicaciones</a>        
                        
      
 <form action='{{route("publicar")}}' method="post" enctype="multipart/form-data" class="publicarLibro">
        @if (isset($libro))
             <legend>Modificar libro</legend>
        @else
             <legend>Publicar libro</legend>
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
     <!--titulo-->
    <div>
        <label for="titulo">Titulo: </label>
        @if(isset($libro))
            <input type="text" id='titulo' name="titulo" placeholder="Introduzca titulo..." value='{{$libro->titulo}}'>
        @else 
            <input type="text" id='titulo' name="titulo" placeholder="Introduzca titulo...">
        @endif
       
    </div>
    <div >
     <!--descripcion-->
        <label for="descripcion">Descripción: </label>
<!--        <input type="text" id='descripcion' name="descripcion" placeholder="Introduzca descripción...">-->

        @if(isset($libro))
            <textarea name="descripcion" id="descripcion" rows="10" cols="50" placeholder='{{$libro->descripcion}}'>{{$libro->descripcion}}</textarea>
        @else 
            <textarea name="descripcion" id="descripcion" rows="10" cols="50" placeholder='Descripción'></textarea>
        @endif


    </div> 
    <div class="autores-libro">

        <label for="autor">Autor:</label>
        <input type="text" id="autorbusqueda" name="autorbusqueda" placeholder="Busqueda por nombre..."/>
        <select id="autorselect" name="autorselect">
            @foreach($autores as $a)
                @if (isset($libro) && $libro->autor_id ==$a->id )
                    <option value="{{$a->id}}" selected> {{$a->nombre}}</option>
                @else
                    <option value="{{$a->id}}"> {{$a->nombre}}</option>
                @endif    
            @endforeach
        </select>
        <label for="otroautor">
        <input type="checkbox" id="otroautorcheck" name="otroautorcheck"/>Otro Autor</label>
        <div class="otroautor" >
            <h6>Gracias por ayudarnos a conocer nuevos autores</h6>
            <h6>La administración se encargara de añadirlo a la base de datos</h6>
            <label for="autor">Nombre del autor</label>
            <input type="text" id="autorlibro" name="autorlibro" placeholder="Introduzca autor..."/>
        </div>
    </div>
   
    <div> 
        <!--fecha lanzamiento-->
        <label for="fecha_lanzamiento">Fecha de lanzamiento: </label>
        @if (isset($libro))
            <input type="text" id='fecha_lanzamiento' name="fecha_lanzamiento" placeholder="Introduzca año de lanzamiento..." value='{{$libro->fecha_lanzamiento}}'>
        @else
            <input type="text" id='fecha_lanzamiento' name="fecha_lanzamiento" placeholder="Introduzca año de lanzamiento..." >
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
     <div class="categorias">     
        <!--categoría-->
        <label for="categoria">Categoría: </label>
        <select name="categoriatext" id="categoria" name="categoriatext">
            @foreach($categorias as $c)
           
                @if(isset($libro) && $c->id ==$libro->categoria_id)
                    <option value="{{$c->id}}" selected>{{$c->nombre}}</option>
                @else
                    <option value="{{$c->id}}" >{{$c->nombre}}</option>          
                @endif    
            @endforeach
        </select>
    </div>
    
     <div class="documentos">
         
        <!-- portada -->
            <div class="archivos_portada">
        <label for="portada">Añadir Portada <span>&#8595;</span> </label>
                <div>
                    <span >Arrastra archivo </span> o <button>seleccione un archivo</button>
                    <p>Archivo de imagen.</p>
<!--                    <input type="file" id="portada" name="portada" accept=".jpg, .jpeg, .png"/>-->
                    <input type="file" id="portada" name="portada"  hidden/>
                    <ul id="documentos-imagenes"></ul>
                </div>
            </div>
    
    <div><!-- archivo -->
        <div class="archivos_archivo">
        <label for="archivo">Añadir Archivo<span>&#8595;</span> </label>
                <div>
                    <span >Arrastra archivo </span> o <button>seleccione un archivo</button>
                    <p>Archivo PDF</p>
                    <input type="file" id="archivo" name="archivo" hidden/>
                    <ul id="documentos-imagenes"></ul>
                </div>
            </div>
    </div>
        
     </div>
     <div class="botones_form">
           @if (isset($libro))
                <span class='mensajePublicacion'>El libro se esta modificando...</span>
           @else
                <span class='mensajePublicacion'>El libro se esta publicando ...</span>
           @endif
        @if (isset($libro))
            <input type='hidden' name='id' id='id' value='{{$libro->id}}'/>
            <input type="submit" value="Modificar" class="boton"/>
        @else
        <input type="submit" value="Publicar" class="boton"/>
            @endif
     </div>
 </form>
                        

@endsection
  

