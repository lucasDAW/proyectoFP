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

//INICIO ver todos los libros

Route::get('/',[LibroController::class,'index'])->name('todoslibros');

//LIBROS
Route::prefix('/libro')->group(function () {
//    Route::get('/inicio',[LibroController::class,'index'])->name('todoslibros');
//    Route::get('/busqueda',[LibroController::class,'busquedavista'])->name('busquedalibros');
//    busqueda mediante input text sin cargr nueeva pagina solo con javascript
    Route::post('/busqueda',[LibroController::class,'busqueda']);
//    detalle del libro
    Route::get('/detalle/{libro}',[LibroController::class,'detalle'])->name('detallelibro');
    
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
});

//AUTORES
Route::get('/autor/',[AutorController::class,'index'])->name('mostrarAutores');
//    busqueda mediante input text sin cargr nueeva pagina solo con javascript
Route::post('/autor/',[AutorController::class,'index']);
//detalles del autor
Route::get('/autor/detalles/{autor}',[AutorController::class,'show'])->name('verAutor');
//solo pueden entrar los que hacen login
Route::middleware('auth')->group(function () {
//    vista crear autor
    Route::get('/autor/crear/{autor?}',[AutorController::class,'create'])->name('crearAutor');
    //guardar autor en la base de datos
    Route::post('/autor/guardar',[AutorController::class,'store'])->name('guardarAutor');
    //eliminar autor
    Route::get('/autor/eliminar/{autor}',[AutorController::class,'destroy'])->name('eliminarAutor');
});
//CATEGORÍAS 
Route::get('/categoria', [CategoriaController::class, 'mostrarTodasCategorias'])->name('mostrarCategorias');
Route::get('/categoria/detalles/{categoria}', [CategoriaController::class, 'show'])->name('detalleCategoriaAdmin');


//  USUARIO
Route::middleware('auth')->group(function () {
    //lista de deseos
    Route::get('/usuario/listadeseos',[UsuarioController::class,'showlistadeseos'])->name('verdeseos');
    Route::post('/usuario/libro/listadeseos',[UsuarioController::class,'addlistadeseos'])->name('agregalistadeseos');
    Route::get('/usuario/listadeseos/{id}',[UsuarioController::class,'borrarlibrolistadeseos'])->name('borrarlibrolistadeseos');
//    ver perfil usuario
    Route::get('/miperfil/{usuario_id}',[UsuarioController::class,'show'])->name('verUsuario');
//    publicaciones del usuario
    Route::get('/usuario/mispublicaciones',[UsuarioController::class,'showMispublicaciones'])->name('mipublicaciones');
    //calificar libro
    Route::match(['get', 'post'],'/usuario/libro/valorar/{comentario_id?}',[UsuarioController::class,'calificarLibro'])->name('calificarLibro');
//    editar perfil usuario
    Route::get('/perfil/editar/', [UsuarioController::class, 'editarperfil'])->name('editarperfil');
    Route::post('/perfil/editar/editar', [UsuarioController::class, 'modificarperfil'])->name('actualizarperfil');
    //eliminar usuario
    Route::get('/perfil/eliminar/{id?}', [UsuarioController::class, 'eliminar'])->name('eliminarperfil');
    Route::post('/perfil/eliminando', [UsuarioController::class, 'eliminarbbdd'])->name('confirmareliminarusuario');

    
//    LIBROS
//  editar
    Route::get('/libro/editar/{libro}',[LibroController::class,'editar'])->name('editarlibro');
//  eliminar
    Route::get('/libro/borrar/{id}',[LibroController::class,'borrar'])->name('borrarlibroBBDD');
    Route::post('/libro/borrar/confirmar',[LibroController::class,'borrarBBDD'])->name('confirmareliminar');
    
    
    //  routes que solo pueden acceder los usuario con el rol admin    
    Route::prefix('/administracion')->group(function () {    
//        Route::get('/', [UsuarioController::class, 'accionesAdmin'])->name('inicioadmin');
//        usuarios
        Route::get('/usuarios', [UsuarioController::class, 'showall'])->name('vertodosUsuarios');
        Route::post('/usuarios', [UsuarioController::class, 'showall'])->name('vertodosUsuariospost');
//        modificar usuario
        Route::get('/usuarios/modificar/{id}', [UsuarioController::class, 'editarperfil'])->name('adminmodificarUsuario');
        //enviar correo al usuario
        Route::get('/usuarios/enviar/{user_id}', [UsuarioController::class, 'enviarCorreoform'])->name('enviarcorreoadmin');
        Route::post('/usuarios/enviar', [UsuarioController::class, 'enviarCorreo'])->name('enviarcorreoadminpost');
        //hacer admin a un usuario
        Route::get('/usuarios/modificar/hacer_admin/{user}', [UsuarioController::class, 'hacerAdmin'])->name('adminhaceradminUsuario');
//        ver interacciones del usuario
        Route::get('/usuarios/interacciones/{id_usuario}', [UsuarioController::class, 'mostrarInteracciones'])->name('interaccionesUsuario');
        Route::post('/usuario/busqueda', [UsuarioController::class, 'busquedaAdmin'])->name('busquedaaminuser');
//        ver pedidos
        Route::get('/pedidos', [UsuarioController::class, 'verTodospedidos'])->name('verpedidosadmin');
        Route::post('/pedido/busqueda', [UsuarioController::class, 'busquedapedidoAdmin'])->name('verPedidoAdmin');
//        ver libros
        Route::get('/libros/', [LibroController::class, 'indexAdmin'])->name('verlibrosAdminAll');
        Route::post('/libros/busqueda', [LibroController::class, 'busquedaAdmin'])->name('verlibrosAdmin');
        //autores
        Route::get('/autores', [AutorController::class, 'showAutores'])->name('verAutoresAdmin');
        Route::post('/autores/busqueda/',[AutorController::class,'showAutores']);
        Route::get('/autores/corregir', [AutorController::class, 'corregirAutores'])->name('corregirAutoresAdmin');

        //categorias
        Route::get('/categoria', [CategoriaController::class, 'index'])->name('verCategoriaAdmin');
//        crear categoria
        Route::get('/categoria/crear/{categoria?}', [CategoriaController::class, 'create'])->name('crearCategoriaAdmin');
        Route::post('/categoria/guardar', [CategoriaController::class, 'store'])->name('guardarCategoriaAdmin');
//        eliminar
        Route::get('/categoria/eliminar/{categoria}', [CategoriaController::class, 'destroy'])->name('eliminarCategoriaAdmin');
        //estadisticas
        Route::get('/estadisticas', [UsuarioController::class, 'estadisticas'])->name('verestadisticasAdmin');
        Route::get('/estadisticas/{opcion}', [LibroController::class, 'estadisticas'])->name('verestadisticasAdminopciones');

    });
});

