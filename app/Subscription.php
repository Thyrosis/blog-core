<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;
use Illuminate\Database\QueryException;

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

    public static function send($comment)
    {
        $comment->post->subscriptions->each(function ($subscription) use ($comment) {
            if ($comment->emailaddress !== $subscription->emailaddress) {
                Mail::to($subscription->emailaddress)->queue(new NewComment($comment));
            }
        });
    }
}
