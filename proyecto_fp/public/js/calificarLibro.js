
let iconolibrovaloracion =  document.querySelector(".libro-calificacion .calificaciones");
if (iconolibrovaloracion){
    let calificacion = iconolibrovaloracion.querySelectorAll('img');
    let valoracionmedia=document.querySelectorAll('.libro-calificacion .calificaciones .rating_base').length;
    //cada img que contiene la calificacion
    calificacion.forEach((c)=>{
        
//        al hacer hover, pasar el boton por encima se muestra un foodo
        c.addEventListener('mouseover',(e)=>{
            e.preventDefault();
            let calihover=e.target.getAttribute('data-value');
            for(let i=0;i<calificacion.length;i++){
               if(i<calihover){
                  calificacion[i].classList.add('rating_valor');
                  calificacion[i].classList.remove('rating_base');
               }else{
                    calificacion[i].classList.remove('rating_valor');
               }
            }
            
        });
//        al salir el raton fuera elimina el marcado
        c.addEventListener('mouseout',(e)=>{
            e.preventDefault();
            for(let i=0;i<calificacion.length;i++){
                if(i<valoracionmedia){
                    calificacion[i].classList.add('rating_base');
                    calificacion[i].classList.add('rating_valor');
                }else{
                    calificacion[i].classList.remove('rating_valor');
                    
                }
            }
        });
        //pulsado de calificacion 
        c.addEventListener('click',(e)=>{
            let valorcalificacion=e.target.getAttribute('data-value');
            calificar(valorcalificacion);
        });

       
    });
    
  

    async function calificar(cali) {
//        libro id que vamos a enviar a la bbdd
        let libro_id = document.querySelector('form #libro_id').getAttribute('value');
        let url =location.origin+'/usuario/libro/valorar';
//        console.log(url);
        fetch(url,{
        method:'POST',
        body:JSON.stringify({'valoracion':cali,'libro':libro_id}),
        headers:{
            "Content-Type": 'application/json;charset=utf-8',
            "X-Requested-Width":"XMLHttpRequest",
            "X-CSRF-Token":document.head.querySelector("[name='csrf-token']").getAttribute('content')
        },
        })
        .then(response =>  {
            if(response.ok){
                return response.json();
            }
            throw new Error('HTTP error'+response+'  status'+response.status);
        })
        .then(data => {

            console.log(data);
            let contenedorcalificacion =document.querySelector('.libro-calificacion');
            let respuesta = document.createElement('p');
            respuesta.innerHTML='Su calificación ha sido enviada';
            respuesta.className='mensajecalificacion';
            contenedorcalificacion.appendChild(respuesta);
          
          
            setTimeout(()=>{   
                respuesta.classList.add('desaparecercalificacion');
                respuesta.classList.remove('mensajecalificacion');
                setTimeout(()=>{
                    respuesta.remove();
                },2000);
                location.reload();
            }, 2000);
            

        });
        
    }
       
}