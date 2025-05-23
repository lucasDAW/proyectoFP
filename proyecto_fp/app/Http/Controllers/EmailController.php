<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\WelcomeMail;
use App\Mail\FacturaMail;
use App\Mail\AdministradorMail;

class EmailController extends Controller
{
    /**
     * Envía un correo electrónico de bienvenida.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendWelcomeEmail(){
        $title = 'Welcome to the laracoding.com example mail';
        $body = 'Thank you for participing';
        
        Mail::to('dawlucas1993@gmail.com')->send(new WelcomeMail($title,$body));
        return redirect()->route('inicio')->with('mensaje', 'Se ha enviado el correo !!'); 
    }
       /**
     * Envía un correo electrónico genérico.
     *
     * @param  string  $email  Dirección de correo electrónico del destinatario
     * @param  string  $titulo  Título del correo electrónico
     * @param  string  $cuerpo  Cuerpo del correo electrónico
     * @return void
     */
    public function sendEmail($email,$titulo,$cuerpo){
        
//        $email = 'dawlucas1993@gmail.com';
        Mail::to($email)->send(new WelcomeMail($titulo,$cuerpo));
//        Mail::to($email)->send(new WelcomeMail($titulo,$cuerpo));
//        return redirect()->route('todoslibros')->with('mensaje', 'Se ha enviado el correo !!'); 
    }
    
    /**
     * Envía un correo electrónico al administrador.
     *
     * @param  string  $email  Dirección de correo electrónico del administrador (actualmente fija)
     * @param  string  $titulo  Título del correo electrónico
     * @param  string  $cuerpo  Cuerpo del correo electrónico
     * @return void
     */
    public function sendEmailAdmin($email,$titulo,$cuerpo){
        
        $email = 'dawlucas1993@gmail.com';
        Mail::to($email)->send(new AdministradorMail($titulo,$cuerpo));
    }
     /**
     * Envía una factura por correo electrónico.
     *
     * @param  int  $id_compra  ID de la compra
     * @param  string  $usuario  Nombre del usuario
     * @param  string  $email  Dirección de correo electrónico del usuario
     * @param  array  $direcion  Dirección del usuario
     * @param  array  $carro  Carrito de compra del usuario
     * @return \Illuminate\Http\Response
     */
    public function sendFactura($id_compra,$usuario,$email,$direcion,$carro){
        
        
//       
//        //aqui hacemos consulta base de datos en las tablas compra y pedidos
//        
//Consultas a BBDD donde encontrar la orden y el usuario que la realiza
//        $orden= DB::table('pedidos')
//                ->join('libros','pedidos.libro_id','=','libros.id')
//                ->select('libros.*')->where('compra_id',$id_compra)
//                ->get();
//        $usuario = DB::table('compras')->join('users','compras.user_id','=','users.id')
//                    ->select('users.name', 'users.email')->where('compras.id','=',$id_compra)->get()[0];

//       Genera pdf usando la vista emails.factura como base
        $pdf = Pdf::loadView('emails.factura',['id'=>$id_compra, 'orden'=>$carro,'usuario'=>$usuario,'email'=>$email,'direccion'=>$direcion]);
//        
//        descarga el pdf creado
//        return $pdf->download('Recibo_' . $request->compra_id . '.pdf');
        
        
//        Pasamos a enviar la factura por mail
//        Guardamos el PDF Temporalmente
        $pdfPath = storage_path('app/documentos/factura_'.$id_compra.'.pdf');
        $pdf->save($pdfPath);
  
//        enviamos el correo
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!ATENCION!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//            !!!!!!!!!!!!!!!!!!!!!!!!HAY QUE ELIMINAR ESTA LINEA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//        $email = 'dawlucas1993@gmail.com';
        //se envia al mismo correo siempre si no se boora
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!ATENCION!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!ATENCION!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        Mail::to($email)->send(new FacturaMail($id_compra, $pdfPath,$usuario));
//        
//        eliminamos el pdf de la factura
        unlink($pdfPath);

        return view('emails.correofactura');
//        
    }
}
