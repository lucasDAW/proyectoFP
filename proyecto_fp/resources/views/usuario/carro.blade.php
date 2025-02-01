@extends('layouts.base')
@section('titulo','Cesta')
@section('contenido')
<div class="cesta">
  <h2>Cesta</h2>

@if (isset($carro))
   @if (count($carro)>0)
        <table  class="cesta_compra">
            <thead>
                <tr>  
                    <th>Libro</th>
                    <th>Cantidad</th>
                    <th>Precio por Unidad</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                    @foreach ($carro as $libro)
                            @isset($libro)
                        <tr>
                            <td>{{$libro['titulo']}} {{$libro['portada']}}</td>
                            <td class='cantidad'><a class="signo menos" href="{{route('decrementar_unidad',['id'=>$libro['id']])}}">-</a>{{$libro['cantidad']}} <a class="signo mas" href="{{route('aumentar_unidad',['id'=>$libro['id']])}}">+</a> </td>
                            <td>{{$libro['precio']}} € </td>
                            <td>{{$libro['precio']*$libro['cantidad']}} €</td>
                            <td class='accion'><a href="{{route('borrarlibro',['id'=>$libro['id']])}}">X</a></td>

                        </tr>
                            @endisset


                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total: </td>
                        <td class='cantidadtotal'>{{$total}} €</td>
                        <td></td>
                    </tr>
                        
            </tbody>
        </table>
        <div class='btns_pedido'> 
    <a href="{{route('vaciar')}}" class="btn_vaciar">Vaciar carrito</a>
   
    <a href="{{route('confirmarcompra')}}" id='btn_carro' name='btn_carro' class="btn_realizar">Realizar Pedido</a>

</div>
   @else
        <h5>La cesta se encuentra vacía.</h5>
   @endif
@else
        <h5>La cesta se encuentra vacía.</h5>
  
    
@endif
</div>  

@endsection

