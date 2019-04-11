<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'filename', 'filepath', 'filetype', 'label', 'description',
    ];

    public static function routes()
    {
        // Route::get('/admin/user/', 'Admin\UserController@index')->name('admin.user.index')->middleware(['auth', 'moderator']);

        Route::get('/admin/media', 'Admin\MediaController@index')->name('media.index')->middleware(['auth']);
        Route::post('/admin/media', 'Admin\MediaController@store')->name('media.store')->middleware(['auth']);
    }
}
