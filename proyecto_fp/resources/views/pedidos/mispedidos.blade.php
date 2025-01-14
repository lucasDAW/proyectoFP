@extends('layouts.base')
@section('titulo','Pedidos')
@section('contenido')
<div class="container mt-5">
  <h2>Mis Pedidos</h2>
</div>

<div class='pedidos'>
    @if ($pedidos)

           
        @foreach ($pedidos as $p)
        <div class='pedidosenlace'>
            
            <p> <a href='{{route('verlibrospedido',['compra_id'=>$p->id])}}'>Número pedido: {{$p->id}} </a>Total: {{$p->total_compra}}€</p>
        </div>
        @endforeach
    @else
        <p>No existend pedidos</p>
    @endif
</div>


@endsection