
@extends('administracion.index')
@section('titulo','Panel de administración - Pedidos')

@section('accion')
    <div class="form_busqueda_pedidos_admin">
        <form method="post" accion='{{route('verPedidoAdmin')}}'>
            @csrf
            <input type="text" placeholder="🔍 Busqueda pedido por id..." id="busqueda_admin" name="busqueda_admin">
        </form>
    </div>
  <div>
      <table class='tabla_pedidos'>
          <thead>
              <tr>
                  <th>id</th>
                  <th>usuario</th>
                  <th>Total €</th>
                  <th>Fecha</th>
                  <th></th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach($compras as $item)
              <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->nombre}} | {{$item->email}}</td>
                  <td>{{$item->total_compra}}</td>
                  <td>{{$item->created_at}}</td>
                  <td>
                      <div class='accionesadmin'>
                          <span class="verdetallespedidos">Ver detalles</span>
                      </div>
                  </td>
              </tr>
              <tr class="fila_detalles"><td colspan="5">
                      <div class="detalles_compra_libros">
                          <h6>Detalles del pedido:</h6>
                          <ul>
                          @foreach($item->libros as $l)
                            <li><a href="{{route('detallelibro',['libro'=>$l->id])}}"><span>{{$l->titulo}}</span><span>{{$l->precio}} €</span></a></li>
                          @endforeach
                          </ul>
                          
                      </div>
                      
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
                <div class="paginacion">
                    {{$compras->links()}}
                </div>  
  
      
  </div>
@endsection

