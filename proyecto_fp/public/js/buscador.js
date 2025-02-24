
let debounceTimer;
// +++++++++++++++++++++++++aqui va el buscador de libros de la pagina principal

            let formuariobusquedalibros =document.querySelector('.formularioBusquedaLibros');
            if(formuariobusquedalibros){
                
                var input = formuariobusquedalibros.querySelector("#busqueda");
            }
            if(input){
                input.addEventListener('keyup',
                (event)=>{
                    event.preventDefault();
                    
                    clearTimeout(debounceTimer);
                    // Establece un nuevo temporizador
                     debounceTimer = setTimeout(() => {
                      consultalibrousuario(event.target.value);
                    }, 500); 
                        
                    
                });
            }
     async function consultalibrousuario(librobusqueda) {
//         elimino los contenedores de los libros para mostrar otros
            var libros = document.body.querySelectorAll(".libro");
//            console.log(libros.length);
            var contenedorGrande = document.body.querySelector(".libros");
            
            if(libros){
                    
                libros.forEach((li)=>{
                    li.remove();
                });
            }
           
//                let campobusqueda = input.value;
//                let busqueda ={'busqueda':n};
                let url= location.origin;
//                console.log(url);
                fetch(url+'/libro/busqueda',{
                    method:'POST',
//                    body:busqueda,
                    body:JSON.stringify({'busqueda':librobusqueda}),
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

//                    let librosencontrados=data.libros;
                    let librosencontrados=data.libros;                    
                    librosencontrados.forEach((l)=>{
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
                        contenedorenlace.setAttribute('href', location.origin+'/libro/detalle/'+l.id);
                        contenedor.appendChild(contenedorenlace);
//                      
                        contenedor.className ='libro';
                        contenedorGrande.appendChild(contenedor);
                        
                            
                           
                    });
                })
                .catch(error =>console.log('Error:'+error));  
            }      
            
          

