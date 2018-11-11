<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    protected $fillable = ['name', 'url', 'order'];

    public static function build()
    {
        return Cache::rememberForever('menu', function () {
            return self::orderBy('order', 'ASC')->get();
        });
    }

    public function rebuild()
    {
        Cache::forget('menu');

        self::build();
    }
}
