@extends('layouts.base')
@section('titulo','Contacto')
@section('contenido')
                <form method='post' action='{{route('contactoadminpost')}}'>
                <h3>Enviar correo</h3>
                    @csrf
                    <label from='destinatario'>Destinatario:</label>
                    <input type='text' id='destinatario' name='destinatario' value="dawlucas1993@gmail.com | Administración" disabled="true"/>
                    <label from='asunto'>Asunto:</label>
                    <input type='text' id='asunto' name='asunto' placeholder='Asunto...' autofocus/>
                    <label from='cuerpo'>Mensaje:</label>
                    <textarea id='cuerpo' name='cuerpo' placeholder='Cuerpo...' rows='8'></textarea>
                    <input type='hidden' value='true' id='contactoadministracion' name='contactoadministracion'/>
                    <input type='submit' value="Enviar"/>
                </form>
@endsection
