                @extends('administracion.index')
@section('titulo','Ver Categorias')
                
                @section('accion')
    
<div class='crear_autor'>
    <a href='{{route('crearCategoriaAdmin')}}'>Crear Categoria</a>
</div>
       
                
  <div>
      <table class="tabla_usuarios">
          <thead>
              <tr>
                  <th>id</th>
                  <th>nombre</th>
                  <th></th>
                  
                  
              </tr>
          </thead>
          <tbody>
              @foreach($categorias as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->nombre}}</td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='{{route('crearCategoriaAdmin',['categoria'=>$item->id])}}'>Editar</a>
                          <a href='{{route('eliminarCategoriaAdmin',['categoria'=>$item->id])}}'>Eliminar</a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
                
      
  </div>
@endsection

