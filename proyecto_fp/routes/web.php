<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;

use App\Http\Controllers\EmailController;


Route::get('/', function () {
    return view('index');
});


Route::get('/',function () {
    return view('index');})->name('inicio');

Route::get('/page2',function () {
    return view('page2');})->name('page2');
    
//    LIBRO
//READ    
//Route::get('/libros',[LibroController::class,'index'])->name('todoslibros');
Route::prefix('libros')->group(function () {
    
    Route::get('/inicio',[LibroController::class,'index'])->middleware(['verified'])->name('todoslibros');
    
    Route::get('/busqueda',[LibroController::class,'busquedavista'])->name('busquedalibros');
    Route::post('/busqueda',[LibroController::class,'busqueda']);
//    Route::get('/libro/detalle/{libro}',[LibroController::class,'detalle'])->name('detallelibro');
//    Route::get('/libro/busqueda',[LibroController::class,'busqueda'])->name('busquedalibro');
//    Route::post('/libro/busqueda',[LibroController::class,'busquedaBBDD'])->name('busquedaBBDD');
    Route::get('/detalle/{libro}',[LibroController::class,'detalle'])->name('detallelibro');
//    Route::get('/busqueda',[LibroController::class,'busqueda'])->name('busquedalibro');
//    Route::post('/busqueda',[LibroController::class,'busquedaBBDD'])->name('busquedaBBDD');
    
    
});
////CREATE
//Route::get('/publicar',[LibroController::class,'crearVistaLibro'])->name('publicarLibro');
//Route::post('/publicando',[LibroController::class,'publicarlibro'])->name('publicar');
////UPDATE





//  USUARIO

Route::get('/create',[RegisteredUserController::class,'create'])->name('crearUsuario');
Route::middleware('auth')->group(function () {
    Route::post('/user/libro/listadeseos',[UsuarioController::class,'addlistadeseos'])->name('agregalistadeseos');
    Route::get('/user/listadeseos',[UsuarioController::class,'showlistadeseos'])->name('verdeseos');
    Route::get('/miperfil',[UsuarioController::class,'show'])->name('verUsuario');
    Route::get('/usuario/mispublicaciones',[UsuarioController::class,'showMispublicaciones'])->name('mipublicaciones');


    Route::get('/perfil/editar', [UsuarioController::class, 'editarperfil'])->name('editarperfil');
    Route::post('/perfil/editar/editar', [UsuarioController::class, 'modificarperfil'])->name('actualizarperfil');
    Route::get('/perfil/eliminar/{id?}', [UsuarioController::class, 'eliminar'])->name('eliminarperfil');
    Route::post('/perfil/eliminando', [UsuarioController::class, 'eliminarbbdd'])->name('confirmareliminarusuario');

    
//    LIBROS
    Route::get('/libro/editar/{libro}',[LibroController::class,'editar'])->name('editarlibro');
//    Route::get('/usuario/administracion/libros/{admin}' ,[LibroController::class,'index'])->name('libros');

//  //DELETE
    Route::get('/libro/borrar/{id}',[LibroController::class,'borrar'])->name('borrarlibroBBDD');
    Route::post('/libro/borrar/confirmar',[LibroController::class,'borrarBBDD'])->name('confirmareliminar');
    
    
//  routes que solo pueden acceder los usuario con el rol admin        
    Route::get('/usuario/administracion', [UsuarioController::class, 'accionesAdmin'])->name('inicioadmin');
    Route::get('/usuario/administracion/usuarios', [UsuarioController::class, 'showall'])->name('vertodosUsuarios');
    Route::post('/usuario/administracion/usuarios', [UsuarioController::class, 'showall'])->name('vertodosUsuariospost');
    Route::get('/usuario/administracion/usuarios/modificar/{id}', [UsuarioController::class, 'modificar'])->name('adminmodificarUsuario');
    Route::get('/usuario/administracion/usuarios/enviar/{user_id}', [UsuarioController::class, 'enviarCorreoform'])->name('enviarcorreoadmin');
    Route::post('/usuario/administracion/usuarios/enviar', [UsuarioController::class, 'enviarCorreo'])->name('enviarcorreoadminpost');
    Route::get('/usuario/administracion/usuarios/modificar/hacer_admin/{user}', [UsuarioController::class, 'hacerAdmin'])->name('adminhaceradminUsuario');
    Route::get('/usuario/administracion/usuarios/interacciones/{id_usuario}', [UsuarioController::class, 'mostrarInteracciones'])->name('interaccionesUsuario');
    Route::post('/usuario/administracion/usuario/busqueda', [UsuarioController::class, 'busquedaAdmin'])->name('busquedaaminuser');
    Route::get('/usuario/administracion/pedidos', [UsuarioController::class, 'verTodospedidos'])->name('verpedidosadmin');
    Route::get('/usuario/administracion/libros/mostrarlibros', [LibroController::class, 'indexAdmin'])->name('verlibrosAdminAll');
    Route::post('/usuario/administracion/libros/busqueda', [LibroController::class, 'busquedaAdmin'])->name('verlibrosAdmin');
    Route::post('/usuario/administracion/pedido/busqueda', [UsuarioController::class, 'busquedapedidoAdmin'])->name('verPedidoAdmin');
    
});

//Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});


//solo los usuarios que han iniciado sesisión pueden acceder a las rutas siguientes
Route::middleware('auth')->group(function () {
    
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
Route::post('/libro/comentar',[ComentarioController::class,'comentar'])->name('comentar');
Route::get('/comentario/borrar/{comentario}',[ComentarioController::class,'delete'])->name('eliminarComentario');
Route::post('/comentario/borrar/confirmar',[ComentarioController::class,'confirmarBorrado'])->name('confirmareliminarcomentario');

//  CALIFICACIONES

Route::get('/calificaciones', function () {
return view('calificacion.index');


});
//esto hay que cambiarlo a otro controller
Route::post('/libro/valorar',[ComentarioController::class,'valorar'])->name('valorar');
  
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

Route::get('/home', function () {
    return 'Esta página es solo para usuarios verificados';
})->middleware(['auth', 'verified']);
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']);
 require __DIR__.'/auth.php';
