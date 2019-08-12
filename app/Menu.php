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

    public static function get()
    {
        $build = self::build();

        if (isset($build[0])) {
            return json_decode($build[0]->content);
        }

        return false;
    }

    public static function getHTML($ulclass = "", $liclass = "pl-2", $subulclass = "", $subliclass = "pl-4")
    {
        $menu = self::get();
        $html = "";
        
        if ($menu) {
            $html = "<ul class='{$ulclass}'>";
            foreach ($menu as $item) {
                $html .= "<li class='{$liclass}'><a href='$item->url'>$item->name</a></li>";

                if (!empty($item->children[0])) {
                    
                    $html .= "<ul class='{$subulclass}'>";
                    foreach ($item->children[0] as $subitem) {
                        $html .= "<li class='{$subliclass}'><a href='$subitem->url'>$subitem->name</a></li>";
                    }
                    $html .= "</ul>";
                }
            }
            $html .= "</ul>";
        }

        return $html;
    }

    public function rebuild()
    {
        Cache::forget('menu');

        self::build();
    }
}