//+++++++++++++++++++++++++busqueda de libro por parte del admin----------------------------------------------------------------------------
let formbusquedaadmin = document.querySelector('.formularioBusquedaLibrosAdmin');
if(formbusquedaadmin){
    let busquedaadmin = formbusquedaadmin.querySelector('#busqueda_admin');
    if(busquedaadmin){
                    
            busquedaadmin.addEventListener('keyup',(event)=>{

                clearTimeout(debounceTimer);
                    // Establece un nuevo temporizador
                    debounceTimer = setTimeout(() => {
                    consultaadminlibros(event.target.value);
                    }, 500);
            });

            async function consultaadminlibros(busqueda) {
                //borramos paginacion
                let pagination = document.querySelector('.paginacion');
                pagination ? pagination.remove():'';

//            let busquedatitulo= busquedaadmin.value;
//            let busqueda ={'busqueda':busquedatitulo};
            let url= location.origin;
            fetch(url+'/administracion/libros/busqueda',{
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
                    ver.setAttribute('href', location.origin+'/libro/detalle/'+l.id);

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
    
let formulariobqdpedido = document.querySelector('.form_busqueda_pedidos_admin form');
if(formulariobqdpedido){

    let busquedaadmin = formulariobqdpedido.querySelector('#busqueda_admin');
    if(busquedaadmin){
                    
                busquedaadmin.addEventListener('keyup',(event)=>{
                    
                    clearTimeout(debounceTimer);
                    // Establece un nuevo temporizador
                    debounceTimer = setTimeout(() => {
                    consultaadminpedido();
                    }, 500);
                });
                
                async function consultaadminpedido() {
                    //borramos paginacion
                    let pagination = document.querySelector('.paginacion');
                    pagination ? pagination.remove():'';
//                    console.log(busquedaadmin.value);
                  fetch('/administracion/pedido/busqueda',{
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
                            let li = document.createElement('li');
                            let ali = document.createElement('a');
                            let spantitulo = document.createElement('span');
                            let spanprecio = document.createElement('span');
                            
                            spantitulo.innerHTML=l.titulo;
                            spanprecio.innerHTML=l.precio;
                            
                            ali.setAttribute('href', location.origin+'/libro/detalle/'+l.id);
                            
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

//+++++++++++++++++++++++++autores+++++++++++++++++++++++++++++++++++++++++++++++
let autorcontenedor= document.querySelector('.autores-libro');
if(autorcontenedor){
    let autoresselect= autorcontenedor.querySelector('select')
    if(autoresselect){

        let indiceoption = document.createElement('option');
        indiceoption.setAttribute('value','999');
//        indiceoption.setAttribute('selected','true');
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


var contenedorautores = document.querySelector(".busqueda_autor");
 
 if(contenedorautores){
            let form = contenedorautores.querySelector('form');
            
            var inputtexto = contenedorautores.querySelector("#busquedaautor");
            if(inputtexto){
                inputtexto.addEventListener('keyup',(e)=>{
                    
                    e.preventDefault();                   
                    clearTimeout(debounceTimer);
                    // Establece un nuevo temporizador
                    debounceTimer = setTimeout(() => {
                        consultaautor(e.target.value);  
                    }, 500);
                });
            }
        async function consultaautor(autorbusqueda) {
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
                    clearTimeout(debounceTimer);
                    // Establece un nuevo temporizador
                    debounceTimer = setTimeout(() => {
                    let autoresdevueltos=  consulta(e.target.value); 
                    }, 500);
      

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
            fetch(url+'/administracion/autores/busqueda/',{
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
//  --------------------------------------------------------------------------------------------
// busqueda usuario por parte del admin

var contenedorusuarios = document.querySelector(".form_busqueda_usuario_admin");
 
 if(contenedorusuarios){
            let form = contenedorusuarios.querySelector('form');
           
            var inputtexto = contenedorusuarios.querySelector("#busqueda_admin");
            if(inputtexto){
                inputtexto.addEventListener('keyup',(e)=>{
                    e.preventDefault();                   
                    clearTimeout(debounceTimer);
                    // Establece un nuevo temporizador
                    debounceTimer = setTimeout(() => {
                    let autoresdevueltos=  consultausuarioAdmin(e.target.value); 
                    }, 500);
      

                });
            }
                
 
        async function consultausuarioAdmin(autorbusqueda) {
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
            fetch(url+'/administracion/usuario/busqueda/',{
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

                let datosusuarios=data.usuarios;
                mostrar_tabla(datosusuarios);

//            

//                });
            })
            .catch(error =>console.log('Error:'+error));  
    
    
            

        async function mostrar_tabla(autoresdevueltos){
        let tabla = document.querySelector('table');
    //         elimino los contenedores de los libros para mostrar otros
        var autores = tabla.querySelectorAll("tbody tr");
    //            console.log(libros.length);
    //            eliminamos todos los autores
        autores.forEach((autor)=>{
            autor.remove();
        });

        var contenedorGrande = document.querySelector(".autores");


            autoresdevueltos.forEach((u)=>{
    //                      creamos el contenedor div de cada elemento que muestra los autores
                var fila = document.createElement("tr");
                var celda1 = document.createElement("td");
                var celda2 = document.createElement("td");
                var celda3 = document.createElement("td");
                var celda4 = document.createElement("td");
                var contenedoracciones = document.createElement("div");
                var enlaceVer = document.createElement("a");
                var enlacecorreo = document.createElement("a");
                var enlaceModificar = document.createElement("a");

                celda1.innerHTML =u.id;
                celda2.innerHTML =u.nombre;
                celda3.innerHTML =u.email;
                
                enlaceVer.innerHTML='Ver Interacciones';
                enlaceVer.setAttribute('href',url+'/administracion/usuarios/interacciones/'+u.id)
                enlacecorreo.innerHTML='Enviar Correo';
                enlacecorreo.setAttribute('href',url+'/administracion/usuarios/enviar/'+u.id)
                enlaceModificar.innerHTML='Modificar Usuario';
                enlaceModificar.setAttribute('href',url+'/perfil/editar?id='+u.id)

                contenedoracciones.className='accionesadmin';

                contenedoracciones.appendChild(enlaceVer);
                contenedoracciones.appendChild(enlacecorreo);
                contenedoracciones.appendChild(enlaceModificar);

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
  