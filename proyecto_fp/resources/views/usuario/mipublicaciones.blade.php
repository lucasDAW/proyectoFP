@extends('layouts.base')
@section('titulo','Lista deseos')
@section('contenido')
<div class="container mt-5">
  <h2>Mi Lista de libros publicados</h2>
</div>
@if ($libros)
        <table  class="lista_deseos">
            <thead>
                <tr>  
                    <th>Titulo</th>
                    <th>Autor</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
                    @foreach ($libros as $libro)
                            @isset($libro)
                        <tr>
                            <td>{{$libro->titulo}}</td>
                            <td>{{$libro->autor}}</td>
                            <td>{{$libro->precio}} €</td>
                            <td>
                                <a href='{{route('detallelibro',['libro'=>$libro->id])}}'>Ver</a>                                
                            </td>

                        </tr>
                            @endisset


                    @endforeach
                   
                        
            </tbody>
        </table>
       
   @else
        <h5>No has publicado ningún libro.</h5>
   @endif


@endsection