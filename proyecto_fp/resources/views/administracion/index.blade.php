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
            <li class="autores_aviso">
        <?php if (str_contains(url()->current(),'autor')):?>
                <a class='btn_administrador_pulsado' href='{{route('verAutoresAdmin')}}'>Autores</a>
        <?php else:?>
            <a href='{{route('verAutoresAdmin')}}'>Autores</a>
            @if(isset($avisoautor) and $avisoautor>0)
            <span class="aviso">!</span>
            @endif
      </li>
        <?php endif;?>
        <?php if (str_contains(url()->current(),'categoria')):?>
            <li><a class='btn_administrador_pulsado' href='{{route('verCategoriaAdmin')}}'>Categorías</a></li>
        <?php else:?>
            <li><a href='{{route('verCategoriaAdmin')}}'>Categorías</a></li>
        <?php endif;?>
        <?php if (str_contains(url()->current(),'pedidos')):?>
            <li><a class='btn_administrador_pulsado' href='{{route('verpedidosadmin')}}'>Pedidos</a></li>
        <?php else:?>
            <li><a href='{{route('verpedidosadmin')}}'>Pedidos</a></li>
        <?php endif;?>
        <?php if (str_contains(url()->current(),'estadisticas')):?>
            <li><a class='btn_administrador_pulsado' href='{{route('verestadisticasAdmin')}}'>Estadisticas</a>
        <?php else:?>
        <li><a href='{{route('verestadisticasAdmin')}}'>Estadisticas</a>
        <?php endif;?>  
            <ul class='submenu_estadisticas'>
                <li><a href="{{route('verestadisticasAdminopciones',['opcion'=>'pedidos'])}}">Libros más pedidos</a></li>
                <li><a href="{{route('verestadisticasAdminopciones',['opcion'=>'comentarios'])}}">Libros más comentados</a></li>
                <li><a href="{{route('verestadisticasAdminopciones',['opcion'=>'valoraciones'])}}">Libros más valorados</a></li>


            </ul>
        </li>
      </ul>
  </div>

  <div class='administracion_contenido'>
      @yield('accion')
  </div>
  @endsection

