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
    public function __construct($fio, $phone, $transport, $images)
    {
        $this->fio = $fio;
        $this->phone = $phone;
        $this->transport = $transport;
        $this->images = $images;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hello@paytravel.ru', 'Пилот авто')
            ->subject('Оплата проезда')
            ->markdown('mails.exmpl')
            ->with([
                'fio' => $this->fio,                
                'phone' => $this->phone,
                'transport' => $this->transport,
            ]);
    }
}
