
@extends('administracion.index')
@section('accion')
        

    
      
            @isset($usuario)
                <h3 class="cabecera-interaccion">Mostrando las interacciones del usuario: {{$usuario->name}}   |   {{$usuario->email}}</h3>
            @endisset
  <div class='interacciones'>
      <div class='btn_interacciones'>
          <span valor='0'>Comentarios</span>
          <span valor='1'>Valoraciones</span>
          <span valor='2'>Pedidos</span>
      </div>
        @if (isset($comentarios) and count($comentarios)>0)
      <div class='comentarios'>
          <table>
          <thead>
              <tr>
                  <th>id</th>
                  <th>comentario</th>
                  <th>libro</th>
                  <th> </th>
              </tr>
          </thead>
          <tbody>
              @foreach($comentarios as $comentario)
              <tr>
                  <td>{{$comentario->id}}</td>
                  <td>{{$comentario->comentario}}</td>
                  <td>{{$comentario->titulo}}</td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='{{route('detallelibro',['libro'=>$comentario->libro_id])}}'>Ir a libro </a>
                          <a href='#'>Eliminar comentario</a>
                      </div>
                  </td>
              </tr>
              @endforeach
            </tbody>
        </table>
        
      </div>
      @endif
      <!--//valoraciones-->
      @isset($calificaciones)
      <div class='valoraciones'>
          <table>
          <thead>
              <tr>
                  <th>id</th>
                  <th>valoracion</th>
                  <th>libro</th>
                  <th> </th>
              </tr>
          </thead>
          <tbody>
              @foreach($calificaciones as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->calificacion}}</td>
                  <td>{{$item->titulo}}</td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='{{route('detallelibro',['libro'=>$item->libro_id])}}'>Ir a libro </a>
                          <a href='#'>Eliminar calificación</a>
                      </div>
                  </td>
              </tr>
              @endforeach
            </tbody>
        </table>
        
      </div>
      @endisset
      
      <!--//pedidos-->
      @isset($pedidos)
      <div class="compras">
          <table>
          <thead>
              <tr>
                  <th>id</th>
                  <th>Total pedido</th>
                  <th>fecha pedido</th>
                  <th> </th>
              </tr>
          </thead>
          <tbody>
              @foreach($pedidos as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->total_compra}} €</td>
                  <td>{{$item->created_at}}</td>
                  <td>
                      <div class='accionesadmin'>
                          <a href='{{route('verlibrospedido',['compra_id'=>$item->id])}}'>Ver pedido </a>
                      </div>
                  </td>
              </tr>
              @endforeach
            </tbody>
        </table>
        
      </div>
      @endisset
   
      
  </div>
@endsection

