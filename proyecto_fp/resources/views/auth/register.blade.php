@extends('layouts.base')

@section('titulo','Resgistrarse')
    <!-- Session Status -->
@section('contenido')

<h2>Registrarse como USER</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf


        <!--Name--> 
        <div>
            <label for="name"> Nombre</label>
            
            <input type='text' id='name' name="name" placeholder="Nombre...."/>
        </div>
        
        
        <!--Email Address--> 
        <div class="mt-4">
                        <label for="email"> email</label>

                        <input type='text' id='email' name="email" placeholder="Email...."/>

        </div>
         <!--Password--> 
        <div class="mt-4">
            <label for='password'>Password</label>
            <input type='password' id='password' name="password" placeholder="password...."/>
        </div>
         <div class="mt-4">
            <label for='password_confirmation'>Confirm Password</label>
            <input type='password' id='password_confirmation' name="password_confirmation" placeholder="password...."/>
        </div>

         <!--Confirm Password--> 
       

        <div class="flex items-center justify-end mt-4">
            <input type="submit" value='Registrarse'/>
        </div>
    </form>

@endsection