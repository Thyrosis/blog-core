<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wppps_comment extends Model
{
    public function wppost()
    {
        return $this->belongsTo(Wppps_post::class, 'comment_post_ID');
    }
}
