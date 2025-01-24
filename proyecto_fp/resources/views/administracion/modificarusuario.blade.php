@extends('layouts.base')
@section('titulo','Panel de administración')
@section('contenido')
<div>
    
  
  
  <div class="accionesadmin enlaces">
      <h2>Panel de administración</h2>
      <ul class='administrador'>
        <li><a href='#'>Usuarios</a></li>
        <li><a href='#'>Libros</a></li>
        <li><a href='#'>Estadisticas</a></li>
      </ul>
  </div>
  <div>
      
      <table>
          <thead>
              <tr>
                  <th>id</th>
                  <th>nombre</th>
                  <th>email</th>
                  <th>acciones</th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach($usuarios as $user)
              <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='#'>Ver Interacciones</a>
                          <a href='#'>Enviar Correo</a>
                          <a href='{{route('adminmodificarUsuario'['id'=>$user->id])}}'>Modificar Usuario</a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
                <div class="paginacion">
                        {{ $usuarios->links() }}
                </div>  </div>

</div>


@endsection

