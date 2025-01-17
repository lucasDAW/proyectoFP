@extends('layouts.base')
@section('titulo','Pedidos')
@section('contenido')
<div class="container mt-5">
  <h2>Confirmar Pedido</h2>
  @if (isset($carro))
  @php 
    $total = 0.0
  @endphp
  <ul>
      
    @foreach($carro as $libro)
          <li>Titulo: {{$libro['titulo']}}  |  Cantidad: {{$libro['cantidad']}}  |  Precio: {{$libro['precio']}} € | Total:  {{$libro['precio'] * $libro['cantidad']}} €</li>
      @php $total +=    $libro['precio'] * $libro['cantidad'] @endphp
    @endforeach
  </ul>  
  <h3>Total compra: {{$total}} € </h3>
  @endif
</div>


<div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
<form method='POST' action='{{route('realizarcompra')}}'>
        @csrf
        
     <!--Nombre-->
     <div>
        <label for="nombre">Nombre: </label>
       @if(isset(Auth::user()->name))
        <input type="text" id='nombre' name="nombre" placeholder="Introduzca titulo..." value='{{Auth::user()->name}}'>
       @else 
        <input type="text" id='nombre' name="nombre" placeholder="Introduzca titulo...">
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
