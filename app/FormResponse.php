<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $fillable = ['form_id', 'content'];

    /**
     * Define the relationship between a FormResponse and its Form. 
     * 
     * Each FormResponse belongs to one Form, but a Form can have
     * multiple FormResponses
     * 
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
