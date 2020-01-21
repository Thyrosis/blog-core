<?php

namespace App;

use App\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;
use App\Libraries\Akismet;
use Illuminate\Support\Facades\Log;

class Comment extends Model
{
    protected $fillable = ['post_id', 'name', 'emailaddress', 'body', 'ip', 'approved', 'notify'];

    /**
     * @version 20191108    Changed event from 'saved' to 'created', as the saved event is also triggered when model is updated.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($comment) {
            if ($comment->approved) {
                Log::info("Sending email to subscriptions for new comment.", $comment->toArray());
                Subscription::send($comment);
            } else {
                Log::warning("NOT Sending email to subscriptions for new comment, as it's flagged as spam.", $comment->toArray());
            }

            if ($admin = Setting::get('mail.adminAddress')) {
                Log::info("Sending a copy of new comment to Admin ($admin)");
                $mail = Mail::to($admin);
                (Setting::get('mail.useQueue') == "1") ? $mail->queue(new NewComment($comment, true)) : $mail->send(new NewComment($comment, true));
            } else {
                Log::info("Not sending a copy of new Comment to Admin for whatever reason...", ['admin' => $admin]);
            }
        });
    }

    /**
     * Access the body attribute.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function path()
    {
        return "/{$this->post->slug}#reactie-{$this->id}";
    }

    public function url()
    {
        return config('app.url').$this->path();
    }

    /**
     * Set the preapproval logic for posted comments.
     * 
     * If Akismet is enabled, this always has the first say.
     * Failing that: authorised users always get approved.
     * 
     * Unauthorised users only get approved if they have a previously approved comment
     * using their IP, name or email address
     * 
     * @version 2020-01-21  Add an authorised user check
     */
    public function preapprove()
    {
        $advice = false;

        if (!empty(Setting::get('comment.akismet.key'))) {
            $akismet = new Akismet($this);

            if ($akismet->validateKey()) {
                $advice = $akismet->checkComment();
            }

            return $advice;
        }

        if (!auth()->guest()) {
            return true;
        }
         
        $data = [
            'ip' => $this->ip,
            'name' => $this->name,
            'emailaddress' => $this->emailaddress,
        ];

        if (self::where('approved', '=', true)
            ->where(function ($query) use ($data) {
                $query->where('ip', '=', $data['ip'])
                    ->orWhere('name', '=', $data['name'])
                    ->orWhere('emailaddress', '=', $data['emailaddress']);
            })
            ->exists()) {
            return true;
        }

        return false;
    }

    /**
     * approve
     * 
     * Updates the current approve-status to true, so that the comment
     * will appear as approved.
     * 
     * @return bool
     */
    public function approve()
    {
        return $this->update(['approved' => true]);
    }

    /**
     * unapprove
     * 
     * Updates the current approve-status to false, so that the comment
     * will appear as unapproved.
     * 
     * @return bool
     */
    public function unapprove()
    {
        return $this->update(['approved' => false]);
    }

    /**
     * switchApproval
     * 
     * Updates the current approve-status to the opposite
     * of what it was before. So if it is now true, set 
     * it to false and vice versa.
     * 
     * @return bool
     */
    public function switchApproval()
    {
        if ($this->approved) {
            return $this->unapprove();
        }

        return $this->approve();
    }
}
