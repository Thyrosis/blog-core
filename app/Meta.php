<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Meta extends Model
{
    protected $fillable = ['code', 'label', 'description', 'system', 'updateable'];

    protected $connection = 'mysql';

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
        return $this->belongsToMany('App\User', config('database.connections.mysql.database').'.meta_user')->withPivot('value')->withTimestamps();
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
