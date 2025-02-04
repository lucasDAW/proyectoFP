@extends('layouts.base')
@section('titulo','Mostrando libros Categoria')
@section('contenido')
            
   
                <h3 class="categoria_encabezado">{{$categoria}}</h3>
            <div class='libros'>
                
            @if (isset($libros))

                    @foreach ($libros as $libro)
                        
            <div class='libro'>
                            
                        <a href="{{route('detallelibro',['libro'=>$libro->id])}}">
                            <h3>{{$libro->titulo}}</h3>
                            @if (isset($libro->imagen_url))
                                <img src="{{$libro->imagen_url}}" alt='{{$libro->titulo}}'/>
                            @else
                                <img src="{{asset("image/libro_not_found.png")}}"/>
                            @endif
                            <h5>{{$libro->autor_nombre}}</h5>
                            <div class="precio">
                                <span>{{ number_format($libro->precio,2,',')}} €</span>
                            </div>      
                    <!--boton añadir al carrito, este es muy importante-->
                                <a href='{{route("addCarrito",['libro'=>$libro->id])}}'>
                                    <div class="add-to-cart">
                                            <span class="cart-text">Añadir a la cesta</span>
                                            <div class="cart-icon">
                                                🛒
                                            </div>
                                    </div>
                                </a>
                        </a>
                               
                        </div>
                       
                    @endforeach
            @endif
                    
            
        

            </div>
                <div class="paginacion">
                    {{$libros->links()}}
                </div>
       
       
       @endsection


