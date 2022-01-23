<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendLabel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $emailBody;
    public function __construct($emailBody)
    {
        $this->emailBody = $emailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // email body should include the link of airwaybill
        return $this->subject('Here you can find your shipment waybill!')
                ->view('waybill',[
                    'email'=>$this->emailBody
                ]);
    }
}
