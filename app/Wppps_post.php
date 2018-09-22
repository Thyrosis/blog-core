<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wppps_post extends Model
{
    public function wpcomments()
    {
        return $this->hasMany('App\Wppps_comment', 'comment_post_ID', 'ID');
    }

    public function wpterms()
    {
        return $this->belongsToMany('App\Wppps_term', 'wppps_term_relationships', 'object_id', 'term_taxonomy_id', 'ID', 'term_id');
    }

    public function wptags()
    {
        return $this->belongsToMany('App\Wppps_tag', 'wppps_term_relationships', 'object_id', 'term_taxonomy_id', 'ID', 'term_id');
    }
}
