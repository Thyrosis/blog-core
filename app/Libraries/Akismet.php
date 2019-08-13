<?php

namespace App\Libraries;

use App\Comment;
use App\Setting;

class Akismet
{
    protected $key;
    protected $client;
    protected $blog;
    protected $host;
    protected $useragent;
    protected $blog_lang;
    protected $comment;

    public function __construct($comment = false)
    {
        $this->key = Setting::get('comment.akismet.key');
        $this->client = new \GuzzleHttp\Client();
        $this->blog = config('app.url');
        $this->host = 'rest.akismet.com';
        $this->useragent = "Laravel based CMS | Akismet";
        $this->blog_lang = config('app_locale');

        if ($comment) {
            $this->setComment($comment);
        }
    }

    public function setComment(Comment $comment)
    {
        $this->comment = $comment;
        return $this->comment;
    }

    public function query($host, $data)
    {
        $response = $this->client->request('POST', 'https://'.$host, [
            'stream' => true,
            'form_params' => $data
        ]);

        $body = $response->getBody();

        while(!$body->eof()) {
           $result = $body->read(1160);
        }

        return $result;
    }

    /** validateKey
     * 
     * Checks the given key against the Akismet API.
     * 
     * @return  bool
     * @link    https://akismet.com/development/api/#verify-key
     */
    public function validateKey()
    {
        $response = $this->query($this->host.'/1.1/verify-key', [
            'key' => $this->key,
            'blog' => $this->blog,
        ]);
        
        if ( 'valid' == $response ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * checkComment
     * 
     * Checks the comment for spam possibility.
     * 
     * Returns the opposite of the Akismet intention:
     * they return TRUE when a comment is spam, whereas our code
     * returns TRUE when a comment is approved.
     * 
     * @return  bool
     * @link    https://akismet.com/development/api/#comment-check
     */
    public function checkComment()
    {
        $response = $this->query($this->key . '.' . $this->host . '/1.1/comment-check', [
            'blog' => $this->blog,
            'blog_lang' => $this->blog_lang,
            'user_ip' => $this->comment->ip,
            'user_agent' => $this->useragent,
            'referrer' => request()->headers->get('referer'),
            'comment_type' => 'comment',
            'comment_author' => $this->comment->name,
            'comment_author_email' => $this->comment->emailaddress,
            'comment_content' => $this->comment->body,
            'comment_post_modified_gmt' => $this->comment->post->published_at->toIso8601String()
        ]);

        if ( 'true' == $response ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * submitSpam
     * 
     * Submits a spam comment to Akismet for AI training purposes.
     * 
     * Returns the opposite of the Akismet intention:
     * they return TRUE when a comment is spam, whereas our code
     * returns TRUE when a comment is approved.
     * 
     * @return  bool
     * @link    https://akismet.com/development/api/#submit-spam
     */
    public function submitSpam()
    {
        $response = $this->query($this->key . '.' . $this->host . '/1.1/submit-spam', [
            'blog' => $this->blog,
            'blog_lang' => $this->blog_lang,
            'user_ip' => $this->comment->ip,
            'user_agent' => $this->useragent,
            'referrer' => request()->headers->get('referer'),
            'comment_type' => 'comment',
            'comment_author' => $this->comment->name,
            'comment_author_email' => $this->comment->emailaddress,
            'comment_content' => $this->comment->body,
            'comment_date_gmt' => $this->comment->created_at->toIso8601String(),
            'comment_post_modified_gmt' => $this->comment->post->published_at->toIso8601String()
        ]);

        if ( 'true' == $response ) {
            return false;
        } else {
            return true;
        }
    }
}
