<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Form extends Model
{
    protected $fillable = ['name', 'action', 'token'];

    public function action()
    {
        return (!empty($this->action)) ? $this->action : route('form.submit', $this);
    }

    public function csrf()
    {
        return (!empty($this->action)) ? $this->token : csrf_field();
    }

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('id', 'ASC');
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class)->orderBy('created_at', 'DESC');
    }

    public static function routes()
    {
        Route::get('/admin/form/index', 'Admin\FormController@index')->name('admin.form.index');
        Route::get('/admin/form/create', 'Admin\FormController@create')->name('admin.form.create');
        Route::post('/admin/form/store', 'Admin\FormController@store')->name('admin.form.store');
        Route::post('/form/submit/{form}', 'FormResponseController@store')->name('form.submit');
    }
}
