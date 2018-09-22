<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wppps_term extends Model
{
    public function wpposts()
    {
        return $this->belongsToMany('App\Wppps_post', 'wppps_term_relationships', 'term_taxonomy_id', 'object_id');
    }
}
