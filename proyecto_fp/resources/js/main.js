window.addEventListener('load', function(){




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
//------------------------------------ paginacion FIN---------------------------------------------------------------------------------

//--------------------etiqueta de la barra de nav que muestra el nombre del perfil------------------------------------------------
const etiqueta = document.getElementById("perfil");
const li = document.querySelector(".nombre");

if(li){
    
    const widthdiv=li.clientWidth;
    
    if(etiqueta){

        let iniciotext= etiqueta.text;

    //            console.log(iniciotext);
        etiqueta.addEventListener("mouseenter",(event) => {
                const widthdiv=li.clientWidth;

              event.target.text='Mi Perfil';
    //          etiqueta.style.width=widthdiv+'px';

    //            const widthdiv=li.offsetWidth;
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
    }
}

//--------------------etiqueta de la barra de nav que muestra el nombre del perfil   FIN   ------------------------------------------------
//
//
// -------------------------------------------------añadir libro a lista deseos-------------------------------------------------

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
         let url=location.origin+"/user/libro/listadeseos";
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
                json = JSON.parse(xhr.responseText);
 

            } else {
                console.log(`Error: ${xhr.status}`);
            }
        };
        xhr.send(body);
        if(iconocorazon.classList['value'].includes('marcado')!=true){
                    mensaje();
        }     

        function mensaje() {
            var popup = document.getElementById("myPopup");

            popup.classList.add("show");
            setTimeout(() => {
                popup.classList.remove("show");
            }, "1500");
        }


    }

}
// //----------------------------------añadir libro a lista deseos  FIN-------------------------------------------------------------
//----------------------------------  Calificar Libro ---------------------------------

