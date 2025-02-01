<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EmailController;


use Illuminate\Support\Facades\Cookie;


Route::get('/',function () {    

return redirect()->route('todoslibros');})->name('inicio');

//Cookies
Route::get('/cookies',function(){
    Cookie::queue('primera_visita', true, 1*60*24*31);//1 hora
//    var_dump(Cookie::get('primera_visita'));
//    exit();
    return redirect()->route('todoslibros');

})->name('cookies');
Route::get('/politica-privacidad',function(){
    
            return view('administracion.privacidad');

})->name('privacidad');
//CONTACTO
Route::get('/contacto',function(){
            return view('usuario.contacto');

})->name('contactoadmin');
//Terminos de servicio
Route::get('/terminos-servicio',function(){
            return view('administracion.terminos');

})->name('terminos-servicio');
Route::post('/contacto',[UsuarioController::class,'contactoCorreo'])->name('contactoadminpost');

Route::get('/politica-cookies',function(){
    return view('administracion.cookies');
})->name('vercookies');
//LIBRO
//READ    
//Route::get('/libros',[LibroController::class,'index'])->name('todoslibros');
Route::prefix('libros')->group(function () {
    
    Route::get('/inicio',[LibroController::class,'index'])->name('todoslibros');
    
    Route::get('/busqueda',[LibroController::class,'busquedavista'])->name('busquedalibros');
    Route::post('/busqueda',[LibroController::class,'busqueda']);
    Route::get('/detalle/{libro}',[LibroController::class,'detalle'])->name('detallelibro');
    
    
});

//AUTORES

Route::get('/autor/',[AutorController::class,'index'])->name('mostrarAutores');
Route::post('/autor/',[AutorController::class,'index']);
Route::get('/autor/detalles/{autor}',[AutorController::class,'show'])->name('verAutor');
Route::middleware('auth')->group(function () {
    Route::get('/autor/crear/{autor?}',[AutorController::class,'create'])->name('crearAutor');
    
    Route::post('/autor/guardar',[AutorController::class,'store'])->name('guardarAutor');
    Route::get('/autor/eliminar/{autor}',[AutorController::class,'destroy'])->name('eliminarAutor');
});
//CATEGORÍAS 
Route::get('/categoria', [CategoriaController::class, 'mostrarTodasCategorias'])->name('mostrarCategorias');
Route::get('/categoria/detalles/{categoria}', [CategoriaController::class, 'show'])->name('detalleCategoriaAdmin');


//  USUARIO
Route::middleware('auth')->group(function () {
    Route::post('/usuario/libro/listadeseos',[UsuarioController::class,'addlistadeseos'])->name('agregalistadeseos');
    Route::get('/usuario/listadeseos',[UsuarioController::class,'showlistadeseos'])->name('verdeseos');
    Route::get('/miperfil/{usuario_id}',[UsuarioController::class,'show'])->name('verUsuario');
    Route::get('/usuario/mispublicaciones',[UsuarioController::class,'showMispublicaciones'])->name('mipublicaciones');
    //calificar libro
    Route::match(['get', 'post'],'/usuario/libro/valorar/{comentario_id?}',[UsuarioController::class,'calificarLibro'])->name('calificarLibro');

    Route::get('/perfil/editar', [UsuarioController::class, 'editarperfil'])->name('editarperfil');
    Route::post('/perfil/editar/editar', [UsuarioController::class, 'modificarperfil'])->name('actualizarperfil');
    Route::get('/perfil/eliminar/{id?}', [UsuarioController::class, 'eliminar'])->name('eliminarperfil');
    Route::post('/perfil/eliminando', [UsuarioController::class, 'eliminarbbdd'])->name('confirmareliminarusuario');

    
//    LIBROS
    Route::get('/libro/editar/{libro}',[LibroController::class,'editar'])->name('editarlibro');
//  //DELETE
    Route::get('/libro/borrar/{id}',[LibroController::class,'borrar'])->name('borrarlibroBBDD');
    Route::post('/libro/borrar/confirmar',[LibroController::class,'borrarBBDD'])->name('confirmareliminar');
    
    
    //  routes que solo pueden acceder los usuario con el rol admin    
    Route::prefix('/usuario/administracion')->group(function () {    
        Route::get('/', [UsuarioController::class, 'accionesAdmin'])->name('inicioadmin');
        Route::get('/usuarios', [UsuarioController::class, 'showall'])->name('vertodosUsuarios');
        Route::post('/usuarios', [UsuarioController::class, 'showall'])->name('vertodosUsuariospost');
        Route::get('/usuarios/modificar/{id}', [UsuarioController::class, 'modificar'])->name('adminmodificarUsuario');
        Route::get('/usuarios/enviar/{user_id}', [UsuarioController::class, 'enviarCorreoform'])->name('enviarcorreoadmin');
        Route::post('/usuarios/enviar', [UsuarioController::class, 'enviarCorreo'])->name('enviarcorreoadminpost');
        Route::get('/usuarios/modificar/hacer_admin/{user}', [UsuarioController::class, 'hacerAdmin'])->name('adminhaceradminUsuario');
        Route::get('/usuarios/interacciones/{id_usuario}', [UsuarioController::class, 'mostrarInteracciones'])->name('interaccionesUsuario');
        Route::post('/usuario/busqueda', [UsuarioController::class, 'busquedaAdmin'])->name('busquedaaminuser');
        Route::get('/pedidos', [UsuarioController::class, 'verTodospedidos'])->name('verpedidosadmin');
        Route::get('/libros/', [LibroController::class, 'indexAdmin'])->name('verlibrosAdminAll');
        Route::post('/libros/busqueda', [LibroController::class, 'busquedaAdmin'])->name('verlibrosAdmin');
        Route::post('/pedido/busqueda', [UsuarioController::class, 'busquedapedidoAdmin'])->name('verPedidoAdmin');
        //categorias
        Route::get('/categorias', [UsuarioController::class, 'showCategorias'])->name('verCategoriasAdmin');
        //autores
        Route::get('/autores', [AutorController::class, 'showAutores'])->name('verAutoresAdmin');
        Route::post('/autores/busqueda/',[AutorController::class,'showAutores']);
        Route::get('/autores/corregir', [AutorController::class, 'corregirAutores'])->name('corregirAutoresAdmin');

        //categorias
        Route::get('/categoria', [CategoriaController::class, 'index'])->name('verCategoriaAdmin');
        Route::get('/categoria/crear/{categoria?}', [CategoriaController::class, 'create'])->name('crearCategoriaAdmin');
        Route::post('/categoria/guardar', [CategoriaController::class, 'store'])->name('guardarCategoriaAdmin');
        Route::get('/categoria/eliminar/{categoria}', [CategoriaController::class, 'destroy'])->name('eliminarCategoriaAdmin');
        //estadisticas
        Route::get('/estadisticas', [UsuarioController::class, 'estadisticas'])->name('verestadisticasAdmin');
        Route::get('/estadisticas/{opcion}', [LibroController::class, 'estadisticas'])->name('verestadisticasAdminopciones');

    });
});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


