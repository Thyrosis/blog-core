<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = ['post_id', 'url', 'path', 'ipaddress', 'iphash'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
