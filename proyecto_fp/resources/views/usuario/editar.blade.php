@extends('layouts.base')
@if(isset($usuario))
    @section('titulo','Modificar Usuario')
@else
    @section('titulo','Resgistrarse')
@endif
    <!-- Session Status -->
@section('contenido')

   
    <form method="POST" action="{{route('actualizarperfil')}}">
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
        <legend>
            @if(isset($usuario))
                <p>Modificar USUARIO como ADMIN</p>
            @else
                <p>Modificar USUARIO</p>
            @endisset
        </legend>
        @csrf
        <!--Name--> 
        <div>
            <label for="nombre"> Nombre</label>
            @if (isset($usuario))
                <input type='text' id='nombre' name="nombre" placeholder="Nombre...." value="{{$usuario->nombre}}"/>
            @else
                <input type='text' id='nombre' name="nombre" placeholder="Nombre...." value="{{Auth::user()->nombre}}"/>
            @endif
        </div>
        
        <!--Email Address--> 
        <div class="mt-4">
            <label for="email"> email</label>
            @if (isset($usuario))
                <input type='text' id='email' name="email" placeholder="Email...." value="{{$usuario->email}}"/>
            @else
                <input type='text' id='email' name="email" placeholder="Email...." value="{{Auth::user()->email}}"/>
            @endif
        </div>
         <!--Password--> 
        <div class="mt-4">
            <label for='password'>Contraseña</label>
            <input type='password' id='password' name="password" placeholder="password...."/>
        </div>
         <!--Confirm Password--> 
         <div class="mt-4">
            <label for='password_confirmation'>Confirmar Contraseña</label>
            <input type='password' id='password_confirmation' name="password_confirmation" placeholder="password...."/>
        </div>

       

        <div class="btn">
            <div>
                
            <input type="submit" value='Editar Perfil'/>
            </div>
            @if (isset($usuario))
                <input type="hidden" name='id_usuario' id='id_usuario' value='{{$usuario->id}}'/>
                <div class='botones_formulario'>
                    <a  href='{{route('eliminarperfil',['id_usuario'=>$usuario->id])}}'/><span>Eliminar usuario</span><span>&#9760;</a>
                    <a  href='{{route('adminhaceradminUsuario',['user'=>$usuario])}}'/>Hacer Administrador</a>
                </div>
            @endif
        </div>
    </form>
@endsection