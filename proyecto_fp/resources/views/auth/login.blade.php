@extends('layouts.base')
@section('titulo','Iniciar Sesión')
    <!-- Session Status -->
@section('contenido')
<div class='login'>
    

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            </label>
        </div>

        <div class="btn">

            <x-primary-button class="inputsubmit">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">{{ __('¿Olvido su contraseña?') }}</a>
            @endif
        </div>
                  <a href="{{ route('register')}}" class='registrarse'>Registrarse</a>      
    </form>



</div>
@endsection