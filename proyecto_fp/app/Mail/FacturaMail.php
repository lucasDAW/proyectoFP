<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($orden, $pdfPath,$usuario)
    {
        //
       $this->order = $orden;
       $this->pdfPath = $pdfPath;
       $this->usuario = $usuario;
       
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seneca - Recibo Compra -',
        );
    }
    
    public function build(){
        return $this->subject('Factura Compra')
                    ->view('emails.correofactura')
                    ->attach($this->pdfPath,[
                        'as' =>'Factura_'.$this->order.'.pdf',
                        'mime'=>'application/pdf',
                    ]);
    }

    /**
     * Get the message content definition.
     */
//    public function content(): Content
//    {
//        return new Content(
//            view: 'emails.correofactura',
//        );
//    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
