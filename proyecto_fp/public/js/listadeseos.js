
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
                    contenidolista=true;
            }//    
            let libro_id= location.href.split('/')[location.href.split('/').length-1]
             let url=location.origin+"/usuario/libro/listadeseos";
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
//                    json = JSON.parse(xhr.responseText);


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

