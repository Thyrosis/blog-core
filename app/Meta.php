<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = ['code', 'label', 'description'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
