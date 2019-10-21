<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\FormResponse;

class NewFormResponseCopy extends Mailable
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
        Log::info("Sending App\Mail\NewFormResponseCopy");

        $this->subject( \__("Your form entry at")." ".config('app.name'));

        if (view()->exists('mail.newFormResponseCopy')) {
            return $this->markdown('mail.newFormResponseCopy');
        } else {
            return $this->markdown('core.mail.newFormResponseCopy');
        }
    }
}
