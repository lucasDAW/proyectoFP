  @extends('administracion.index')
@section('titulo','Panel de administración - Libros')
                @section('accion')
                
    <div class="form_busqueda_libro_admin">
        <form method="post" accion='#' class='formularioBusquedaLibros'>
            @csrf
            <input type="text" placeholder="🔍 Busqueda de libro por titulo o autor..." id="busqueda_admin" name="busqueda_admin">
        </form>
    </div>
    
        <table class='tabla_libro' >
          <thead>
              <tr>
                  <th>id</th>
                  <th>titulo</th>
                  <th>autor</th>
                  <th>Fecha ingresado</th>
                  <th>Portada</th>
                  <th>Archivo </th>
                  <th></th>
                  
              </tr>
          </thead>
          <tbody class="tabla_libro_cuerpo">
              @foreach($libros as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->titulo}}</td>
                  <td>{{$item->escritor->nombre}}</td>
                  <td>{{$item->created_at}}</td>
                  <td><a href='{{$item->imagen_url}}'>Portada</a></td>
                  <td><a href='{{$item->archivo_url}}'>Archivo</a></td>
                  <td>
                      <div class='accionesadmin '>
                          
                          <a href='{{route('detallelibro',['libro'=>$item->id])}}'>Ver Libro</a>
                          <a href='{{route('editarlibro',['libro'=>$item])}}'>Modificar</a>
                          <a href='{{route('borrarlibroBBDD',['id'=>$item->id])}}'>Eliminar</a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
                <div class="paginacion">
                        {{ $libros->links() }}
                </div>  
  
      
  </div>
@endsection