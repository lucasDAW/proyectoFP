



<form action='{{route("comentar")}}' method="post" >
     @csrf
     <!--comentario-->
     <div>
        <label for="comentario">Comentario: </label>
        <textarea placeholder="Comentario" id='comentario' name="comentario" ></textarea>
     </div>
        
        <input type='hidden' name='libro_id' id='libro_id' value='{{$libro->id}}'/>
        <input type='hidden' name='user_id' id='user_id' value='{{Auth::id()}}'/>
        <input type="submit" value="Comentar" class="boton"/>
   
 </form>
<div class='comentarios'>
    @if (isset($comentarios))
    <h2>Comentarios</h2>
        @foreach ($comentarios as $comentario)
            <div class="comentario">
                        <p><strong>{{$comentario->name}}</strong>      | {{$comentario->comentario}} <span>
                                    @auth
                                        @if (Auth::user()->id==$comentario->user_id or Auth::user()->role=='admin')
                                            <a href="/comentario/borrar/{{$comentario->id}}" class="borrar" >Eliminar</a>
                                        @endif
                                    @endauth  
                                      </span>
                        </p>
            </div>
            
        @endforeach
    @else
        <p>No existen comentarios.</p>
    @endif
</div>
