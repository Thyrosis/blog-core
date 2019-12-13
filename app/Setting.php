<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['code', 'type', 'label', 'description', 'value', 'category', 'hidden'];

    /**
     * Defines the route keyname used by Larave.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function getEditValue()
    {
        $return = $this->value;
        
        if ($this->type == 'ARRAY') {
            $return = "";

            $values = collect(json_decode($this->value));

            $values->each(function ($item, $key) use (&$return) {
                $return .= $item . "\r\n";
            });
        }

        return trim($return);
    }

    /**
     * Add the routes related to Form to the application.
     * 
     * @todo    Check if FormField and FormResponse routes need to be defined separately
     */
    public static function routes()
    {
        Route::get('/admin/setting', 'Admin\SettingController@edit')->name('admin.setting.edit')->middleware('auth');
        Route::patch('/admin/setting', 'Admin\SettingController@update')->name('admin.setting.update')->middleware('auth');
        
        // try {
        //     $homeRoute = Setting::get('home.url');

        //     if (is_null($homeRoute) || $homeRoute == "post.index") {
        //         Route::get('/', 'PostController@index')->name('home');
        //     } else {
        //         Route::redirect('/', $homeRoute)->name('home');;
        //     }

        //     $postRoute = Setting::get('post.index');

        //     if (is_null($postRoute)) {
        //         Route::get('blog', 'PostController@index')->name('post.index');
        //     } else {
        //         Route::get($postRoute, 'PostController@index')->name('post.index');
        //     }
        // } catch (Exception $e) {
        //     Route::get('blog', 'PostController@index')->name('post.index');
        //     Route::get('/', 'PostController@index')->name('home');
        // }
    }

    /**
     * Returns the setting value or null if not set.
     * 
     * Caches the value indefinitely if it's not in the cache yet.
     * 
     * @param   string $code    Unique setting code to retrieve from cache/db
     * @return  mixed
     * @version 2019-10-05      Add the setting to the cache if it doesn't exist there yet.
     */
    public static function get($code)
    {
        return Cache::rememberForever('settings.'.$code, function () use ($code) {
            try {
                $setting = self::whereCode($code)->first() ?? null;

                if ($setting->type == 'ARRAY') {
                    return json_decode($setting->value);
                }

                return $setting->value;
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    public static function updateSingle($code, $value)
    {        
        $code = str_replace('_', '.', $code);

        $setting = self::whereCode($code)->first();

        $setting->value = $value;

        if ($setting->type == 'ARRAY') {
            $setting->value = json_encode(explode("\r\n", $value));
        }

        Cache::put('settings.'.$code, $setting->value);

        if ($setting->type == 'ARRAY') {
            return Cache::put('settings.'.$code, json_decode($setting->value));
        }

        return $setting->save();
    }
}
