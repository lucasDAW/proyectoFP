@extends('layouts.base')

@section('titulo','Resgistrarse')
    <!-- Session Status -->
@section('contenido')
@auth
<h2>Modificar Usuario</h2>
@endauth
@guest
<h2>Registrarse</h2>
@endguest
    <form method="POST" action="{{ route('registro') }}">
        @csrf


        <!--Name--> 
        <div>
            <x-input-label for="name" :value="__('Name')" />
            @auth
                <x-text-input id="name"  type="text" name="name" value="{{Auth::user()->name}}" required autofocus autocomplete="name" />
            @endauth
            @guest
            <x-text-input id="name"  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @endguest
            <x-input-error :messages="$errors->get('nombre')" />
        </div>
        
        
        <!--Email Address--> 
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            @auth
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{Auth::user()->email}}" required autocomplete="username" />
            @endauth
            @guest
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            @endguest
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
         <!--Password--> 
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

         <!--Confirm Password--> 
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @guest
                <a href="{{ route('login') }}">{{ __('Already registered?')}}</a>
                <x-primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-primary-button>
            @endguest
            @auth
            <input type="hidden" id='id_usuario' value='{{Auth::user()->id}}' name='id_usuario'/>
            <x-primary-button class="ms-4">
                {{ __('Modificar Usuario') }}
            </x-primary-button>
            @endauth
        </div>
    </form>
@endsection