<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Comment;
use App\Setting;
use Illuminate\Support\Facades\Log;
use User;

class NewComment extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $isAdmin;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $isAdmin = false)
    {
        $this->comment = $comment;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info("Sending App\Mail\NewComment");
        $this->subject(Setting::get('comment.notification.subject'));
        
        if (view()->exists('mail.newComment')) {
            return $this->markdown('mail.newComment');
        } else {
            return $this->markdown('core.mail.newComment');
        }        
    }
}
