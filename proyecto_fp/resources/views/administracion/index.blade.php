@extends('layouts.base')
@section('titulo','Panel de administración')
@section('contenido')
<h2 class="cabecera_administracion">Panel de administración</h2>
  <div class="accionesadmin enlaces">
      <ul class='administrador'>
          
        <?php if (str_contains(url()->current(),'usuarios')):?>
            <li><a class='btn_administrador_pulsado' href='{{route('vertodosUsuarios')}}'>Usuarios</a></li>
        <?php else:?>
            <li><a href='{{route('vertodosUsuarios')}}'>Usuarios</a></li>
        <?php endif;?>
        <?php if (str_contains(url()->current(),'libros')):?>
            <li><a class='btn_administrador_pulsado' href='{{route('verlibrosAdminAll')}}'>Libros</a></li>
        <?php else:?>
            <li><a href='{{route('verlibrosAdminAll')}}'>Libros</a></li>
        <?php endif;?>
        <?php if (str_contains(url()->current(),'pedidos')):?>
            <li><a class='btn_administrador_pulsado' href='{{route('verpedidosadmin')}}'>Pedidos</a></li>
        <?php else:?>
            <li><a href='{{route('verpedidosadmin')}}'>Pedidos</a></li>
        <?php endif;?>
        <li><a href='#'>Estadisticas</a></li>
      </ul>
  </div>

  <div>
      @yield('accion')
  </div>
  @endsection

