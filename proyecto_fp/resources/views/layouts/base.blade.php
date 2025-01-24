<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token()}}" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href='{{ asset("image/icono.ico") }}' type="image/x-icon">
    <link rel='stylesheet' href='{{ asset("css/estilos.css") }}'>
    <title>SENECALIB - @yield('titulo')</title>
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <!--iconos-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=delete_forever" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_shopping_cart" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=favorite" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_shopping_cart" />
    </head>
    <body class="font-sans antialiased">
        <header>
            <div class="cabecera-banner">
                <a href='{{route('todoslibros')}}'><img id="header-image" src="{{asset("image/cabecera.webp")}}" alt="Cabecera" /></a>
           </div>
            <nav class="enlaces">
               
                <ul>
                    <li class="volver"><a href='{{ url()->previous() }}'><span>&#129044;</span> Volver  </a></li>
                    <li><a href='{{route('todoslibros')}}'> Mostrar todos los libros</a></li>                                    
                    <li><a href='{{route('busquedalibros')}}'> Categorías</a></li>
                    <li class="cesta"> <a href="{{ route('mostrarTabla')}}">Ver Cesta</a></li>               

                    @auth
                        <li class='nombre'><a href="{{route('verUsuario',['user'=>Auth::user()->id])}}" id='perfil'>Hola {{Auth::user()->name}}</a>
                    @else
                        <li> <a href="{{ route('login')}}">Iniciar Sesión</a></li>
                    @endauth
                            <ul class='submenu'>

                                @auth
                                    <li><a href="{{route('verUsuario')}}">Configuración de mi perfil<span>&#128187;</span></a></li>
                                    <li><a href="{{route('verpedidos',['id' => Auth::user()->id])}}">Mis Pedidos<span>&#x1f6d2;</span></a></li>
                                    <li class="lista_deseos_enlace"><a href="{{route('verdeseos')}}">Mis Lista de deseos <span class="material-symbols-outlined">favorite</span></a></li>
                                    <li class="publicar"><a href="{{route('publicarvista')}}">Publicar <span>&#x270d;</span></a></li>
                                    @if (Auth::user()->role==2)
                                    <li><a href="{{route('inicioadmin')}}" class='admin'>Panel de administrador<span>&#x1f5b3;</span></a></li>
                                    @endif
                                    <li class="btn_cerrar_sesion"><a href="{{ route('logout')}}">Cerrar Sesión<span>&#10060;</span></a></li>
                            </ul>
                        </li>
                                @endauth

                    <!--<li> <a href="{{ route('login')}}">Iniciar Sesión</a></li>-->
                            <!--Esto se puede eliminar-->
                            @if (Route::has('registro'))
                                <li><a href="{{ route('registro')}}">Registrarse</a></li>
                            @endif    
                </ul>
            </nav>
            
        </header>
        
           

        <main>
            @if (session('mensaje'))
                <div class='mensaje'>
                    {{ session('mensaje') }}
                </div>
            @endif 
            @yield('contenido')
            
            
            
        </main>
        <footer>
            
        </footer>
            <script src="{{ asset("js/main.js") }}">
           </script>
    </body>
</html>