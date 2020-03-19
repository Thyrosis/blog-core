<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    protected $connection = 'mysql';
    protected $metaDatabase = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('app.env') === 'testing') {
            $this->connection = 'sqlite';
            $this->metaDatabase = null;
        } else if (config('custom.customAuthDB')) {
            $this->metaDatabase = \DB::connection()->getDatabaseName().'.';
            $this->connection = 'mysql_auth';
        }

    }

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($user) {
            // Always add the first user as Admin
            if ($user && self::all()->count() == 1) {
                $user->updateMeta('access-level', 'admin');
            }
        });
    }

    public function canModerate()
    {
        if ($this->isAdmin() || $this->isModerator()) {
            return true;
        }

        return false;
    }

    public function home()
    {
        if ($this->canModerate()) {
            return route('admin.post.index');
        }

        return route('profile.show', $this);
    }

    public function isAdmin()
    {
        return strtolower($this->level()) == 'admin';
    }

    public function isModerator()
    {
        return strtolower($this->level()) == 'moderator';
    }

    public function metas()
    {
        return $this->belongsToMany('App\Meta', $this->metaDatabase.'meta_user')->withPivot('value')->withTimestamps();
    }

    public function level()
    {
        return Cache::remember('users.'.$this->id.'level', 300, function () {
            return $this->meta('access-level') ?? 'user'; 
        });  
    }

    public function meta($code = null)
    {
        if (empty($code)) {
            return null;
        }

        if ($meta = $this->metas()->where('code', $code)->first()) {
            return $meta->pivot->value;
        }

        return null;
    }

    public function updateMeta($code = null, $value = null)
    {
        if (!empty($code)) {
            $meta = Meta::where('code', $code)->first();

            if ($meta) {
                return $this->metas()->sync([$meta->id => ['value' => $value] ], false);
            }
        }

        return false;
    }

    public static function routes()
    {
        Route::get('/admin/user/', 'Admin\UserController@index')->name('admin.user.index')->middleware(['auth','moderator']);
        Route::get('/admin/user/{user}/edit', 'Admin\UserController@edit')->name('admin.user.edit')->middleware(['auth','moderator']);
        Route::patch('/admin/user/{user}', 'Admin\UserController@update')->name('admin.user.update')->middleware(['auth','moderator']);
        Route::delete('/admin/user/{user}', 'Admin\UserController@destroy')->name('admin.user.destroy')->middleware(['auth','moderator']);

        Route::get('/user/profile/{user}', 'Profile\UserController@show')->name('profile.show')->middleware('auth');
        Route::get('/user/profile/{user}/edit', 'Profile\UserController@edit')->name('profile.edit')->middleware('auth');
        Route::patch('/user/profile/{user}', 'Profile\UserController@update')->name('profile.update')->middleware('auth');
    }
}