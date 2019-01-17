<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = ['form_id', 'input', 'type', 'name', 'elementId', 'class', 'required', 'options', 'description'];
    //
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
