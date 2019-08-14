<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Subscription extends Model
{
    protected $fillable = ['emailaddress', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function createNew($data)
    {
        try {
            self::create($data);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                return true;
            }

            return false;
        }

        return true;
    }

    public static function send(Comment $comment)
    {
        $subscriptions = $comment->post->subscriptions;
        Log::info("These are the subscriptions:", ['subscriptions' => $subscriptions]);

        if ($subscriptions->count() == 0) {
            Log::info("No subscribers to notify.");
        }

        $subscriptions->each(function ($subscription) use ($comment) {
            if ($comment->emailaddress !== $subscription->emailaddress) {
                Log::info("Notifying subscriber {$subscription->emailaddress}");

                $mail = Mail::to($subscription->emailaddress);
                (Setting::get('mail.useQueue') == "1") ? $mail->queue(new NewComment($comment)) : $mail->send(new NewComment($comment));
            }
        });
    }
}
