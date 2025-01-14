@extends('layouts.base')
@section('titulo','Pedidos')
@section('contenido')
<div class="container mt-5">
  <h2>Mis Libros en Pedido {{$id_pedido}}</h2>
</div>

<div class='pedidos'>
    @if ($libros)

           
        @foreach ($libros as $p)
        <div class='pedidosenlace'>
            
            <p> <a href="/libro/detalle/{{$p->id}}">Libro: {{$p->titulo}} | {{$p->autor}} |{{$p->precio}}€</a></p>
        </div>
        @endforeach
    @else
        <p>No existend pedidos</p>
    @endif
</div>

<a href="{{route('verpedidos',['id' => Auth::user()->id])}}">Volver</a>
                        
@endsection