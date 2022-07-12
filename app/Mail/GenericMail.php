<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $payload;
    public $view;
    public $key;
    public $subject;

    public function __construct($view, $payload, $key, $subject=null)
    {
        //
        $this->payload = $payload;
        $this->view = $view;
        $this->key = $key;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->subject){
            return $this->subject($this->subject)->markdown($this->view, [$this->key => $this->payload]);

        }
        return $this->markdown($this->view, [$this->key => $this->payload]);
    }
}
