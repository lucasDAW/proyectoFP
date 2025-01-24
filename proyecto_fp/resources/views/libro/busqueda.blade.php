@extends('layouts.base')
@section('titulo','Buscar')
@section('contenido')
            <h3>Buscar  libros</h3>
            <form method="POST" action="#" class="formularioBusqueda">
                @csrf
                <input type="text" placeholder="Busqueda" id="busquedapagina" name="busquedapagina">
                <!--<input type="submit" value="Buscar">-->
                
            </form>
            <p id="textobusqueda"></p>
            
            <div class='libros'>
                
            @if (isset($libros))

           
                    @foreach ($libros as $libro)

                        <div class='libro'>
                        <a href="/libro/detalle/{{$libro->id}}">
                            <h3>{{$libro->titulo}}</h3>
                            @if (isset($libro->portada))
                                <img src="{{$libro->portada}}"/>
                            @else
                                <img src="{{asset("image/libro_not_found.png")}}"/>
                            @endif
                            <h5>{{$libro->autor}}</h5>
                            <div class="precio">
                                <span>{{$libro->precio}} €</span>
                            </div>                        
                    <!--boton añadir al carrito, este es muy importante-->
                            <a href='{{route("addCarrito",['libro'=>$libro])}}' class='btn_carro'>
                                <span class="material-symbols-outlined">add_shopping_cart</span> 
                            </a>

                        </a>
                        </div>
                       
                    @endforeach
            
            @endif
        

            </div>
       
       <script>
   
      
//     ESTO LO DEJO DE UTILIZAR PORQUE NO ME CONVENCE SU FUNCIONAMIENTO
     
        
              
//        window.addEventListener('DOMContentLoaded', function(){
            var input = document.getElementById("busquedapagina");
            var log = document.getElementById("textobusqueda");
            var libros = document.body.querySelector(".libros");
            
            if(input){
                
                input.addEventListener('keyup',consulta);
            }
//            console.log(input);
            
        
           async function consulta() {
               
                let texto = input.value;
                let busqueda ={'busqueda':texto};
//                libros.innerHTML='';
//                               
//                console.log(texto);
//                console.log(document.head.querySelector("[name='csrf-token']").getAttribute('content'));
                fetch('/libros/busqueda',{
                    method:'POST',
                    body:JSON.stringify(busqueda),
                    headers:{
                        'Content-Type': 'application/json;charset=utf-8',
                        "X-Requested-Width":"XMLHttpRequest",
                        "X-CSRF-Token":document.head.querySelector("[name='csrf-token']").getAttribute('content')
                    }
                })
                .then(response =>  response.json())
                .then(data => {
//                    
//        
                    console.log(data.data);
                    console.log(data.data.length);
////                    
//                
//                
                });
//          
            }   
//        });
  
       
       </script>
       @endsection


