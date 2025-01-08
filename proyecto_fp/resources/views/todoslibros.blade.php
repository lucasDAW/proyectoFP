@extends('layouts.base')
@section('titulo','Inicio')
@section('contenido')
        <main class="mt-6">
            <a href='{{route('inicio')}}'> Volver a Inicio </a>
            <h3>Mostrando todos los libros</h3>
            <a href='{{route('publicarLibro')}}'> Nuevo Libro</a>
            
            @if (session('mensaje'))
                    <div class='alert alert-ok'>
                        {{ session('mensaje') }}
                    </div>
            @endif 
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
                                <!--<a href="/libro/editar/{{$l->id}}" class="detalle">Detalle Libro</a>-->
                                <a href="/libro/detalle/{{$l->id}}" class="detalle" >Detalle Libro</a>
                                <a href="/libro/editar/{{$l->id}}" class="editar" >Editar Libro</a>
                                <a href="/libro/borrar/{{$l->id}}" class="borrar" >Borrar Libro</a>
                                <!--<a href="/libro/editar/{{$l->id}}" class="borrar">Borrar Libro</a>-->
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </main>

       @endsection


