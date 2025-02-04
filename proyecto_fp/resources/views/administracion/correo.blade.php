@extends('administracion.index')

                @section('accion')
                <form method='post' action='{{route('enviarcorreoadminpost')}}'>
                    <legend>Enviar correo</legend>
                    @csrf
                    <label from='destinatario'>Destinatario:</label>
                    <input type='text' id='destinatario' name='destinatario' value="{{$usuario->email}} - {{$usuario->nombre}}" disabled="true"/>
                    <label from='asunto'>Asunto:</label>
                    <input type='text' id='asunto' name='asunto' placeholder='Asunto...' autofocus/>
                    <label from='cuerpo'>Mensaje:</label>
                    <textarea id='cuerpo' name='cuerpo' placeholder='Cuerpo...' rows='8'></textarea>
                    <input type='hidden' value='{{$usuario}}' id='usuario' name='usuario'/>
                    <input type='submit' value="Enviar"/>
                </form>
@endsection
