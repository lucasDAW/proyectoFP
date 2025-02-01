
                @extends('administracion.index')

                @section('accion')
    <div class="form_busqueda_autor_admin">
        <form method="post" accion='{{route('vertodosUsuariospost')}}'>
            @csrf
            <input type="text" placeholder="🔍 Busqueda de autor por nombre..." id="busqueda_admin" name="busqueda_admin">
            
                <div class='crear_autor'>
                    <a href='{{route('crearAutor')}}'>Crear Autor</a>
                    @if(isset($autoresnull) and $autoresnull>0)
                        <div>

                        <p>Faltan Datos de algunos de los autores </p>
                            <a href='{{route('corregirAutoresAdmin')}}'>Ver</a>
                        </div>
                    @endif
                </div>
        </form>
    </div>
                
  <div>
      <table class="tabla_usuarios">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Fecha Nacimiento</th>
                  <th>Referencias</th>
                  <th></th>
                  
                  
              </tr>
          </thead>
          <tbody>
              @foreach($autores as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->nombre}}</td>
                  <td>{{$item->fecha_nacimiento}}</td>
                  <td><a href='{{$item->referencias}}'>Referencias</a></td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='{{route('verAutor',['autor'=>$item->id])}}'>Ver Autor</a>
                          <a href='{{route('crearAutor',['autor'=>$item->id])}}'>Editar</a>
                          <a href='{{route('eliminarAutor',['autor'=>$item->id])}}'>Eliminar</a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
                <div class="paginacion">
                    {{$autores->links()}}
                </div>  
  
      
  </div>
@endsection

