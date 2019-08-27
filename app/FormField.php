<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = ['form_id', 'input', 'type', 'name', 'elementId', 'class', 'required', 'options', 'description'];

    /**
     * Returns the class or classes applied to this FormField.
     * When no class is set to this object, add a default value.
     * 
     * @param   string $default     The default CSS class to return
     * @return  string
     * @since   20190123
     */
    public function class($default = "form-control")
    {
        return $this->class ?? $default;
    }

    /**
     * Define the relationship between a FormField and its Form. 
     * 
     * Each FormField belongs to one Form, but a Form can have
     * multiple FormFields
     * 
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public static function optionsToJson($options)
    {
        return collect(explode(",", $options))->map(function ($item) {
            return trim($item);
        })->toJson();
    }
}
