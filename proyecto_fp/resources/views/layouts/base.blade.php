<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href='{{ asset("image/icono.ico") }}' type="image/x-icon">
    <link rel='stylesheet' href='{{ asset("css/estilos.css") }}'>
    <title>SENECALIB - @yield('titulo')</title>
        <style>
            
            #perfil{
                transition: 0.5s;
            }
            #perfil:hover{
                
                background: #F44336;
                color: #FFC107;
                transform: perspective(150px) skewX(5deg) rotateX(360deg);
            }
            
            .enlaces .admin{
                background: yellow;
                color:black;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <header>  
            <nav class="-mx-3 flex flex-1 justify-end">
                <div class='enlaces'>
                    <a href='{{route('inicio')}}'> Volver </a>
                    <a href='{{route('todoslibros')}}'> Mostrar todos los libros</a>                                    
                    @auth
                        <a href="{{route('verUsuario',['user'=>Auth::user()->id])}}" id='perfil'>Hola {{Auth::user()->name}}</a>
                        <a href="/miperfil/{{Auth::user()->id}}">Configuración de mi perfil</a>
                        @if (Auth::user()->role=='admin')
                            <a href="#" class='admin'>Panel de administrador</a>
                        @endif
                        <a href="{{ route('logout')}}">Cerrar Sesión</a>
                    @else
                        <a href="{{ route('login')}}">Iniciar Sesión</a>

                            @if (Route::has('registro'))
                                <a href="{{ route('registro')}}">Registrarse</a>
                            @endif
                                    
                            <!--pruebas-->
                            @if (Route::has('prueba'))
                            <p> contiene la rura prueba</p>
                            @endif
                                    
                    @endauth
                </div>
            </nav>
        </header>
        
           

        <main>
            @if (session('mensaje'))
                <div class='alert alert-ok'>
                    {{ session('mensaje') }}
                </div>
            @endif 
            @yield('contenido')



            
        </main>
            <script>
            const etiqueta = document.getElementById("perfil");
            
            let iniciotext= etiqueta.text;
//            console.log(iniciotext);
            etiqueta.addEventListener(
                "mouseenter",
                (event) => {
                  // highlight the mouseenter target
                  event.target.text='Mi Perfil';

                  // reset the color after a short delay
                  setTimeout(() => {
                    event.target.style.color = "";
                  }, 500);
                },
                false,
              );
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
            </script>
    </body>
</html>