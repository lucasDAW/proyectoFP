@extends('layouts.base')

@section('contenido')
<a href="{{route('subirarchivo')}}">Subir archivo</a>
<a href="{{route('verfactura')}}">Ver ejemplo factura</a>
<a href="{{route('leerdocumentos')}}">Ver Documentos</a>
<p class="mensaje">ejempo de mendajes</p>
@endsection