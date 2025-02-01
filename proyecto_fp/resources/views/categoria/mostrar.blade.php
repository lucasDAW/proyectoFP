@extends('layouts.base')
@section('titulo','Mostrando Categorias')
@section('contenido')
            
    
            <div class='autores'>
            @if (isset($categorias))
                    @foreach ($categorias as $categoria)
                        <div class='autor'>
                            <a href="{{route('detalleCategoriaAdmin',['categoria'=>$categoria->id])}}">
                                <h3>{{$categoria->nombre}}</h3>
                            </a>
                        </div>
                    @endforeach
            @endif
            </div>
       @endsection


