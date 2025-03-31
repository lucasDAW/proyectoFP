@yield('calificacion')
<!--<h5>Calificación</h5>-->
<div class="calificaciones" id='calificaciones'>
    @if ($valoracion->media)
        @php
            for( $i=1;$i<=5;$i++){
                if ($i<=$valoracion->media){ @endphp
                    <img data-value='@php echo $i @endphp'  class='rating rating_valor rating_base' src='{{asset('image/icono_libro.png')}}' />
           @php }else{ @endphp
                    <img data-value='@php echo $i @endphp'  class='rating' src='{{asset('image/icono_libro.png')}}' />
                @php }
            }
        @endphp
    @else
        <img data-value='1'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='2'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='3'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='4'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='5'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
    @endif
  
</div>
        @if (isset($valoracion->mediafloat))
<div class="calificaciones" >
    <div>
        <h5>Valoración media</h5>
        <h4>{{$valoracion->mediafloat}}</h4>
    </div>
        <div>
        @if (isset($valoracionUsuario[0]->calificacion))
        <h5>Mi Valoración</h5>
        <h4>{{$valoracionUsuario[0]->calificacion}}</h4>
        @endif
    </div>
</div>
        @endif

