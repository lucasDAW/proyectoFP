//     Archivos js que utiliza la aplicación
//funcion lista deseos
import "./listadeseos.js";
//funcion calificar libro-detalleslibro
import "./calificarLibro.js";
//funcion añadir al carrito al libro
import "./agregarCarrito.js";
//funcion de administrador en ruta administrador
import "./administracion.js";
//funcion buscador
import "./buscador.js";
//funcion subida documentos
import "./subidadocumentos.js";


 window.addEventListener("load", function (event) {

    //cabecera - header al hacer scroll desaparece la imagen de cabecera y deja fijo el nav

    const headerImage = document.getElementById('header-image');
    const header = document.querySelector('.cabecera-banner');
        // Escucha el evento de scroll
    window.addEventListener('scroll', () => {
        

        if (window.scrollY > 150) {
            header.style.display = "none";
            headerImage.style.opacity = '0'; // Ocultar la imagen
            headerImage.style.pointerEvents = 'none'; // Evitar interacciones con la imagen
        } else {
            header.style.display = "block";
            headerImage.style.opacity = '1'; // Mostrar la imagen
            headerImage.style.pointerEvents = 'auto'; // Permitir interacciones con la imagen
            header.style.diplay='block';
        }
    });
//cabecera - header al hacer scroll desaparece la imagen FIN


//------------------------------------ paginacion---------------------------------------------------------------------------------
    let paginacion=document.querySelector('.paginacion nav');
    if(paginacion){
        paginacion.children[0].innerHTML ='<< Anterior';
        paginacion.children[1].innerHTML =' Siguiente >>';
    }

//paginacion---------------------------------------------------------------------------------


//--------------------etiqueta de la barra de nav que muestra el nombre del perfil------------------------------------------------
const etiqueta = document.getElementById("perfil");
const li = document.querySelector(".nombre");

if(li){
    
    const widthdiv=li.clientWidth;
    
    if(etiqueta){

        let iniciotext= etiqueta.text;
        etiqueta.addEventListener("mouseenter",(event) => {
                const widthdiv=li.clientWidth;

              event.target.text='Mi Perfil';

                if(li.offsetWidth<widthdiv){
                    li.style.width=widthdiv+'px';
                }

              setTimeout(() => {
                event.target.style.color = "";
              }, 500);
            });
        etiqueta.addEventListener(
            "mouseout",
            (event) => {
              event.target.text=iniciotext;
              setTimeout(() => {
                event.target.style.color = "";
              }, 500);
            },
            false,
        );
    }
}

//--------------------etiqueta de la barra de nav que muestra el nombre del perfil   FIN   ------------------------------------------------
        
        
    //PROCEDIMIENTO PARA EDITAR etiquesta DE USUARIO

    const botonEditar = document.querySelector(".botoneditar");
    const contenedorFormulario = document.querySelector(".miperfil");
    const editarFormulario = document.querySelector(".miperfil form");
    const textFormulario = document.querySelector(".miperfil h4");
    if(editarFormulario){
        botonEditar.querySelector('input').checked=false;

    //console.log(botonEditar.querySelector('input').checked = true);
        botonEditar.addEventListener('click',function (){
        //    console.log(contenedorFormulario);
            const ul = contenedorFormulario.querySelectorAll("ul");
            if(botonEditar.querySelector('input').checked == true){

                editarFormulario.classList.toggle('hidden');
                textFormulario.classList.toggle('hidden');
            }else{

                ul.forEach( (ule)=>{

                    ule.classList.toggle('hidden');
                });
            }
        });
    }
//    efecto imagen al hacer hover
    function efecto_imagen(){
    
    let img = document.querySelectorAll(".libro img");

    
    img.forEach((imagen)=>{
        imagen.addEventListener('mouseenter',(event)=>{
            img.forEach((i)=>{
                i.style.filter= 'blur(6px)';
            });
            event.target.style.borderRadius ='50px';
            event.target.style.filter= 'blur(0px)';
            event.target.parentNode.parentNode.querySelector('.add-to-cart').style.visibility= 'hidden';

        });

        imagen.addEventListener('mouseout',(event)=>{
            img.forEach((i)=>{
                i.style.filter= 'blur(0px)';
            });
            document.querySelector('.libro').style.filter= 'blur(0px)';
                img.forEach((i)=>{
                i.style.filter= 'blur(0px)';
            });

            imagen.style.borderRadius ='0';
            imagen.style.filter= 'blur(0px)';
             event.target.style.borderRadius ='0%';
            event.target.style.filter= 'blur(0px)';
            event.target.parentNode.parentNode.querySelector('.add-to-cart').style.visibility= 'visible';

        });

    });


    }
    efecto_imagen();
    
//    -------------------------------------------------------------------------------------
 let btn_leermas= document.querySelectorAll('.libro-detalles .btn_leermas span');
    let descripcionlibro= document.querySelector('.libro-detalles .libro-descripcion');
//    console.log(btn_leermas);
    if(descripcionlibro){
        
        let alturaDescripcion=descripcionlibro.clientHeight;
        descripcionlibro.style.height='150px';
        descripcionlibro.style.transition = "all 2s";;

        if(btn_leermas){
            btn_leermas.forEach((boton)=>{
        //            boton.style.display='inline';

                boton.addEventListener('click',(e)=>{

                    btn_leermas.forEach((boton)=>{


                        boton.style.display='inline';});
                    e.target.style.display='none';
    //                descripcionlibro.classList.toggle("mostrar_todo");
    //                console.log(btn_leermas[1]);
                    if(btn_leermas[1].style.display=='inline'){
    //                    console.log('desplegando libro');
                        descripcionlibro.style.height=alturaDescripcion+'px';
                    }else{
                        descripcionlibro.style.height='150px';

                    }


                });
            });
        }
    }
//    --------------------------------------------------------------------------------

    let botonpublicar = document.querySelector('.publicarLibro input[type="submit"]');
   // console.log(botonpublicar);
   if(botonpublicar){

       botonpublicar.addEventListener('click',(e)=>{
           botonpublicar.disabled=true;
           let mensajepublicando = document.querySelector('.publicarLibro .mensajePublicacion');
           mensajepublicando.style.display='inline'
           document.querySelector('.publicarLibro').submit();
          setTimeout(()=>{
               botonpublicar.disabled=false;
                mensajepublicando.style.display='none';

          },5000);
   //           e.submit();
       });
   }
//    ------------------------------------------------------------------------------------------
//cancelamos el submit al pulsar enter en un input text
    document.querySelectorAll('input[type=text]').forEach( node => node.addEventListener('keypress', e => {
        if(e.keyCode == 13) {
          e.preventDefault();
//          alert('boton enter pulsado');
        }
      }))
      
//   ------------------------- RESPONSIVO -------------------------
    const widthviewport = window.innerWidth;
    if(widthviewport < 700){
        
        let botonVerNavegacion = document.querySelector('.enlaces .menu-icon');
        let navegacion = document.querySelector('nav ul');
        let perfil = document.querySelector('nav ul #perfil');
        botonVerNavegacion.addEventListener('click',(e)=>{
            e.preventDefault();
            navegacion.classList.toggle('active');
            botonVerNavegacion.classList.toggle('active');
        });

        perfil.addEventListener('click',(e)=>{
            e.preventDefault();
            console.log(e.target.parentElement);
            let submenu = perfil.nextElementSibling;
            submenu.classList.toggle('submenu-active');
            
            
        });
    }
//   ------------------------- RESPONSIVO FIN -------------------------
});