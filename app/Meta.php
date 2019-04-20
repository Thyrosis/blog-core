<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Meta extends Model
{
    protected $fillable = ['code', 'label', 'description', 'system', 'updateable'];

    protected $connection = 'mysql';
    protected $database = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->database = \DB::connection()->getDatabaseName().'.';

        if (config('app.env') === 'testing') {
            $this->connection = 'sqlite';
            $this->database = null;
        }
    }

    protected static function boot()
    {
        parent::boot();
        
        // On creation of the meta, update the model with a corresponding code (slug)
        static::created(function ($meta) {
            $meta->update(['code' => $meta->label]);
        });
    }

    /**
     * Create a code for the meta, based on the label
     */
    public function setCodeAttribute($value)
    {        
        $this->attributes['code'] = Str::slug($value);
    }

    public function users()
    {
        // if (config('app.env') === 'testing') {
        //     return $this->belongsToMany('App\User', 'sqlite.meta_user')->withPivot('value')->withTimestamps();
        // }

        return $this->belongsToMany('App\User', $this->database.'meta_user')->withPivot('value')->withTimestamps();
    }

    public function using($value = null)
    {
        $using = array();

        foreach ($this->users as $user) {
            if ($value == $user->pivot->value) {
                $using[] = $user;
            }
        }

        return collect($using);
    }

    public static function routes()
    {
        Route::get('/admin/meta', 'Admin\MetaController@index')->name('admin.meta.index')->middleware(['auth','moderator']);
        Route::post('/admin/meta', 'Admin\MetaController@store')->name('admin.meta.store')->middleware(['auth','moderator']);
        Route::get('/admin/meta/{meta}/edit', 'Admin\MetaController@edit')->name('admin.meta.edit')->middleware(['auth','moderator']);
        Route::patch('/admin/meta/{meta}', 'Admin\MetaController@update')->name('admin.meta.update')->middleware(['auth','moderator']);
        Route::delete('/admin/meta/{meta}', 'Admin\MetaController@destroy')->name('admin.meta.destroy')->middleware(['auth','moderator']);
    }
}
