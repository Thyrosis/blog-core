<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\FormResponse;

class NewFormResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $formResponse;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($formResponse)
    {
        $this->formResponse = $formResponse;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New form response at ".config('app.name'))->markdown('mail.newFormresponse');
    }
}
