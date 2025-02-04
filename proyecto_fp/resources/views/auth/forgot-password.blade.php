@extends('layouts.base')
@section('titulo','Recuperar contraseña')
@section('contenido')
<x-guest-layout>

    
    <form method="POST" action="{{ route('password.email') }}">
        <legend>{{ __('Email de recuperación') }}</legend>
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div >
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection
