@extends('layouts.base')

@section('titulo','Resgistrarse')
    <!-- Session Status -->
@section('contenido')

    <form method="POST" action="{{ route('register') }}">
        <legend>Registrarse</legend>    
        @csrf
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 
        <!--Name--> 
        <div>
            <label for="nombre"> Nombre</label>
            
            <input type='text' id='nombre' name="nombre" placeholder="Nombre...."/>
        </div>
        <!--Email Address--> 
        <div>
            <label for="email"> email</label>
            <input type='text' id='email' name="email" placeholder="Email...."/>
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

        <div>
            <input type="submit" value='Registrarse'/>
        </div>
    </form>

@endsection