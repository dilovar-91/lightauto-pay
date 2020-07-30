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
    public function __construct()
    {
        $this->fio = "ffffffffffff";
        $this->phone = 'fffffffff';
        $this->transport = 'авиа';
        //$this->images = $images;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('dilovar09@gmail.com', 'Пилот авто')
            ->subject('Оплата проезда')
            ->markdown('mails.exmpl')
            ->with([
                'fio' => $this->fio,
                'link' => 'https://mailtrap.io/inboxes',
                'phone' => $this->phone,
            ]);
    }
}
