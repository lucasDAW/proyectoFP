
                @extends('administracion.index')
@section('titulo','Panel de administración - Usuarios')

                @section('accion')
    <div class="form_busqueda_usuario_admin">
        <form method="post" accion='{{route('vertodosUsuariospost')}}'>
            @csrf
            <input type="text" placeholder="🔍 Busqueda de usuario por email o nombre..." id="busqueda_admin" name="busqueda_admin">
            
        </form>
    </div>
                
  <div>
      <table class="tabla_usuarios">
          <thead>
              <tr>
                  <th>Id</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th></th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach($usuarios as $user)
              <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->nombre}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='{{route('interaccionesUsuario',['id_usuario'=>$user->id])}}'>Ver Interacciones</a>
                          <a href='{{route('enviarcorreoadmin',['user_id'=>$user->id])}}'>Enviar Correo</a>
                          <a href='{{route('editarperfil',['id'=>$user->id])}}'>Modificar Usuario</a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
                <div class="paginacion">
                    {{$usuarios->links()}}
                </div>  
  
      
  </div>
@endsection

