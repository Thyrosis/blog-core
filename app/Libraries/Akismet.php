<?php

namespace App\Libraries;

use App\Comment;
use App\Setting;

class Akismet
{
    protected $url;
    protected $client;
    protected $data = [];
    protected $key;
    protected $comment;
    
    public function __construct($comment = false)
    {
        $this->key = Setting::get('comment.akismet.key');
        $this->blog = config('app.url');
        $this->host = 'rest.akismet.com';
        $this->port = 443;
        $this->useragent = "Laravel based CMS | Akismet";

        if ($comment) {
            $this->setComment($comment);
        }
    }

    public function setComment(Comment $comment)
    {
        $this->comment = $comment;
        return $this->comment;
    }

    public function query($path, $request, $hostprefix = '')
    {
        $content_length = strlen( $request );
        $http_request  = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: {$hostprefix}{$this->host}\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $http_request .= "Content-Length: {$content_length}\r\n";
        $http_request .= "User-Agent: {$this->useragent}\r\n";
        $http_request .= "\r\n";
        $http_request .= $request;
        $response = '';
        if( false != ( $fs = @fsockopen( 'ssl://' . $this->host, $this->port, $errno, $errstr, 10 ) ) ) {
             
            fwrite( $fs, $http_request );
         
            while ( !feof( $fs ) )
                $response .= fgets( $fs, 1160 ); // One TCP-IP packet
            fclose( $fs );
             
            $response = explode( "\r\n\r\n", $response, 2 );
        }

        return $response;
    }

    public function validateKey()
    {
        $request = 'key='. $this->key .'&blog='. urlencode($this->blog);
        $path = '/1.1/verify-key';
        $response = $this->query($path, $request);
        
        if ( 'valid' == $response[1] ) {
            return true;
        } else {
            return false;
        }
    }

    public function checkComment()
    {
        $request = 'blog='. urlencode($this->blog) .
           '&user_ip='. urlencode($this->comment->ip) .
           '&user_agent='. urlencode($this->useragent) .
           '&referrer='. urlencode(request()->headers->get('referer')) .
        //    '&permalink='. urlencode($data['permalink']) .
           '&comment_type='. urlencode('comment') .
           '&comment_author='. urlencode($this->comment->name) .
           '&comment_author_email='. urlencode($this->comment->emailaddress) .
        //    '&comment_author_url='. urlencode($data['comment_author_url']) .
           '&comment_content='. urlencode($this->comment->body);

        $path = '/1.1/comment-check';
        $response = $this->query($path, $request, $this->key . '.');
        
        if ( 'true' == $response[1] ) {
            return false;
        } else {
            return true;
        }
    }
}
