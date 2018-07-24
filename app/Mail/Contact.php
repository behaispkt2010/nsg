<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
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
        return $this->view('Email.template-contact')
            ->subject( $this->data['subject'])
            ->with([
                "name"=> $this->data['name'],
                "refferalcode" => !empty($this->data['refferalcode'])?$this->data['refferalcode']:"",
                "email"=> $this->data['email'],
                "phone"=> $this->data['phone'],
                "comment"=> $this->data['comment'],
//                "link"=> $this->data['link']
            ]);
    }
}
