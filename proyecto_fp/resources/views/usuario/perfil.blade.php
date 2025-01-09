@extends('layouts.base')
@section('titulo','Mi perfil')

@section('contenido')


                   
                        <h3>Mi perfil</h3>
                        
                        
                        @if ($user)
                        <p>El usuario existe</p>
                        
                        {{$user}}
                        @endif
                       
                       
                        
               
               <a href="{{route('todoslibros')}}">Volver</a>

@endsection
  
