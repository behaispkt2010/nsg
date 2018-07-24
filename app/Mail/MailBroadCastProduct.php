<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailBroadCastProduct extends Mailable
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
        return $this->view('Email.template-mailbroadcast')
            ->subject( $this->data['subject'])
            ->with([
                "companyName"=> $this->data['companyName'],
                "content"=> $this->data['content'],
                "phoneCompany"=> $this->data['phoneCompany'],
//                "link"=> $this->data['link']
            ]);
    }
}
