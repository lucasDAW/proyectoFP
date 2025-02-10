@extends('layouts.base')
@section('titulo','Detalle Libro')

@section('contenido')

    @if (isset($libro))
    
    @auth
        @if (isset($autor) and ($autor->existe==1 or Auth::user()->role = 'admin'))
            <div class="accionesdetallelibro">

                <a href="{{route('editarlibro',['libro'=>$libro])}}" class="btn_edit">Modificar libro</a>
                <a href="{{route('borrar',['libro'=>$libro->id])}}" class="btn_eliminar">Eliminar libro</a>
            </div>
        @endif
    @endauth
    <div class="contenedor-libro-detalle">
        <div class="portada-libro">
            
            @if (isset($archivo['imagen_url']))
            <a class='imagen' href="{{$archivo['imagen_url']}}">
                    <img src="{{$archivo['imagen_url']}}" alt='{{$libro->titulo}}'/>
            </a>
            @else
            <a class='imagen'>
                <img src="{{asset("image/libro_not_found.png")}}"/>
            </a>
            @endif
            <div class="libro-calificacion">
                @include('calificacion.index')
            </div>
        </div>
        <div class="libro-detalles"> 
            <div class='titulo'>
                <div class="popup">
                        @if (isset($listadeseos->existe) and $listadeseos->existe==1)
                            <span class="listadeseos marcado material-symbols-outlined">favorite</span>
                        @else
                            <span class="listadeseos  material-symbols-outlined">favorite</span>
                        @endif
                            <span class="popuptext" id="myPopup">Se ha añadido el libro a la lista de deseos!</span>
                </div>
                <h2 class="libro-titulo"><span>{{$libro->titulo}}</span><span>{{$libro->precio}}€</span>
                </h2>
                                <!--añadir a lista de deseos-->
                
            </div>
            <!--agregar al carro de compra-->
            <div class="carrocompra">
                    <a href='{{route("addCarrito",['libro'=>$libro])}}' style='text-decoration: none;'>
                        <div class="add-to-cart">
                            <span class="cart-text">Añadir a la cesta</span>
                            <div class="cart-icon">🛒</div>
                        </div>
                     </a>
            </div>              
            <h4 class="libro-categoria"><a href='{{route('detalleCategoriaAdmin',['categoria'=>$categoria->id])}}'>{{$categoria->nombre}}</a></h4>
            <h3 class="libro-autor"><a href='{{route("verAutor",["autor"=>$autorlibro->id])}}'>{{$autorlibro->nombre}}</a></h3>
            <p class="libro-descripcion">{{$libro->descripcion}}</p>
            <div class="btn_leermas">
                <span>Ver más &#8595;</span>
                <span>Ver menos &#8593;</span>
            </div>
            
            
        </div>
        
    @else
    <!--esto no haría falta, se produciria un error 404-->
        <h5>El libro no existe</h5>
    @endif
        <div class="libro-comentarios">
            @include('comentarios.crearcomentario')
        </div>
    </div>
@endsection




 
