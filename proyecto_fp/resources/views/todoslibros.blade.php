<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Todos los libros</title>

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">

        <header>

            <nav class="-mx-3 flex flex-1 justify-end">
            </nav>
        </header>

        <main class="mt-6">
            <a href='{{route('inicio')}}'> Volver a Inicio </a>
            <h3>Mostrando todos los libros</h3>
            <a href='{{route('nuevolibro')}}'> Nuevo Libro</a>
            @if ($libros)


            
            <table>
                <thead>
                    <tr>
                        <th>Id</th><th>titulo</th><th>Descripcion</th><th>Autor</th><th>Número Páginas</th><th>ISBN</th><th>Fecha lanzamiento</th><th>Precio</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($libros as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->titulo}}</td>
                        <td>{{$l->descripcion}}</td>
                        <td>{{$l->autor}}</td>
                        <td>{{$l->numero_paginas}}</td>
                        <td>{{$l->ISBN}}</td>
                        <td>{{$l->fecha_lanzamiento}}</td>
                        <td>{{$l->precio}}</td>
                        <td>
                            <div class="botones">
                                <a href="/ubicaciones/{{$l->id}}" class="detalle">Detalle Ubicación</a>
                                <a href="/ubicaciones/{{$l->id}}/edit" class="editar" >Editar Ubicación</a>
                                <a href="/ubicaciones/{{$l->id}}/destroyconfirm" class="borrar">Borrar Ubicación</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </main>

        <footer >
            <p>Lucas Antonio Muñoz Albertos
        </footer>

    </body>
</html>
<?php

