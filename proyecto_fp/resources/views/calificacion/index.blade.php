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
        <h4>{{$valoracion->mediafloat}}</h4>
    @else
        <img data-value='1'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='2'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='3'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='4'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
        <img data-value='5'  class="rating" src='{{ asset("image/icono_libro.png") }}'/>
    @endif
  
</div>
<script>
 
// calificacion del libro
let ratings = document.querySelectorAll('.rating');
let contenedor= document.getElementById('calificaciones');
let texto = document.getElementById('output');
//  let valor=0;
  
  @if(isset($valoracion->media))valor={{$valoracion->media}}@endif
      
  
  let usuario = {{Auth::id()}};
  let libro = {{$libro->id}};
//  console.log(usuario,libro);
  
 

//  console.log(texto);
  
  contenedor.addEventListener('mouseout',(event)=>{
      ratings.forEach(r => {
          r.classList.remove("rating_valor");
          r.style.background='';
       
      });
//      console.log(valor);
        @if(isset($valoracion->media))

            for(let j =0;j<=valor-1;j++){
                 ratings[j].classList.add("rating_base");
            }
        @endif
      
  });
  
  
//  console.log(ratings);
  ratings.forEach(r => {
//      console.log(r);
    r.onclick = () => {
        let starlevel = r.getAttribute('data-value')
//        console.log(starlevel);
//        pulsar(starlevel);
        redirigir(starlevel);
            window.location.reload();
            window.location.reload();



    }
    r.onmouseover =()=>{
        let starlevel = r.getAttribute('data-value')
//        console.log(starlevel);
        pulsar(starlevel);
    }
});

function pulsar(n){
    let ratings = document.querySelectorAll('.rating');

      
    ratings.forEach(r => {
        r.classList.remove("rating_valor");
        r.classList.remove("rating_base");
        r.classList.add("rating");
     });
        
//    console.log(n);
    for(let j =0;j<=n-1;j++){
        ratings[j].style.background='#ddce15';
    }

}

function aphp(){
    const xhr = new XMLHttpRequest();
    xhr.open("GET", );
    xhr.send();
}

function redirigir(valor) {
    
    let url2 ="{{route('valorar')}}";
  //  console.log(url2);
     let url="http://localhost:8000/libro/valorar";
     const xhr = new XMLHttpRequest();
  xhr.open("POST", url2);
  xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
  var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
  xhr.setRequestHeader("X-CSRF-Token", csrf_token);
  const body = JSON.stringify({
    valoracion: valor,
    user_id:usuario,
    libro_id: libro
  });
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(JSON.parse(xhr.responseText));
    } else {
      console.log(`Error: ${xhr.status}`);
    }
  };
  xhr.send(body);
   
}

//setInterval(function() {
//    console.log("Hello");
//    window.location.reload();
//}, 1000);  
</script>
