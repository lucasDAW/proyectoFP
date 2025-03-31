



<form action='{{route("comentar")}}' method="post" >
     @csrf
     <!--comentario-->
     <div>
        <label for="comentario">Comentario: </label>
        <textarea placeholder="Comentario" id='comentario' name="comentario" ></textarea>
     </div>
        
        <input type='hidden' name='libro_id' id='libro_id' value='{{$libro->id}}'/>
        <input type="submit" value="Comentar" class="boton"/>
   
 </form>
<div class='comentarios'>
    @if (isset($comentarios))
    <h2>Comentarios</h2>
        @foreach ($comentarios as $comentario)
            <div class="comentario">
                <p><strong>{{$comentario->name}}</strong>
                    <span class='fecha-comentario'>{{$comentario->fecha}}<?php gettype($comentario->fecha) ?></span>
                   
                   <span>{{$comentario->comentario}}</span> 
                   <span class='btn-comentario'>
                        @auth
                            @if (Auth::user()->id==$comentario->usuario_id or Auth::user()->rol==2)
                                <a href="{{route('eliminarComentario',['comentario'=>$comentario->id])}}" class="borrar" >Eliminar</a>
                                <a href="{{route('editarcomentario',['comentario'=>$comentario->id])}}" class="borrar" >Editar</a>
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
