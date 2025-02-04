
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