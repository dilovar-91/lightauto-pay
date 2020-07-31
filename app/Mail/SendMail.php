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
        $message =  $this->from('hello@paytravel.ru', 'Пилот авто')
            ->subject('Оплата проезда')
            ->markdown('mails.exmpl')
            ->with([
                'fio' => $this->fio,                
                'phone' => $this->phone,
                'transport' => $this->transport,
            ]);
            if (count($this->files)>0){
            foreach($this->files as $file) {
                    $message->attach($file, $file->getClientOriginalName());
                    //$message->attach($file->getRealPath(), array(
                    //    'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name      
                   //     'mime' => $file->getMimeType())
                    //);
                }
            }
            return $message;



    }
}
