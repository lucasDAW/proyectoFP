@extends('layouts.base')
@section('titulo','Mi perfil de Usuario')

@section('contenido')
                        @if ($usuario)
                        <div class="misdatos">
                            <div class="miperfil">
                                <h3>Mis datos</h3>
                                <!--<button class="botoneditar">Editar mis datos</button>-->
                                <label class="switch botoneditar">
                                    <!--<label>Editar</label>-->
                                    <input type="checkbox" >
                                    <span class="slider round"></span>
                                 </label>
                                <ul>
                                    <li>Nombre: {{$usuario->nombre}}</li>
                                    <li>Email: {{$usuario->email}}</li>
                                </ul>

                                <!--formulario de edicion de perfil-->

                                <form method="POST" action="{{route('actualizarperfil')}}" class="miperfil hidden formulario">
                                    <legend>
                                        <h4 class="hidden">Editar perfil</h4>
                                    </legend>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif 
                                    @csrf
                                    <!--Name--> 
                                    <div>
                                        <label for="nombre"> Nombre</label>
                                        <input type='text' id='nombre' name="nombre" placeholder="Nombre...." value="{{Auth::user()->nombre}}"/>
                                    </div>
                                    <!--email--> 
                                    <div>
                                        <label for="email"> Email</label>
                                        <input type='mail' id='email' name="email" placeholder="Email...." value="{{Auth::user()->email}}"/>
                                    </div>
                                     <!--Password--> 
                                    <div class="mt-4">
                                        <label for='password'>Contraseña</label>
                                        <input type='password' id='password' name="password" placeholder="Contraseña...."/>
                                    </div>
                                     <!--Confirm Password--> 
                                     <div class="mt-4">
                                        <label for='password_confirmation'>Confirmar Contraseña</label>
                                        <input type='password' id='password_confirmation' name="password_confirmation" placeholder="Contraseña...."/>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <input type="submit" value='Editar Perfil'/>
                                    </div>
                                <a href="{{route('eliminarperfil')}}" class="btn_eliminarusuario">Eliminar Usuario</a>
                                </form>
                            </div>

                            @if ($usuario->comentarios and count($usuario->comentarios)>0)
                            <div class="comentarios miperfil">
                                <h3> mis Comentarios</h3>
                                 <table class="tabla_comentarios">
                                    <thead>
                                        <tr>
                                            <th>Comentario</th>
                                            <th>Libro</th>
                                            <th></th>
                                            <th></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuario->comentarios as $c)
                                        <tr>
                                            <td>{{$c->comentario}}</td>
                                            <td>{{$c->libro->titulo}}</td>
                                            <td>
                                                <div class='accionesadmin '>
                                                    <a href='{{route('detallelibro',['libro'=>$c->libro->id])}}'>Ver Libro</a>
                                                </div>
                                            </td>
                                            <td>
                                                  <div class='accionesadmin '>
                                                    <a href="{{route('eliminarComentario',['comentario'=>$c->id])}}" class="borrar" >Eliminar</a>
                                                  </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @if ($usuario->valoraciones and count($usuario->valoraciones)>0)
                            <div class="valoraciones miperfil">
                                <h3>Mis Valoraciones</h3>
                                 <table class="tabla_comentarios">
                                    <thead>
                                        <tr>
                                            <th>Calificación</th>
                                            <th>Libro</th>
                                            <th>Fecha</th>
                                            <th></th>
                                            <th></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($usuario->valoraciones as $c)
                                        <tr>
                                            <td>{{$c->calificacion}}</td>
                                            <td>{{$c->titulo}}</td>
                                            <td>{{$c->created_at}}</td>
                                            <td>
                                                <div class='accionesadmin '>
                                                    <a href='{{route('detallelibro',['libro'=>$c->libro_id])}}'>Ver Libro</a>
                                                </div>
                                            </td>
                                            <td>
                                                  <div class='accionesadmin '>
                                                    <a href="{{route('calificarLibro',['comentario_id'=>$c->id])}}" class="borrar" >Eliminar</a>
                                                  </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @else

                            <p>NO existe el usuario</p>
                           </div>
                    @endif
                        
                       
                       
                        
               

@endsection
  