//solo los usuarios que han iniciado sesisión pueden acceder a las rutas siguientes
Route::middleware('auth')->group(function () {
//    LIBROS
    //CREATE
    Route::get('/publicar',[LibroController::class,'crearVistaLibro'])->name('publicarvista');
    Route::post('/publicando',[LibroController::class,'publicarlibro'])->name('publicar');
        //UPDATE
    Route::get('/libro/editar/{libro}', [LibroController::class, 'editar'])->name('editarlibro');

    //DELETE
        Route::get('/libro/borrar/{libro}', [LibroController::class, 'borrar'])->name('borrar');
        Route::post('/libro/borrar/confirmar', [LibroController::class, 'borrarBBDD'])->name('confirmareliminar');



});
    
    
//    COMENTARIOS 
Route::post('/libro/comentar/{comentario_id?}',[ComentarioController::class,'comentar'])->name('comentar');
Route::get('/libro/comentar/{comentario}',[ComentarioController::class,'editarComentario'])->name('editarcomentario');
Route::get('/comentario/borrar/{comentario}',[ComentarioController::class,'delete'])->name('eliminarComentario');
Route::post('/comentario/borrar/{comentario}',[ComentarioController::class,'confirmarBorrado'])->name('confirmareliminarcomentario');

//  CALIFICACIONES
//
//Route::get('/calificaciones', function () {
//return view('calificacion.index');
//
//
//});
//esto hay que cambiarlo a otro controller

  
//carrito
Route::get('/carrito/{libro}',[CarritoController::class,'add'])->name('addCarrito');
Route::get('/carrito',[CarritoController::class,'showTabla'])->name('mostrarTabla');
Route::get('/carrito/mostrar',[CarritoController::class,'showProduct'])->name('mostrarcarrito');
Route::get('/carrito-vaciar',[CarritoController::class,'vaciarcarrito'])->name('vaciar');
Route::get('/carrito/{id?}/unidadmas',[CarritoController::class,'aumentar'])->name('aumentar_unidad');
Route::get('/carrito/{id?}/unidadmenos',[CarritoController::class,'descrementar'])->name('decrementar_unidad');
Route::get('/carrito/{id?}/borrar',[CarritoController::class,'eliminarlibro'])->name('borrarlibro');
Route::delete('borrar-de-carrito', [CarritoController::class, 'borrarProducto']);

// Compra
Route::get('/compra',[CompraController::class,'confirmarPedido'])->name('confirmarcompra');
Route::post('/compra/confirmar',[CompraController::class,'realizarcompra'])->name('realizarcompra');


//pedidos
Route::get('/pedido',[CompraController::class,'mostrarPedido'])->name('mostrarPedidos');
Route::get('/pedidos/{id}',[CompraController::class,'verPedidos'])->name('verpedidos');
Route::get('/pedidos/libros/{compra_id}',[CompraController::class,'verLibrosPedido'])->name('verlibrospedido');


//correos
Route::get('/send-welcome-email',[EmailController::class,'sendWelcomeEmail']);
//pdf-facturas
Route::post('/factura/consulta',[EmailController::class,'sendFactura'])->name('facturaorden');

//prueba de subir archivos
Route::get('/libro/subir',[LibroController::class,'publicar'])->name('subirarchivo');
Route::post('/libro/subir',[LibroController::class,'subir'])->name('almacenandoarchivo');
Route::post('/libro/bajar',[LibroController::class,'bajar'])->name('descargar');

//Route::get('/nuevoregistro',[UsuarioController::class,'crear'])->name('registrousuairo');

//ver factura
Route::get('/factura/ver',
        function(){
    
//    return view('emails.factura');
    return view('emails.admin');
        })->name('verfactura');

        
Route::get('documentos',[LibroController::class,'leerdocumento'])->name('leerdocumentos');
    



//verificacion por email

//Route::get('/home', function () {
//    return 'Esta página es solo para usuarios verificados';
//})->middleware(['auth', 'verified']);
//Route::get('/', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified']);
 require __DIR__.'/auth.php';
