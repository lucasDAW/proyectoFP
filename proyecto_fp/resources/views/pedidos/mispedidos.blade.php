@extends('layouts.base')
@section('titulo','Pedidos')
@section('contenido')
<div class="container mt-5">
  <h2>Mis Pedidos</h2>
</div>

<div class='pedidos'>
    @if ($pedidos)

        <table class='tabla_pedidos_usuario'>
          <thead>
              <tr>
                  <th>ID Pedido</th>
                  <th>Total €</th>
                  <th>Fecha</th>
                  <th></th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach($pedidos as $item)
              <tr>
                  <td>{{$item->id}}
                  <td>{{$item->total_compra}}</td>
                  <td>{{$item->created_at}}</td>
                  <td>
                      <div class='accionesadmin'>
                        <a class="verdetallespedidos" href='{{route('verlibrospedido',['compra_id'=>$item->id])}}'>
                            <span >Ver detalles</span>
                        </a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
    @else
        <p>No existend pedidos</p>
    @endif
</div>


@endsection