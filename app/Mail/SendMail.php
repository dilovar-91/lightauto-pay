<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fio, $phone, $transport, $images, $files)
    {
        $this->fio = $fio;
        $this->phone = $phone;
        $this->transport = $transport;
        $this->files = $files;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message =  $this->from('hello@la-pay.ru', 'Лайт Авто')
            ->subject('Оплата проезда')
            ->markdown('mails.exmpl')
            ->with([
                'fio' => $this->fio,                
                'phone' => $this->phone,
                'transport' => $this->transport,
            ]);
           
            foreach($this->files as $file) {
                    
                    $message->attach($file->getRealPath(), array(
                        'as' => $file->getClientOriginalName(),     
                        'mime' => $file->getMimeType())
                    );
                }
            
            return $message;



    }
}
