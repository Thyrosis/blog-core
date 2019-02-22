<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
    }

    public static function get($code)
    {
        return self::whereCode($code)->first()->value ?? false;
    }

    public static function updateSingle($code, $value)
    {
        $code = str_replace('_', '.', $code);

        return DB::table('settings')
        ->where('code', $code)
        ->update(['value' => $value]);
    }
}
