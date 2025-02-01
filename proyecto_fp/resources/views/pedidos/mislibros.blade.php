@extends('layouts.base')
@section('titulo','Pedidos')
@section('contenido')
<div class="container mt-5">
  <h2>Mis Libros en Pedido {{$id_pedido}}</h2>
</div>

<div class='pedidos'>
    @if ($libros)

           
        <div class='pedidosenlace'>
            <ul>
                
        @foreach ($libros as $p)
           
            <li> <a href="/libro/detalle/{{$p->id}}">Libro: {{$p->titulo}} | Autor: {{$p->autor_nombre}}|{{$p->precio}}€</a>
                <img src='{{$p->imagen_url}}'/>
            </li>
        @endforeach
            </ul>
        </div>
    @else
        <p>No existen pedidos</p>
    @endif
</div>

                        
@endsection