@extends('layouts.base')
@section('titulo','Mi perfil')

@section('contenido')
                        @if ($user)
                       
                        <div class="miperfil misdatos">
                            <h3>Mis datos</h3>
                            <!--<button class="botoneditar">Editar mis datos</button>-->
                            <label class="switch botoneditar">
                                <!--<label>Editar</label>-->
                                <input type="checkbox" >
                                <span class="slider round"></span>
                             </label>
                            <ul>
                                <li>Nombre: {{$user->name}}</li>
                                <li>Email: {{$user->email}}</li>
                            </ul>
                            
                            <!--formulario de edicion de perfil-->
                           
                            <form method="POST" action="{{route('actualizarperfil')}}" class="miperfil hidden formulario">
                                <legend>
                                    <h4 class="hidden">Editar perfil</h4>
                                </legend>
                                @csrf
                                <!--Name--> 
                                <div>
                                    <label for="name"> Nombre</label>
                                    <input type='text' id='name' name="name" placeholder="Nombre...." value="{{Auth::user()->name}}"/>
                                </div>
                                 <!--Password--> 
                                <div class="mt-4">
                                    <label for='password'>Password</label>
                                    <input type='password' id='password' name="password" placeholder="password...."/>
                                </div>
                                 <!--Confirm Password--> 
                                 <div class="mt-4">
                                    <label for='password_confirmation'>Confirm Password</label>
                                    <input type='password' id='password_confirmation' name="password_confirmation" placeholder="password...."/>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <input type="submit" value='Editar Perfil'/>
                                </div>
                            <a href="{{route('eliminarperfil')}}" class="btn_eliminarusuario">Eliminar Usuario</a>
                            </form>
                        </div>
                        
                        @endif
                       
                       
                        
               

@endsection
  
