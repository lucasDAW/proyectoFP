<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href='{{ asset("image/icono.ico") }}' type="image/x-icon">
    <link rel='stylesheet' href='{{ asset("css/estilos.css") }}'>


    <title>SENECALIB - @yield('titulo')</title>
        <style>
         
            
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <header>
                        
                            <nav class="-mx-3 flex flex-1 justify-end">
                                <div class='enlaces'>
                            
                            <a href='{{route('page2')}}'> Volver </a>
                            <a href='{{route('todoslibros')}}'> Mostrar todos los libros</a>
                        </div>
                            </nav>
                    </header>

    
    @yield('contenido')

    </body>
</html>