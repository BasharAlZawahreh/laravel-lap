<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExternalPostSuggesstedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.mail',[
            'title' =>$this->title,
            'url' => $this->url
        ]);
    }
}
