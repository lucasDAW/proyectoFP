const etiqueta = document.getElementById("perfil");
const li = document.querySelector(".nombre");


const widthdiv=li.offsetWidth;
            
let iniciotext= etiqueta.text;
//            console.log(iniciotext);
etiqueta.addEventListener("mouseenter",(event) => {
      // highlight the mouseenter target
//      console.log(event.target);
//      console.log(li.offsetWidth);
      event.target.text='Mi Perfil';
      
      
        if(li.offsetWidth<widthdiv){
            li.style.width=widthdiv+'px';
        }
//              console.log('aplicando cambio'+li.offsetWidth+' ,'+widthdiv);

      // reset the color after a short delay
      setTimeout(() => {
        event.target.style.color = "";
      }, 500);
    });
etiqueta.addEventListener(
    "mouseout",
    (event) => {
//        console.log(li.offsetWidth);
      // highlight the mouseenter target
      event.target.text=iniciotext;

      // reset the color after a short delay
      setTimeout(() => {
        event.target.style.color = "";
      }, 500);
    },
    false,
);

// añadir libro a lista deseos

let iconocorazon =  document.querySelector(".listadeseos");

if (iconocorazon){
    
iconocorazon.addEventListener("click",(event) => {
    agregarlistadeseos();
    event.target.classList.toggle("marcado");    
    
  
    
});
async function agregarlistadeseos() {
    let contenidolista = false;

    if(iconocorazon.classList['value'].includes('marcado')){
    //        console.log('El libro esta en la lista de deseos');
            contenidolista=true;
    }//    
    //console.log(contenidolista);
    let libro_id= location.href.split('/')[location.href.split('/').length-1]
//    console.log(libro_id);
    //    let url2 ="{{route('valorar')}}";
//  //  console.log(url2);
     let url="http://localhost:8000/user/libro/listadeseos";
//     console.log(url);
     const xhr = new XMLHttpRequest();
      xhr.open("POST", url);
    xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");    
    var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
//   console.log(csrf_token);
    xhr.setRequestHeader("X-CSRF-Token", csrf_token);
    const body = JSON.stringify({
//    valoracion: valor,
//    user_id:usuario,
        libro_id: libro_id,
        lista_deseos: contenidolista
    });
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
//            console.log(xhr.responseText);
            json = JSON.parse(xhr.responseText);
//            console.log(json.libro);
            console.log(json);
            
           
        } else {
            console.log(`Error: ${xhr.status}`);
        }
    };
    xhr.send(body);
    if(iconocorazon.classList['value'].includes('marcado')!=true){
                mensaje();
    }     

//    setInterval(function() {
//    //    console.log("Hello");
//        window.location.reload();
//    }, 10);  



    function mensaje() {
     var popup = document.getElementById("myPopup");

     popup.classList.add("show");
     setTimeout(() => {

     popup.classList.remove("show");
   }, "1500");
}


}

}
// añadir libro a lista deseos

//carrito

let carrito = document.querySelectorAll('.carrito');

carrito.forEach((e)=>{
    
    
    e.addEventListener('click',function(event){
        event.preventDefault();
//        console.log(e);
        enlace = e.querySelector('.add-to-cart');
        enlace.innerHTML='';
        icono = e.querySelector('svg');
        console.log(icono);
        enlace.classList.add('animacion')
        icono.classList.add('mover_carro')
        setTimeout(() => {

            icono.classList.remove('mover_carro')
            enlace.classList.remove("animacion");
            enlace.innerHTML='add to cart';
//            e.children[1].innerHTML='add to cart';
        }, "1500");
    });
    
    
});

