
let botones = document.querySelectorAll('.interacciones .btn_interacciones span');

if(botones){
    
//    tablas que muestran la información
    let tablasusuariocomentarios = document.querySelector('.interacciones .comentarios');
    let tablasusuariovaloraciones = document.querySelector('.interacciones .valoraciones');
    let tablasusuariopedidos = document.querySelector('.interacciones .compras');
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


let botonvedetalles = document.querySelectorAll('table tbody tr td .accionesadmin .verdetallespedidos');
if(botonvedetalles){
    
    botonvedetalles.forEach((botondetalles)=>{
        
        botondetalles.addEventListener('click',(event)=>{
            
            let filalibrosdetalles = event.target.parentNode.parentNode.parentNode.nextElementSibling;
            filalibrosdetalles.firstChild.classList.toggle('vermasdetalles');            
        });
    });
}