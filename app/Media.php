<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'filename', 'filepath', 'filetype', 'label', 'description', 'category',
    ];

    public static function categories()
    {
        return DB::table('media')->select('category')->distinct()->pluck('category');
    }

    public function path()
    {
        return '/storage/'.$this->filepath;
    }

    public static function routes()
    {
        Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/media', 'Admin\MediaController@index')->name('media.index');
            Route::post('/media', 'Admin\MediaController@store')->name('media.store');
        });
    }
}
