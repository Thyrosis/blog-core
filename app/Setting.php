<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Setting extends Model
{
    /**
     * Defines the route keyname used by Larave.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
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

    public static function get($code)
    {
        return self::whereCode($code)->first()->value ?? null;
    }

    public static function updateSingle($code, $value)
    {
        $code = str_replace('_', '.', $code);

        return DB::table('settings')
        ->where('code', $code)
        ->update(['value' => $value]);
    }
}
