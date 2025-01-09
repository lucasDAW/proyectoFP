

<h4>Comentarios</h4><hr>

<form action='{{route("comentar")}}' method="post" class="comentarioform">
     @csrf
     <!--comentario-->
     <div>
        <label for="comentario">Comentario: </label>
 
        <input type="text" id='comentario' name="comentario" placeholder="Introduzca comentario...">
     </div>
        
        <input type='hidden' name='libro_id' id='libro_id' value='{{$libro->id}}'/>
        <input type='hidden' name='user_id' id='user_id' value='{{Auth::id()}}'/>
        <input type="submit" value="Comentar" class="boton"/>
   
 </form>
<div class='comentarios'>
    
    @if (isset($comentarios))

                <table>
                    <thead>
                        <tr>
                            <th>Id</th><th>Comentarios</th><th>autor</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comentarios as $comentario)
                        <tr>
                            <td>{{$comentario->id}}</td>
                            <td>{{$comentario->comentario}}</td>
                            <td>{{$comentario->name}}</td>

                            <td>
                                <div class="botones">
                            @auth
                               @if (Auth::user()->id==$comentario->user_id or Auth::user()->role=='admin')
                                <a href="/comentario/borrar/{{$comentario->id}}" class="borrar" >Borrar</a>
                               @endif
                            @endauth            
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    @else
        <p>No existen comentarios.</p>
    @endif
</div>