//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
//COMENTARIOS 
//crear comentario
Route::post('/libro/comentar/{comentario_id?}',[ComentarioController::class,'comentar'])->name('comentar');
//editar comentario
Route::get('/libro/comentar/{comentario}',[ComentarioController::class,'editarComentario'])->name('editarcomentario');
//borrar comentario
Route::get('/comentario/borrar/{comentario}',[ComentarioController::class,'delete'])->name('eliminarComentario');
Route::post('/comentario/borrar/{comentario}',[ComentarioController::class,'confirmarBorrado'])->name('confirmareliminarcomentario');


//carrito
//añadir al carrito
Route::get('/carrito/{libro}',[CarritoController::class,'add'])->name('addCarrito');
//ver carrito
Route::get('/carrito',[CarritoController::class,'showTabla'])->name('mostrarTabla');
//mostrar producto
Route::get('/carrito/mostrar',[CarritoController::class,'showProduct'])->name('mostrarcarrito');
//vaciar carro
Route::get('/carrito-vaciar',[CarritoController::class,'vaciarcarrito'])->name('vaciar');
//unidad +
Route::get('/carrito/{id?}/unidadmas',[CarritoController::class,'aumentar'])->name('aumentar_unidad');
//unidad -
Route::get('/carrito/{id?}/unidadmenos',[CarritoController::class,'descrementar'])->name('decrementar_unidad');
//eliminar libro
Route::get('/carrito/{id?}/borrar',[CarritoController::class,'eliminarlibro'])->name('borrarlibro');
Route::delete('borrar-de-carrito', [CarritoController::class, 'borrarProducto']);

// Compra
Route::get('/compra',[CompraController::class,'confirmarPedido'])->name('confirmarcompra');
Route::post('/compra/confirmar',[CompraController::class,'realizarcompra'])->name('realizarcompra');


//pedidos
//Route::get('/pedido',[CompraController::class,'mostrarPedido'])->name('mostrarPedidos');
Route::get('/pedidos/{id}',[CompraController::class,'verPedidos'])->name('verpedidos');
Route::get('/pedidos/libros/{compra_id}',[CompraController::class,'verLibrosPedido'])->name('verlibrospedido');


//correos
Route::get('/send-welcome-email',[EmailController::class,'sendWelcomeEmail']);
//pdf-facturas se envia al correo del usuario
Route::post('/factura/consulta',[EmailController::class,'sendFactura'])->name('facturaorden');



//Cookies
Route::get('/cookies',function(){
    Cookie::queue('primera_visita', true, 1*60*24*31);//1 hora
//    var_dump(Cookie::get('primera_visita'));
//    exit();
    return redirect()->route('todoslibros');

})->name('cookies');
//politica de privacidad
Route::get('/politica-privacidad',function(){
    
            return view('administracion.privacidad');

})->name('privacidad');
//CONTACTO con administracion
Route::get('/contacto',function(){
            return view('usuario.contacto');

})->name('contactoadmin');
Route::post('/contacto',[UsuarioController::class,'contactoCorreo'])->name('contactoadminpost');
//Terminos de servicio
Route::get('/terminos-servicio',function(){
            return view('administracion.terminos');

})->name('terminos-servicio');
//cookies politicas
Route::get('/politica-cookies',function(){
    return view('administracion.cookies');
})->name('vercookies');
//----------------------------------- SE PUEDE BORRAR -----------------------------------
//
////prueba de subir archivos
//Route::get('/libro/subir',[LibroController::class,'publicar'])->name('subirarchivo');
//Route::post('/libro/subir',[LibroController::class,'subir'])->name('almacenandoarchivo');
//Route::post('/libro/bajar',[LibroController::class,'bajar'])->name('descargar');

//Route::get('/nuevoregistro',[UsuarioController::class,'crear'])->name('registrousuairo');

////ver factura
//Route::get('/factura/ver',
//        function(){
//    
////    return view('emails.factura');
//    return view('emails.admin');
//        })->name('verfactura');

        
//Route::get('documentos',[LibroController::class,'leerdocumento'])->name('leerdocumentos');
    



//verificacion por email

////Route::get('/home', function () {
////    return 'Esta página es solo para usuarios verificados';
////})->middleware(['auth', 'verified']);
//Route::get('/ejemplos', function () {
//    return view('index');
//});
//----------------------------------- SE PUEDE BORRAR -----------------------------------
 require __DIR__.'/auth.php';
