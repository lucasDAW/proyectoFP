<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token()}}" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href='{{ asset("image/icono.ico") }}' type="image/x-icon">
    <link rel='stylesheet' href='{{ asset("css/estilos.css") }}'>
    <title>SENECALIB - @yield('titulo')</title>
    <!--icono-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=delete_forever" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_shopping_cart" />
<style>
            
           
        </style>
    </head>
    <body class="font-sans antialiased">
        <header>  
            <nav class="enlaces">
               
                <ul>
                    
                    <li><a href='{{route('inicio')}}'> Volver </a></li>
                    <li><a href='{{route('todoslibros')}}'> Mostrar todos los libros</a></li>                                    
                    <li><a href='{{route('busquedalibro')}}'> Busqueda</a></li>
                    @auth
                        <li><a href="{{route('verUsuario',['user'=>Auth::user()->id])}}" id='perfil'>Hola {{Auth::user()->name}}</a>
                    @else
                        <li> <a href="{{ route('login')}}">Iniciar Sesión</a></li>
                    @endauth
                <ul class='submenu'>
                    
                    @auth
                        <li><a href="/miperfil/{{Auth::user()->id}}">Configuración de mi perfil</a></li>
                        <li><a href="{{route('verpedidos',['id' => Auth::user()->id])}}">Mis Pedidos</a></li>
                        @if (Auth::user()->role=='admin')
                            <li><a href="#" class='admin'>Panel de administrador</a></li>
                        @endif
                            <li><a href="{{ route('logout')}}">Cerrar Sesión</a></li>
                </ul>
                    </li>
                    @else
                    <li> <a href="{{ route('login')}}">Iniciar Sesión</a></li>

                            @if (Route::has('registro'))
                                <li><a href="{{ route('registro')}}">Registrarse</a></li>
                            @endif
                                    
                                    
                    @endauth
                       <li> <a href="{{ route('mostrarTabla')}}">Ver Cesta</a></li>
                            <!--pruebas-->
                            @if (Route::has('prueba'))
                            <p> contiene la rura prueba</p>
                            @endif
               
                </ul>
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
            </script>
    </body>
</html>