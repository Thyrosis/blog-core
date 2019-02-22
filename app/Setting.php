<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

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
        Route::get('/admin/setting', 'Admin\SettingController@edit')->name('admin.setting.index')->middleware('auth');
    }

    public static function get($code)
    {
        return self::whereCode($code)->first()->value ?? false;
    }
}
