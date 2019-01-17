<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $fillable = ['form_id', 'content'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
