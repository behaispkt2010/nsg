<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderInfo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Email.template-order')
            ->subject( $this->data['subject'])
            ->with([
                "name"=> $this->data['name'],
                "email"=> $this->data['email'],
                "phone"=> $this->data['phone'],
                "comment"=> $this->data['comment'],
                "link"=> $this->data['link']
            ]);
    }
}
