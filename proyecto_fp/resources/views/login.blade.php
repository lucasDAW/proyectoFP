<!--@extends('layouts.base')
@section('titulo','Login')

@section('contenido')


                   
                        
    <h3>Iniciar sesion</h3>
    <form action='#' method="post" class="publicarLibro">
     @csrf
     titulo
     <div>
        <label for="email">Email: </label>
        <input type="text" id='email' name="email" placeholder="Introduzca email...">       
     </div>
     <div>
        <label for="password">Password: </label>
        <input type="password" id='password' name="password" placeholder="Introduzca password...">       
     </div>
     
     </div>
     
        
        <input type="submit" value="Iniciar Sesión" class="boton"/>
        
 </form>
                  <a href="{{ route('registro')}}">Registrarse</a>      
                    

@endsection
  -->
