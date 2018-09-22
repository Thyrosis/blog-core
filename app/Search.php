<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'term',
        'result',
        'uuid',
        'user_id'
    ];

    protected $casts = [
        'result' => 'array'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