let iconolibrovaloracion =  document.querySelector(".libro-calificacion .calificaciones");
if (iconolibrovaloracion){
    let calificacion = iconolibrovaloracion.querySelectorAll('img');
    let valoracionmedia=document.querySelectorAll('.libro-calificacion .calificaciones .rating_base').length;
    console.log(valoracionmedia.length);
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
            respuesta.innerHTML='Su calificacion ha sido enviada';
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




//----------------------------------  Calificar Libro FIN ---------------------------------

//---------------------------------- añadir libro a carrito ----------------------------------

let carrito = document.querySelectorAll('.carrito');

carrito.forEach((e)=>{
    
    
    e.addEventListener('click',function(event){
        event.preventDefault();
        enlace = e.querySelector('.add-to-cart');
        enlace.innerHTML='';
        icono = e.querySelector('svg');
//        console.log(icono);
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
//---------------------------------- añadir libro a carrito ----------------------------------
 
// calificacion del libro
let ratings = document.querySelectorAll('.rating');
let contenedor= document.getElementById('calificaciones');
let texto = document.getElementById('output');

//---------------------------------- añadir libro a carrito ----------------------------------


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

//PROCEDIMIENTO PARA EDITAR etiquesta DE USUARIO FIN

//+++++++++++++++++++++++++efecto difuminar cuando se hace hover sobre la imagen +++++++++++++++++++++++++++++++++++++++++++++++++++

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
//+++++++++++++++++++++++++ FIN efecto libros al hacer hover+++++++++++++++++

// +++++++++++++++++++++++++aqui va el buscador de libros de la pagina principal

            let formuariobusquedalibros =document.querySelector('.formularioBusquedaLibros');
            if(formuariobusquedalibros){
                
                var input = formuariobusquedalibros.querySelector("#busqueda");
            }
            if(input){
                input.addEventListener('keyup',
                (event)=>{
                    event.preventDefault();
                    setTimeout(()=>{
                        
                    consultalibro();
                    },1000);
                });
            }
     async function consultalibro() {
//         elimino los contenedores de los libros para mostrar otros
            var libros = document.body.querySelectorAll(".libro");
//            console.log(libros.length);
            var contenedorGrande = document.body.querySelector(".libros");
            
            libros.forEach((li)=>{
                li.remove();
            });
           
                let campobusqueda = input.value;
               
                let busqueda ={'busqueda':campobusqueda};
                let url= location.origin;
//                fetch('/libros/busqueda',{
                fetch(url+'/usuario/administracion/libros/busqueda',{
                    method:'POST',
//                    body:busqueda,
                    body:JSON.stringify({'busqueda':campobusqueda}),
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
                    throw new Error('HTTP error  status'+response.status);
                })
                .then(data => {

                    libros=data.libros;
//                    console.log(libros.length);
                    
                    libros.forEach((l)=>{
//                      creamos el contenedor div de cada elemento que muestra los libros
                        var contenedor = document.createElement("div");
                        var contenedorenlace = document.createElement("a");
                        var titulo = document.createElement("h3");
                        var imagen = document.createElement("img");
                        var autor = document.createElement("h5");
                        var contenedorprecio = document.createElement("div");
                        var contenedorpreciospan = document.createElement("span");
                        var contenedorcarro = document.createElement("a");
                        var enlacecarro = document.createElement("div");
                        var spancarro = document.createElement("span");
                        var iconocarro = document.createElement("div");
                        
                        if(l.imagen_url){
                            imagen.setAttribute('src',l.imagen_url);
                        }else{
                            imagen.setAttribute('src',location.origin+'/image/libro_not_found.png');
       ////                     
                        }
                        imagen.setAttribute('alt',l.titulo);

                        autor.innerHTML=l.autor;    
                            
                        contenedorpreciospan.innerHTML=l.precio+' €';
                        contenedorprecio.appendChild(contenedorpreciospan);
                        contenedorprecio.className='precio';
                        
                        enlacecarro.className='add-to-cart';
                        contenedorcarro.appendChild(enlacecarro);
                        contenedorcarro.setAttribute('style', 'text-decoration: none;');
                        contenedorcarro.setAttribute('href', location.origin+'/carrito/'+l.id);
                        spancarro.innerHTML='Añadir a la cesta';
                        spancarro.className='cart-text';
                        enlacecarro.appendChild(spancarro);
                        iconocarro.innerHTML= '🛒';
                        iconocarro.className='cart-icon';
                        enlacecarro.appendChild(iconocarro);
                        
                        titulo.innerHTML = l.titulo;
                        contenedorenlace.append(titulo);
                        contenedorenlace.append(imagen);
                        contenedorenlace.append(autor);
                        contenedorenlace.append(contenedorprecio);
                        contenedorenlace.append(contenedorcarro);
                        contenedorenlace.setAttribute('href', location.origin+'/libros/detalle/'+l.id);
                        contenedor.appendChild(contenedorenlace);
//                      
                        contenedor.className ='libro';
                        contenedorGrande.appendChild(contenedor);
                        
                            
                           
                    });
                })
                .catch(error =>console.log('Error:'+error));  
            }      
            
            efecto_imagen();
});
  

// +++++++++++++++++++++++++ FIN   aqui va el buscador de libros de la pagina principal
// +++++++++++++++++++++++++AMPLIAR LA DESCRIPCION DE DETALLES DE LIBROS 

window.addEventListener('load',function(){
    
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
});
// +++++++++++++++++++++++++AMPLIAR LA DESCRIPCION DE DETALLES DE LIBROS FIN 
// Detalles del usuario que ve el admin en panel de administracion+++++++++++++++++++++++++++++++++++++++
// 
let botones = document.querySelectorAll('.interacciones .btn_interacciones span');

if(botones){
    
//    tablas que muestran la información
    let tablasusuariocomentarios = document.querySelector('.interacciones .comentarios');
    let tablasusuariovaloraciones = document.querySelector('.interacciones .valoraciones');
    let tablasusuariopedidos = document.querySelector('.interacciones .pedidos');
    let arraytablas=[];
    if(tablasusuariopedidos && tablasusuariovaloraciones && tablasusuariopedidos){
        
        arraytablas.push(tablasusuariocomentarios);
        arraytablas.push(tablasusuariovaloraciones);
        arraytablas.push(tablasusuariopedidos);
        tablasusuariopedidos.classList.add("ocultar_tabla");
        tablasusuariovaloraciones.classList.add("ocultar_tabla");
        botones[0].classList.add("btn_pulsado");
        botones.forEach((b)=>{

                b.addEventListener('click',(e)=>{
                    e.preventDefault();
                    botones.forEach((b)=>{
                        b.classList.remove("btn_pulsado");
                    });
                    e.target.classList.add("btn_pulsado");

                    let btn_pulsado=e.target.getAttribute('valor');
                    for(let i =0;i<arraytablas.length;i++){
                        if(i==btn_pulsado){
                            arraytablas[i].classList.remove("ocultar_tabla");
                        }else{
                            arraytablas[i].classList.add("ocultar_tabla");
                        }
                    }

            });
        });
    }
}
//+++++++++++++++++++++++++ Detalles del usuario que ve el admin en panel de administracion FIN 


//+++++++++++++++++++++++++ detalles de la tabla pedidos - boton ver mas detalles 

let botonvedetalles = document.querySelectorAll('table tbody tr td .accionesadmin .verdetallespedidos');
if(botonvedetalles){
    
    botonvedetalles.forEach((botondetalles)=>{
        
        botondetalles.addEventListener('click',(event)=>{
            
            let filalibrosdetalles = event.target.parentNode.parentNode.parentNode.nextElementSibling;
            filalibrosdetalles.firstChild.classList.toggle('vermasdetalles');            
        });
    });
}

//+++++++++++++++++++++++++detalles de la tabla pedidos - boton ver mas detalles FIN

//+++++++++++++++++++++++++busqueda de libro por parte del admin----------------------------------------------------------------------------
let formbusquedaadmin = document.querySelector('.formularioBusquedaLibros');
if(formbusquedaadmin){
    let busquedaadmin = formbusquedaadmin.querySelector('#busqueda_admin');
    if(busquedaadmin){
                    
            busquedaadmin.addEventListener('keyup',(event)=>{

                consultaadminlibros(event.target.value);
            });

            async function consultaadminlibros(busqueda) {
                //borramos paginacion
                let pagination = document.querySelector('.paginacion');
                pagination ? pagination.remove():'';

//            let busquedatitulo= busquedaadmin.value;
//            let busqueda ={'busqueda':busquedatitulo};
            let url= location.origin;
            fetch(url+'/usuario/administracion/libros/busqueda',{
                method:'POST',
//                    body:busqueda,
                body:JSON.stringify({'busqueda':busqueda}),
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
                throw new Error('HTTP error  status'+response.status);
            })
            .then(data => {

                let tablalibros = document.querySelector('.tabla_libro');
                let tablalibroscuerpo = document.querySelector('.tabla_libro_cuerpo');
                tablalibroscuerpo.remove(); 
                let cuerpotabla = document.createElement('tbody');
                cuerpotabla.className='tabla_libro_cuerpo';


                var librosbbdd= data.libros;
                    console.log(librosbbdd);
                librosbbdd.forEach((l)=>{
                    let filatr = document.createElement('tr');
                    let celdatd1= document.createElement('td')
                    let celdatd2= document.createElement('td')
                    let celdatd3= document.createElement('td')
                    let celdatd4= document.createElement('td')
                    let celdatd5= document.createElement('td')
                    let celdatd6= document.createElement('td')
                    let celdatd7= document.createElement('td')
                    celdatd1.innerHTML= l.id;
                    celdatd2.innerHTML= l.titulo;
                    celdatd3.innerHTML= l.autor_nombre;
                    celdatd4.innerHTML= l.created_at;

                    let aportada= document.createElement('a')
                    aportada.setAttribute('href', l.imagen_url);
                    aportada.innerHTML= 'Portada';
                    celdatd5.appendChild(aportada);
                    let aarchivo= document.createElement('a')
                    aarchivo.setAttribute('href', l.archivo_url);
                    aarchivo.innerHTML= 'Archivo';
                    celdatd6.appendChild(aarchivo);
                    let contenedorbotones = document.createElement('div');
                        contenedorbotones.className='accionesadmin';

                    let ver = document.createElement('a');
                    let modificar = document.createElement('a');
                    let eliminar = document.createElement('a');

                    ver.innerHTML='Ver Libro';
                    ver.setAttribute('href', location.origin+'/libros/detalle/'+l.id);

                    modificar.innerHTML='Modificar';
                    modificar.setAttribute('href', location.origin+'/libro/editar/'+l.id);
                    eliminar.innerHTML='Eliminar';
                    eliminar.setAttribute('href', location.origin+'/libro/borrar/'+l.id);


                    contenedorbotones.appendChild(ver);
                    contenedorbotones.appendChild(modificar);
                    contenedorbotones.appendChild(eliminar);


                    filatr.appendChild(celdatd1);
                    filatr.appendChild(celdatd2);
                    filatr.appendChild(celdatd3);
                    filatr.appendChild(celdatd4);
                    filatr.appendChild(celdatd5);
                    filatr.appendChild(celdatd6);
                    celdatd7.appendChild(contenedorbotones);
                    filatr.appendChild(celdatd7);

                    cuerpotabla.appendChild(filatr);

                });
                tablalibros.appendChild(cuerpotabla);


                let pagination = document.querySelector('.paginacion');
                pagination ? pagination.remove():'';

            });
        }
    }
}
//+++++++++++++++++++++++++busqueda de libro por parte del admin FIN ---------------------------------------------------------
//---------------------------------------------------------busqueda de pedido por parte del admin  ---------------------------------------------------------
window.addEventListener('load',function(){
    
let formulariobqdpedido = document.querySelector('.form_busqueda_pedidos_admin form');
if(formulariobqdpedido){

    let busquedaadmin = formulariobqdpedido.querySelector('#busqueda_admin');
    if(busquedaadmin){
                    
                busquedaadmin.addEventListener('keyup',(event)=>{
                    
                    consultaadminpedido();
                });
                
                async function consultaadminpedido() {
                    //borramos paginacion
                    let pagination = document.querySelector('.paginacion');
                    pagination ? pagination.remove():'';
//                    console.log(busquedaadmin.value);
                  fetch('/usuario/administracion/pedido/busqueda',{
                    method:'POST',
//                    body:busqueda,
                    body:JSON.stringify({'busqueda':busquedaadmin.value}),
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
                    throw new Error('HTTP error  status'+response.status);
                })
                 .then(data => {
//                    
                    let tablalibros = document.querySelector('.tabla_libro');
                    let tablalibroscuerpo = tablalibros.querySelector('tbody');
                    tablalibroscuerpo.remove(); 
                    let cuerpotabla = document.createElement('tbody');
//                    cuerpotabla.className='tabla_libro_cuerpo';
//                    
//                    
                    var pedidosbbdd= data.pedidos;
                    console.log(pedidosbbdd);
                    pedidosbbdd.forEach((p)=>{
                        let filatr = document.createElement('tr');
                        let celdatd1= document.createElement('td')
                        let celdatd2= document.createElement('td')
                        let celdatd3= document.createElement('td')
                        let celdatd4= document.createElement('td')
                        let celdatd5= document.createElement('td')
//                        let celdatd6= document.createElement('td')
//                        let celdatd7= document.createElement('td')
                        celdatd1.innerHTML= p.id;
                        celdatd2.innerHTML= p.name+' | '+p.email;
                        celdatd3.innerHTML= p.total_compra;
                        celdatd4.innerHTML= p.created_at;
                        
                        let celdatd5div= document.createElement('div');
                        let celdatd5boton= document.createElement('span');
                        
                        celdatd5boton.addEventListener('click',(event)=>{
            
                            let filalibrosdetalles = event.target.parentNode.parentNode.parentNode.nextElementSibling;
                            filalibrosdetalles.firstChild.classList.toggle('vermasdetalles');            
                        });
                        
                        celdatd5div.className='accionesadmin';
                        celdatd5boton.className='verdetallespedidos';
                        celdatd5boton.innerHTML='Ver detalles';

                        celdatd5div.appendChild(celdatd5boton);
                        
                        celdatd5.appendChild(celdatd5div);
//                        
//                       
//                        
                        let filatrlibros = document.createElement('tr');
                        filatrlibros.className='fila_detalles'
                        let celdatdlibros = document.createElement('td');
                        celdatdlibros.setAttribute('colspan',"5");
                        let contenedorlibros = document.createElement('div');
                        let cabecera = document.createElement('h6');
                        cabecera.innerHTML='Detalles del pedido:';
                        contenedorlibros.className='detalles_compra_libros';
                        
                        let lista = document.createElement('ul');
//                        console.log(pedidosbbdd.libros);
                        (p.libros).forEach((l)=>{
                            console.log(l);
                            let li = document.createElement('li');
                            let ali = document.createElement('a');
                            let spantitulo = document.createElement('span');
                            let spanprecio = document.createElement('span');
                            
                            spantitulo.innerHTML=l.titulo;
                            spanprecio.innerHTML=l.precio;
                            
                            ali.setAttribute('href', location.origin+'/libros/detalle/'+l.id);
                            
                            ali.appendChild(spantitulo);
                            ali.appendChild(spanprecio);
                            
                            li.appendChild(ali);
                            lista.appendChild(li);
                        });
                        contenedorlibros.appendChild(cabecera);
                        contenedorlibros.appendChild(lista);
                        celdatdlibros.appendChild(contenedorlibros);
                        filatrlibros.appendChild(celdatdlibros);
//                        
                        filatr.appendChild(celdatd1);
                        filatr.appendChild(celdatd2);
                        filatr.appendChild(celdatd3);
                        filatr.appendChild(celdatd4);
                        filatr.appendChild(celdatd5);//                        
                        cuerpotabla.appendChild(filatr);
                        cuerpotabla.appendChild(filatrlibros);
                    });
                    tablalibros.appendChild(cuerpotabla);
                       
                    
            });
        }
    }
}

});
///---------------------------------------------------------busqueda de pedido por parte del admin FIN ---------------------------------------------------------
//+++++++++++++++++++++++++formulario publicar libro ///---------------------------------------------------------
//+++++++++++++++++++++++++autores
let autorcontenedor= document.querySelector('.autores-libro');
if(autorcontenedor){
    let autoresselect= autorcontenedor.querySelector('select')
    if(autoresselect){

        let indiceoption = document.createElement('option');
        indiceoption.setAttribute('value','999');
        indiceoption.setAttribute('selected','true');
        indiceoption.innerText='-- Lista de Autores --';
        autoresselect.appendChild(indiceoption);
        let autoresAll= autoresselect.querySelectorAll('option');
        let inputotro = autorcontenedor.querySelector('#otroautorcheck');
        let autootro = autorcontenedor.querySelector('.otroautor');//div que contiene el input text y textarea para la opcion -->otro


        if(autoresAll){
            var autoresArray=[];
            autoresAll.forEach((a)=>{
                autoresArray.push(a);
            });
        }
        //filtrado por campo de busqueda
         // busqueda en el input type text
        let busquedatext = autorcontenedor.querySelector('#autorbusqueda');
        // accion que hace al pulsar tecla del type text busqueda
        busquedatext.addEventListener('keyup',(event)=>{
            // busca en el array de autores si coincide con lo introducido en el text de busqueda
            let auotresencontrado= autoresArray.filter(a => a.textContent.toUpperCase().includes(event.target.value.toUpperCase()));
            // select
            let autor = autorcontenedor.querySelector('#autorselect');
            // todas las options con los autores
            let opciones = autoresselect.querySelectorAll('option');
            // si las los autores no estan en los autores encontrados no los mostramos
            autoresAll.forEach((op)=>{
                // si no esta en el array la busqueda encontrada eleimina la opcion del select
                if(!auotresencontrado.includes(op)){
                        op.style.display='none';
                }else{
                    op.style.display='block';
                }

            });
        });

        //añadir autor, div que sale de la derecha, el autor no esta en la lista
        inputotro.addEventListener('change',(e)=>{
            let valor = e.target;
            // si la opcion elegida tiene el valor otro mostramos el div de otro autor
            if(valor.checked){
                autootro.classList.add('mostrar');
                autoresselect.disabled=true;
                busquedatext.disabled=true;
            }else{
                autootro.classList.remove('mostrar');
                autoresselect.disabled=false;
                busquedatext.disabled=false;
            }
        });

    }
}
//+++++++++++++++++++++++++ fin autor +++++++++++++++++++++++++

//+++++++++++++++++++++++++ zonas de subida de archivos+++++++++++++++++++++++++
async function areaDragDrop(areaArchivo){
//    etiquetaa que vera el usuarario y despliegue el area de subir archivo
    let botonabrirarea = document.querySelector('.'+areaArchivo+' label');
//    contenedor que almacena las zona de carga del archivo
    let contenedor = document.querySelector('.'+areaArchivo+' >div');
//    boton que se muestra en el area de arrastrar y soltar
    let botonsubirArchivos = document.querySelector('.'+areaArchivo+' div button');
//    cabecera que muestra las zonas para subir archivos
    botonabrirarea.addEventListener('click',(event)=>{
        event.preventDefault();        
        if((contenedor.className).includes('mostrar_archivos')){
            contenedor.classList.remove('mostrar_archivos');
            botonabrirarea.querySelector('span').style.display='inline';
        }else{        
            contenedor.classList.add('mostrar_archivos');
            botonabrirarea.querySelector('span').style.display='none';
        }
    });
   
    
    
    // area de subida y partes que la contienen->area,mensaje,boton subir,lista documento subido
    const area = document.querySelector('.'+areaArchivo+' div');//area
    const areamensaje =area.querySelector('span');//mensaje
    const botonintroducirarchivo =area.querySelector('button');//boton
    const inputarea = area.querySelector('input');//input file del archivo
    let documentosarea = document.querySelector('.'+areaArchivo+'#documentos-imagenes');
    
           

//  si pulsamos el boton se subir archivos abre la ventana para seleccionar el archivo
    botonintroducirarchivo.addEventListener('click',(e)=>{
        e.preventDefault();
        inputarea.click();
    });    
//    acciones con el area al entrar y salir archivos arrastrados, cambiamos la clase de estilos

  // area dragable entrar
    area.addEventListener("dragover", (event) => {
        event.preventDefault();
        area.classList.add("archivo_drag");
        areamensaje.textContent = "Libere el archivo para cargar";
    });
 // area dragable al salir
    area.addEventListener("dragleave", () => {
        area.classList.remove("archivo_drag");
        areamensaje.textContent = "Arrastra archivos";
    });
  //area dragable al soltar archivo
    area.addEventListener("drop", (event) => {
        event.preventDefault();
        
        
        area.classList.remove("active");
        //estilo que muestra el archivo subido
        area.classList.remove("archivo_drag");
        area.classList.add("archivo_subido");
        areamensaje.textContent = "Arrastra archivos";
        
        let archivos = event.dataTransfer.files;
        let file = archivos.files;
        integrararchivosainput(archivos);
        mostrararchivos(archivos);
    
        function integrararchivosainput(archivos){
            const dataTransfer = new DataTransfer();

            for (const file of inputarea.files){
                dataTransfer.items.add(file);
            }
            
            for (const archivo of archivos){
                dataTransfer.items.add(archivo);
            }
            
            inputarea.files =   dataTransfer.files;

        }
        function mostrararchivos(archivos){
            for(const archivo of archivos){
//                console.log(archivo);
                var li =  document.createElement('li');
                li.innerHTML=`&#x1f5c8;     `+archivo.name+`(`+(archivo.size/1024).toFixed(2)+`Kb)`+`<span class="eliminarArchivo">X</span>`;
                var elementoUL= document.querySelector('.'+areaArchivo+'>div ul');
                elementoUL.appendChild(li);
                let eliminarArchivo = li.querySelector('span');

                eliminarArchivo.addEventListener('click',(e)=>{
                    e.preventDefault();

                    area.classList.remove("archivo_subido");
                    li.remove();
                    archivosubido=null;
                    dataTransfer=null;
                    inputarea.value='';
                });
            }
        }

    });
    
    inputarea.addEventListener('change',()=>{
        mostrararchivos(inputarea.files);
    });
        
//        console.log(inputarea);
        
  
 }
 
 if( document.querySelector('.archivos_portada')){
     
    areaDragDrop('archivos_portada');
    areaDragDrop('archivos_archivo');
 }
 //zonas de subida de archivos FIN
 
 
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

//formulario publicar libro FIM ///---------------------------------------------------------
//++++++++++++++++++++    busqueda por nombre de autor+++++++++++++++++++++++++
window.addEventListener('load', function(){
 
var contenedorautores = document.querySelector(".busqueda_autor");
 
 if(contenedorautores){
            let form = contenedorautores.querySelector('form');
            form.style.background='none';
            form.style.padding='0';
            var inputtexto = contenedorautores.querySelector("#busquedaautor");
            if(inputtexto){
                inputtexto.addEventListener('keyup',(e)=>{
                    e.preventDefault();
      
                    setTimeout(() => {
                        
                        consulta(e.target.value);  
                    }, 1000);

                });
            }
        async function consulta(autorbusqueda) {
//         elimino los contenedores de los libros para mostrar otros
            var autores = document.querySelectorAll(".autor");
//            console.log(libros.length);
//            eliminamos todos los autores
            autores.forEach((autor)=>{
                autor.remove();
            });
            
            var contenedorGrande = document.querySelector(".autores");
            let url= location.origin;
            fetch(url+'/autor/',{
                method:'POST',
//                    body:busqueda,
                body:JSON.stringify({'busqueda':autorbusqueda}),
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
                throw new Error('HTTP error  status'+response.status);
            })
            .then(data => {

                let datosautores=data.autores;
                datosautores.forEach((autor)=>{
//                      creamos el contenedor div de cada elemento que muestra los autores
                    var contenedor = document.createElement("div");
                    var contenedorenlace = document.createElement("a");
                    var nombre = document.createElement("h3");
                    var fecha = document.createElement("h5");  
                    var nombre = document.createElement("h3");
                    var imagen = document.createElement("img");

                    nombre.innerHTML=autor.nombre;    
                    fecha.innerHTML=autor.fecha_nacimiento
                    if(autor.imagen_url!=null){
                        imagen.setAttribute('src',autor.imagen_url);
                    }else
                    {
                        imagen.setAttribute('src',location.origin+'/image/cabecera.webp');
                    }
                    imagen.setAttribute('alt',autor.nombre);

                    contenedorenlace.setAttribute('href', location.origin+'/autor/detalles/'+autor.id);
                    contenedor.className ='autor';
//                      
                    contenedorenlace.appendChild(nombre);
                    contenedorenlace.appendChild(imagen);
                    contenedorenlace.appendChild(fecha);
                    contenedor.appendChild(contenedorenlace);

                    contenedorGrande.appendChild(contenedor);


                });
            })
            .catch(error =>console.log('Error:'+error));  
        }      
            

  
 }
 });
//++++++++++++++++++++    busqueda por nombre de autor FIN +++++++++++++++++++++++++
//++++++++++++++++++++    busqueda por nombre de autor en panel admin +++++++++++++++++++++++++
//
var contenedorautores = document.querySelector(".form_busqueda_autor_admin");
 
 if(contenedorautores){
            let form = contenedorautores.querySelector('form');
            form.style.background='none';
            form.style.padding='0';
            form.style.border='none';
            form.style.boxShadow ='none';
            var inputtexto = contenedorautores.querySelector("#busqueda_admin");
            if(inputtexto){
                inputtexto.addEventListener('keyup',(e)=>{
                    e.preventDefault();
      
                    let autoresdevueltos=  consulta(e.target.value); 
//                    console.log(autoresdevueltos);

                });
            }
                
 
        async function consulta(autorbusqueda) {
            let tabla = document.querySelector('table');
//         elimino los contenedores de los libros para mostrar otros
            var autores = tabla.querySelectorAll("tbody tr");
//            console.log(libros.length);
//            eliminamos todos los autores
            autores.forEach((autor)=>{
                autor.remove();
            });
            
            var contenedorGrande = document.querySelector(".autores");
            let url= location.origin;
            fetch(url+'/usuario/administracion/autores/busqueda/',{
                method:'POST',
//                    body:busqueda,
                body:JSON.stringify({'busqueda':autorbusqueda}),
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
                throw new Error('HTTP error  status'+response.status);
            })
            .then(data => {

                let datosautores=data.autores;
                mostrar_tabla(datosautores);

//            

//                });
            })
            .catch(error =>console.log('Error:'+error));  
    
    
            

        async function mostrar_tabla(autoresdevueltos){
            console.log(autoresdevueltos);
        let tabla = document.querySelector('table');
    //         elimino los contenedores de los libros para mostrar otros
        var autores = tabla.querySelectorAll("tbody tr");
    //            console.log(libros.length);
    //            eliminamos todos los autores
        autores.forEach((autor)=>{
            autor.remove();
        });

        var contenedorGrande = document.querySelector(".autores");


            autoresdevueltos.forEach((a)=>{
    //                      creamos el contenedor div de cada elemento que muestra los autores
                var fila = document.createElement("tr");
                var celda1 = document.createElement("td");
                var celda2 = document.createElement("td");
                var celda3 = document.createElement("td");
                var celda4 = document.createElement("td");
                var contenedoracciones = document.createElement("div");
                var enlaceReferancias = document.createElement("a");
                var enlaceVerautor = document.createElement("a");
                var enlaceEditar = document.createElement("a");
                var enlaceEliminar = document.createElement("a");

                celda1.innerHTML =a.id;
                celda2.innerHTML =a.nombre;
                enlaceReferancias.innerHTML ='Referencias';
                enlaceReferancias.setAttribute('href',a.referencias);
                celda3.appendChild(enlaceReferancias);
                enlaceVerautor.innerHTML='Ver Autor';
                enlaceVerautor.setAttribute('href',url+'/autor/detalles/'+a.id)
                enlaceEditar.innerHTML='Editar';
                enlaceEditar.setAttribute('href',url+'/autor/crear/'+a.id)
                enlaceEliminar.innerHTML='Eliminar';
                enlaceEliminar.setAttribute('href',url+'/autor/eliminar/'+a.id)

                contenedoracciones.className='accionesadmin';

                contenedoracciones.appendChild(enlaceVerautor);
                contenedoracciones.appendChild(enlaceEditar);
                contenedoracciones.appendChild(enlaceEliminar);

                celda4.appendChild(contenedoracciones);

                fila.appendChild(celda1);
                fila.appendChild(celda2);
                fila.appendChild(celda3);
                fila.appendChild(celda4);

                tabla.querySelector('tbody').appendChild(fila);
            });
        }
    } 
 }
 
//++++++++++++++++++++    busqueda por nombre de libro o autor en panel admin +++++++++++++++++++++++++

//++++++++++++++++++++    busqueda por nombre de autor admin FIN +++++++++++++++++++++++++

