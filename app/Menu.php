<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    /**
     * getHTML
     * 
     * Redirection to self::toHTML
     * 
     * @param   string ulClass
     * @param   string liClass
     * @param   string subulClass
     * @param   string subliClass
     * @return  text
     * 
     * @deprecated  2019-08-30
     */
    public static function getHTML($ulClass, $liClass, $subulClass, $subliClass)
    {
        Log::warning("You're using the deprecated method Menu::toHTML. Please switch to getHTML to avoid future issues.");
        return self::toHTML(compact('ulClass', 'liClass', 'subulClass', 'subliClass'));        
    }

    /**
     * toHTML
     * 
     * Create an HTML representation of the menu. Takes an array of parameters to set as classes.
     * Use a associative array with the following list of keys allowed:
     * 
     * - ulClass, ulID
     * - liClass, liID
     * - aClass, aID
     * - subulClass, subulID
     * - subliClass, subliID
     * - subaClass, subaID
     * 
     * Replaces getHTML, as Form already used toHTML and we like to keep things organised...
     * 
     * @param   array params    Array of parameters
     * @return  string
     * @version     2019-08-30      Added A as a parameter
     */
    public static function toHTML($params = []) {
        $possibles = ['ulClass', 'ulID','liClass','liID','aClass','aID','subulClass','subulID','subliClass','subliID','subaClass','subaID'];

        extract($params);

        foreach ($possibles as $possible) {
            if (!isset(${$possible})) {
                ${$possible} = "";
            }
        }

        $menu = self::get();
        $html = "";
        
        if ($menu) {
            $html = "<ul class='{$ulClass}' id='{$ulID}'>";
            foreach ($menu as $item) {
                $html .= "<li class='{$liClass}' id='{$liID}'>
                            <a class='{$aClass}' id='{$aID}' href='$item->url'>$item->name</a>
                        </li>";

                if (!empty($item->children[0])) {
                    
                    $html .= "<ul class='{$subulClass}' id='{$subulID}'>";
                    foreach ($item->children[0] as $subitem) {
                        $html .= "<li class='{$subliClass}' id='{$subliID}'>
                            <a class='{$subaclass}' id='{$subaID}' href='$subitem->url'>$subitem->name</a>
                        </li>";
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
