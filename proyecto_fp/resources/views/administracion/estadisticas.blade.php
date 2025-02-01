
@extends('administracion.index')
@section('titulo','Panel de administración - Estadísticas')

@section('accion')
    
    <div class='estadisticas_contenido'>
        @isset($opcion)
            <h2>Mostrando las estadisticas de {{$opcion}}</h2>

         <table class="tabla_estadisticas">
          <thead>
              <tr>
                  <th>Titulo</th>
                  <th>Autor</th>
                  <th>Total {{$opcion}}</th>
                  <th></th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach($libros as $libro)
              <tr>
                  <td>{{$libro->titulo}}</td>
                  <td>{{$libro->autor}}</td>
                  <td>{{$libro->Total}}</td>
                  <td>
                      <div class='accionesadmin '>
                          <a href='{{route('detallelibro',['libro'=>$libro->id])}}'>Ver Libro</a>
                      </div>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
        @endisset
    </div>
@endsection

