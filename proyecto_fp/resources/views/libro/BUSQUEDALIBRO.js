/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */


       
      
//     ESTO LO DEJO DE UTILIZAR PORQUE NO ME CONVENCE SU FUNCIONAMIENTO
     
        
              
        window.addEventListener('load', function(){
            alert('hoa');
            var input = document.getElementById("busquedapagina");
            var log = document.getElementById("textobusqueda");
            var libros = document.body.querySelector(".libros");
            input.addEventListener('keyup',consulta)
        
           async function consulta(e) {
                let texto = input.value;
                let busqueda ={'busqueda':texto};
                libros.innerHTML='';
                               
                console.log(texto);
//                console.log(document.head.querySelector("[name='csrf-token']").getAttribute('content'));
                fetch('/libro/busqueda',{
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
                    
        
                    console.log(data.data);
                    console.log(data.data.length);
//                    console.log(data['data']);
                    for (let i=0;i<data.data.length;i++){
                        console.log(data.data[i]);
                        
                            libros.innerHTML +=
                            
                `<div class='libro'>`+
                        `<a href='/libro/detalle/`+data.data[i].id+`'>`+
                            `<h3>`+data.data[i].titulo+`</h3>`+
                            `@if (isset($libro->portada))`+
                                `<img src="`+data.data[i].portada+`"/>`+
                            `@else`+
                                `<img src="{{asset("image/libro_not_found.png")}}"/>`+
                            `@endif`+
                            `<h5>`+data.data[i].autor+`</h5>`+
                            `<div class="precio">`+
                                `<span>`+data.data[i].precio+` €</span>`+
                            `</div>`+                        
                            `<a href="{{route('addCarrito',['libro'=>`+data.data[i].id+`])}}" class="btn_carro">`+
                                `<span class="material-symbols-outlined">add_shopping_cart</span></a>`+

                        `</a>`+
                        `</div>`                   
                    }
                
                
                });
          
            }   
        });
  