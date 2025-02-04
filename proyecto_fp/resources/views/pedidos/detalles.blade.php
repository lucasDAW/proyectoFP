@extends('layouts.base')
@section('titulo','Pedidos')
@section('contenido')
<div class="pedidos">
  <h2>Confirmar Pedido</h2>
  @if (isset($carro))
  @php 
    $total = 0.0
  @endphp
 
      <table class="tabla_usuarios">
          <thead>
              <tr>
                  <th>Titulo</th>
                  <th>Cantidad</th>
                  <th>Precio €</th>
                  <th>Total € </th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach($carro as $item)
              <tr>
                  <td>{{$item['titulo']}}</td>
                  <td>{{$item['cantidad']}}</td>
                  <td>{{$item['precio']}}</td>
                  <td>{{$item['precio'] * $item['cantidad']}}</td>
                        @php $total +=   $item['precio'] * $item['cantidad'] @endphp
              </tr>
              @endforeach
              <tr><td colspan="3">Total</td><td>{{$total}}</td></tr>
          </tbody>
      </table>
  @endif
</div>


<form method='POST' action='{{route('realizarcompra')}}'>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
        @csrf
        
     <!--Nombre-->
     <div>
        <label for="nombre">Nombre: </label>
       @if(isset(Auth::user()->nombre))
        <input type="text" id='nombre' name="nombre" placeholder="Introduzca Nombre..." value='{{Auth::user()->nombre}}'>
       @else 
        <input type="text" id='nombre' name="nombre" placeholder="Introduzca Nombre...">
       @endif
     </div>
     <!--email-->
     <div>
        <label for="email">Email: </label>
       @if(isset(Auth::user()->email))
        <input type="text" id='email' name="email" placeholder="Introduzca email..." value='{{Auth::user()->email}}'>
       @else 
        <input type="text" id='email' name="email" placeholder="Introduzca email...">
       @endif
     </div>
     <!--Pais-->
     <div>
        <label for="pais">Pais: </label>
        <input type="text" id='pais' name="pais" placeholder="Introduzca pais...">
     </div>
     <!--Dirección-->
     <div>
        <label for="direccion">Dirección de envío: </label>
        <input type="text" id='calle' name="calle" placeholder="Nombre de la calle">
        <input type="text" id='domicilio' name="domicilio" placeholder="Número de domicilio">
        <input type="text" id='planta' name="planta" placeholder="Número apartamento...">
        <input type="text" id='codigopostal' name="codigopostal" placeholder="Código Postal...">
        <input type="text" id='poblacion' name="poblacion" placeholder="Población...">
     </div>
     <!--campos compra-->
     <div>
        <label for="pago">Método de pago: </label>
        <input type="text" id='numero_tarjeta' name="numero_tarjeta" placeholder="Nº Tarjeta">
        <input type="text" id='titular_tarjeta' name="titular_tarjeta" placeholder="Nombre titular">
        <input type="text" id='cvv_tarjeta' name="cvv_tarjeta" placeholder="CVV">
     </div>
         
        <input type='submit' value='Confirmar pedido' id='btn_carro' name='btn_carro' class="btn_realizar">
    </form>

@endsection
