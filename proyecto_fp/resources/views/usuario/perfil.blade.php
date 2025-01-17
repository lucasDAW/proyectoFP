@extends('layouts.base')
@section('titulo','Mi perfil')

@section('contenido')


                   
                        <h3>Mi perfil</h3>
                        
                        
                        @if ($user)
                        <div class="acciones_usuario">
                            <div>
                                <a href="#">Mis lista de deseos</a>
                            </div>
                            <div>
                                <a href="#">Mis comentario</a>
                            </div>
                            <div>
                                <a href="{{route('registro')}}">Editar mi perfil</a>
                            </div>
                        </div>
                        
                        
                        @endif
                       
                       
                        
               
               <a href="{{route('todoslibros')}}">Volver</a>

@endsection
  
