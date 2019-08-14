<?php

namespace App;

use App\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;
use App\Libraries\Akismet;

class Comment extends Model
{
    protected $fillable = ['post_id', 'name', 'emailaddress', 'body', 'ip', 'approved', 'notify'];

    protected static function boot()
    {
        parent::boot();
        
        static::saved(function ($comment) {
            Subscription::send($comment);
            Mail::to(Setting::get('mail.adminAddress'))->queue(new NewComment($comment));
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

    public function approve()
    {
        return $this->update(['approved' => true]);
    }

    public function unapprove()
    {
        return $this->update(['approved' => false]);
    }

    public function switchApproval()
    {
        if ($this->approved) {
            return $this->unapprove();
        }

        return $this->approve();
    }
}
