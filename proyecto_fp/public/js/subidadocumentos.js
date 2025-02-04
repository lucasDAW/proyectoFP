
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