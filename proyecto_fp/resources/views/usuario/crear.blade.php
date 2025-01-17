<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inicio</title>
        
        <style>
            .enlaces{
                display: flex;
                flex-direction: row;
                margin: 10px;
            }
            .enlaces a{
                text-decoration: none;
                color: #e5c444;
                background: black;
                margin: 5px 0px;
                width: 120px;
                padding: 5px 10px;
                box-shadow: 3px -3px 0px red;
                transition: 0.4s ease-in-out

            }
            .enlaces a:hover:nth-child(1){
                background: white;
                color:blue;

            }
            .enlaces a:hover{
                box-shadow: 0px -0px 0px red;
                color: red;
                background: white;
                outline:2px solid black;
                
            }
            .enlaces a:hover:nth-child(even){
            
        </style>

    </head>
    <body class="font-sans antialiased">
           
                    <header>
                        
                            <nav class="-mx-3 flex flex-1 justify-end">
                            </nav>
                    </header>

                    <main class="mt-6">
                        <h3>Crear Usuario</h3>
                        <div class='enlaces'>
                            
                            <a href='{{route('page2')}}'> Enlace a pagina </a>
                            <a href='{{route('todoslibros')}}'> Mostrar todos los libros</a>
                            <a href='{{route('crearUsuario')}}'> Crear Usuario</a>
                        </div>
                    </main>

                    
          
    </body>
</html>