<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $connection = 'mysql';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('app.env') === 'testing') {
            $this->connection = 'sqlite';
        } else if (config('custom.customAuthDB')) {
            $this->connection = 'mysql_auth';
        }
    }

    public static function routes()
    {
        Route::get('/admin/user/', 'Admin\UserController@index')->name('admin.user.index');
        Route::get('/admin/user/{user}', 'Admin\UserController@show')->name('admin.user.show');
        Route::get('/admin/user/create', 'Admin\UserController@create')->name('admin.user.create');
        Route::post('/admin/user/store', 'Admin\UserController@store')->name('admin.user.store');
        Route::get('/admin/user/{user}/edit', 'Admin\UserController@edit')->name('admin.user.edit');
        Route::patch('/admin/user/{user}', 'Admin\UserController@update')->name('admin.user.update');
        Route::delete('/admin/user/{user}', 'Admin\UserController@destroy')->name('admin.user.destroy');
    }
}
