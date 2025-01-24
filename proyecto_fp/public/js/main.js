window.addEventListener('load', function(){




//cabecera - header al hacer scroll desaparece la imagen de cabecera

const headerImage = document.getElementById('header-image');
const header = document.querySelector('.cabecera-banner');

//    console.log(header.clientHeight);
// Escucha el evento de scroll
window.addEventListener('scroll', () => {
//        console.log(header.clientHeight);

    if (window.scrollY > 150) {
//        header.style.height=(header.clientHeight-25)+'px';
        header.style.display = "none";
        headerImage.style.opacity = '0'; // Ocultar la imagen
        headerImage.style.pointerEvents = 'none'; // Evitar interacciones con la imagen
    } else {
//        header.style.height=(header.clientHeight+25)+'px';
        header.style.display = "block";
        headerImage.style.opacity = '1'; // Mostrar la imagen
        headerImage.style.pointerEvents = 'auto'; // Permitir interacciones con la imagen
        header.style.diplay='block';
//        header.style.padding = '10px 20px'; // Restaurar el espacio del header
    }
});
//cabecera - header al hacer scroll desaparece la imagen

//paginacion


    let paginacion=document.querySelector('.paginacion nav');
    if(paginacion){
        paginacion.children[0].innerHTML ='<< Anterior';
        paginacion.children[1].innerHTML =' Siguiente >>';
    }

//paginacion

//etiqueta de la barra de nav que muestra el nombre del perfil
const etiqueta = document.getElementById("perfil");
const li = document.querySelector(".nombre");

if(li){
    
    const widthdiv=li.clientWidth;
}
    
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

//etiqueta de la barra de nav que muestra el nombre del perfil
//
//
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
//            console.log(json);
            
           
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


//PROCEDIMIENTO PARA EDITAR DATOS DEL USUARIO


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


//efecto difuminar cuando se hace hover sobre la imagen

function efecto_imagen(){
    
    let img = document.querySelectorAll(".libro img");

//console.log(img);
    
    img.forEach((imagen)=>{
        imagen.addEventListener('mouseenter',(event)=>{
            img.forEach((i)=>{
                i.style.filter= 'blur(6px)';
            });
            event.target.style.borderRadius ='50px';
            event.target.style.filter= 'blur(0px)';
            event.target.parentNode.parentNode.querySelector('.add-to-cart').style.visibility= 'hidden';

    //        console.log('entrando');
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


//aqui va el buscador de libros de la pagina principal


            var input = document.getElementById("busqueda");
            var log = document.getElementById("textobusqueda");
            let librosrecibidos;
            if(input){
                input.addEventListener('keyup',consulta);
            }
     async function consulta() {
//         elimino los contenedores de los libros para mostrar otros
            var libros = document.body.querySelectorAll(".libro");
//            console.log(libros.length);
            var contenedorGrande = document.body.querySelector(".libros");
            
            libros.forEach((li)=>{
                li.remove();
            });
           
                let campobusqueda = input.value;
               
                let busqueda ={'busqueda':campobusqueda};
                let url= location.host;
                url= 'http://'+url+'/libros/busqueda';
//                fetch('/libros/busqueda',{
                fetch('/libros/busqueda',{
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

//                    console.log(data.data);
                    libros=data.data;
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
  

//  FIN   aqui va el buscador de libros de la pagina principal
// AMPLIAR LA DESCRIPCION DE DETALLES DE LIBROS 

window.addEventListener('load',function(){
    
    let btn_leermas= document.querySelectorAll('.libro-detalles .btn_leermas span');
    let descripcionlibro= document.querySelector('.libro-detalles .libro-descripcion');
//    console.log(btn_leermas);
    //console.log(descripcionlibro.offsetHeight);
//    console.log(descripcionlibro.clientHeight );
    if(descripcionlibro){
        
        let alturaDescripcion=descripcionlibro.clientHeight;
        descripcionlibro.style.height='150px';
        descripcionlibro.style.transition = "all 2s";;
    }

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
});
// AMPLIAR LA DESCRIPCION DE DETALLES DE LIBROS FIN 
// Detalles del usuario que ve el admin en panel de administracion
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
// Detalles del usuario que ve el admin en panel de administracion FIN 


//detalles de la tabla pedidos - boton ver mas detalles 

let botonvedetalles = document.querySelectorAll('table tbody tr td .accionesadmin .verdetallespedidos');
if(botonvedetalles){
    
//    console.log(botonvedetalles);
    botonvedetalles.forEach((botondetalles)=>{
        
        botondetalles.addEventListener('click',(event)=>{
            
//            console.log(event.target);
//            console.log(event.target.parentNode.parentNode.parentNode.nextElementSibling);
            let filalibrosdetalles = event.target.parentNode.parentNode.parentNode.nextElementSibling;
//            filalibrosdetalles.style.display='table-row';
//            filalibrosdetalles.classList.toggle('vermasdetalles');            
            filalibrosdetalles.firstChild.classList.toggle('vermasdetalles');            
        });
    });
}

//detalles de la tabla pedidos - boton ver mas detalles FIN

//busqueda de libro por parte del admin----------------------------------------------------------------------------
let formbusquedaadmin = document.querySelector('.form_busqueda_libro_admin form');
if(formbusquedaadmin){
    let busquedaadmin = formbusquedaadmin.querySelector('#busqueda_admin');
    if(busquedaadmin){
                    
                busquedaadmin.addEventListener('keyup',(event)=>{
                    
                    consultaadmin();
                });
                
                async function consultaadmin() {
                    //borramos paginacion
                    let pagination = document.querySelector('.paginacion');
                    pagination ? pagination.remove():'';
                        
                    
//                let busqueda ={'busqueda':librodetalles};
//                let url= location.host;
                fetch('/usuario/administracion/libros/busqueda',{
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
                    
                    let tablalibros = document.querySelector('.tabla_libro');
                    let tablalibroscuerpo = document.querySelector('.tabla_libro_cuerpo');
                    tablalibroscuerpo.remove(); 
                    let cuerpotabla = document.createElement('tbody');
                    cuerpotabla.className='tabla_libro_cuerpo';
                    
                    
                    var librosbbdd= data.libros;
//                    console.log(librosbbdd);
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
                        celdatd3.innerHTML= l.autor;
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
                        
//                    console.log(data.length);
            });
        }
    }
}
//busqueda de libro por parte del admin FIN ---------------------------------------------------------
//---------------------------------------------------------busqueda de pedido por parte del admin FIN ---------------------------------------------------------
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
                        filatr.appendChild(celdatd5);
//                        filatr.appendChild(celdatd6);
//                        celdatd7.appendChild(contenedorbotones);
//                        filatr.appendChild(celdatd7);
//                        
                        cuerpotabla.appendChild(filatr);
                        cuerpotabla.appendChild(filatrlibros);
//                        
                    });
                    tablalibros.appendChild(cuerpotabla);
                       
                    
            });
        }
    }
}

});
///---------------------------------------------------------busqueda de pedido por parte del admin FIN ---------------------------------------------------------

