 const etiqueta = document.getElementById("perfil");
            
            let iniciotext= etiqueta.text;
//            console.log(iniciotext);
            etiqueta.addEventListener("mouseenter",(event) => {
                  // highlight the mouseenter target
                  event.target.text='Mi Perfil';

                  // reset the color after a short delay
                  setTimeout(() => {
                    event.target.style.color = "";
                  }, 500);
                });
              etiqueta.addEventListener(
                "mouseout",
                (event) => {
                  // highlight the mouseenter target
                  event.target.text=iniciotext;

                  // reset the color after a short delay
                  setTimeout(() => {
                    event.target.style.color = "";
                  }, 500);
                },
                false,
              );
