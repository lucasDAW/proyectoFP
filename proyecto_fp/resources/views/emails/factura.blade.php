<!DOCTYPE html>
<html>
    <head>
        <title>Tu Factura</title>
        <style>
            *{
                padding: 0;
                margin:0;
            }
             body {
                font-family: Arial, sans-serif;
                text-align: center;
                height: 100%;
                background-image: url("../image/banner.webp");
                backdrop-filter: blur(10px);

            }
            .factura-header {
                text-align: center;
                margin-bottom: 20px;
                background: burlywood;
                padding: 30px 0;                
            }
            .factura-header .nombre{
                text-transform: capitalize;
                font-style: italic;
            }

            
            .factura-detalles {
                margin-bottom: 20px;
                border:5px solid black;
                            text-align: left;

            }
            .factura-tabla {
                width: 100%;
                border-collapse: collapse;
                margin-top: 50px ;
               
            }
            .factura-tabla thead{
                 font-family: Arial;
                 color:white;
                 background: black;
                text-transform: uppercase;
            }
            .factura-tabla tbody{
                font-family: Helvetica;
            }            
            .factura-tabla tbody tr:nth-child(even){
                background: #d9e2e7;  
            }


            .factura-tabla  th, .factura-tabla  td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .total{
                background: greenyellow;
                padding: 10px;
                text-align: right;
                border-top: 3px double black;
                border-bottom: 3px double black;
            }
            footer{
                    background-image: url("../image/banner.webp");
                    height: 100px;

            }
        </style>
    </head>
    <body>
        <div class="factura-header">
            <h1>Hola<span class="nombre"> @isset ($usuario)
                            ,{{$usuario->nombre}}
                      @endisset
                </span>
            </h1>
            
        </div>
        <div class='factura-detalles'>
            <p>Adjuntamos la factura correspondiente a tu compra.</p>
            
        <p>Detalles:</p>
        <ul>
            <li><strong>Id de la factura:</strong>@isset($id){{$id}}@endisset</strong></li>
            <li><strong>Dirección de envío:</strong></strong>
                @isset($direccion)
                <ul>
                    <li><strong>Pais:</strong>  {{$direccion['pais']}}</li>
                    <li><strong>Calle:</strong> {{$direccion['calle']}}, {{$direccion['domicilio']}}, {{$direccion['planta']}}</li>
                    <li><strong>Población:</strong> {{$direccion['poblacion']}}</li>
                    <li><strong>Código Postal:</strong> {{$direccion['codigopostal']}}</li>
                </ul>
                @endisset
            </li>
          
        </ul>
            @php $total = 0.0 @endphp
        </div>
            <table class='factura-tabla'>
                <thead>
                    <tr>
                        <th>titulo</th>
                        <th>precio</th>
                        <th>cantidad</th>
                        <th>total</th>
                    </tr>
                </thead>
            <tbody><!-- comment -->
             @isset ($orden)
             @foreach ($orden as $libro)
                <tr>
                    <td>{{$libro['titulo']}}</td>
                    <td>{{$libro['precio']}} €</td>
                    <td>{{$libro['cantidad']}}</td>
                    <td>{{$libro['precio'] *$libro['cantidad']}} €</td>
                </tr> 
                @php $total += $libro['precio'] *$libro['cantidad'] @endphp
             
             @endforeach
             @endisset
                
                </tbody>
            </table>
                <p class='total'><strong>Total: </strong>{{number_format($total,2)}} €</strong></p>
        
        <p>¡Gracias por su compra!</p>
        <footer><h5>Seneca - Lib - Compartiendo cultura</h5></footer>
    </body>
</html>