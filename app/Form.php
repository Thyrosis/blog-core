<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Form extends Model
{
    protected $fillable = ['name', 'action', 'token'];

    /**
     * Returns the action this Form takes.
     * When no specific action is set to this Form, add the default route.
     * 
     * @return  string
     * @since   20190120
     */
    public function action()
    {
        return (!empty($this->action)) ? $this->action : route('form.submit', $this);
    }

    /**
     * Returns the CSRF this Form brings.
     * When no specific CSRF token is set to this Form, return an internal token.
     * 
     * @return  string
     * @since   20190120
     */
    public function csrf()
    {
        return (!empty($this->action)) ? $this->token : csrf_field();
    }

    /**
     * Define the relationship between a form and its fields. 
     * 
     * Each form can have many fields, but each field
     * only belongs to one form.
     * 
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('id', 'ASC');
    }

    public function hasMailField()
    {        
        foreach ($this->fields as $field) {
            if ($field->type == "email") {
                return $field->elementId;
            }
        }
        
        return null;
    }

    /**
     * Define the relationship between a form and its responses. 
     * 
     * Each form can have many responses, but each response
     * only belongs to one form.
     * 
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function responses()
    {
        return $this->hasMany(FormResponse::class)->orderBy('created_at', 'DESC');
    }
    
    /**
     * Add the routes related to Form to the application.
     * 
     * @todo    Check if FormField and FormResponse routes need to be defined separately
     */
    public static function routes()
    {
        Route::get('/admin/form/index', 'Admin\FormController@index')->name('admin.form.index');
        Route::get('/admin/form/create', 'Admin\FormController@create')->name('admin.form.create');
        Route::post('/admin/form/store', 'Admin\FormController@store')->name('admin.form.store');
        Route::post('/form/submit/{form}', 'FormResponseController@store')->name('form.submit');
    }

    /**
     * Parse the Form including all it's Fields to the proper HTML.
     * 
     * @return  string
     * @since   20190122
     */
    public function toHTML()
    {
        $html = "<form method='POST' action='{$this->action()}'>
            {$this->csrf()}
            <input type='hidden' name='recaptcha_response' id='recaptchaResponse'>";

            foreach ($this->fields as $field) {
                $html .= "<div class='form-group'>
                    <label class='form-label' for='{$field->elementId}'>{$field->name}</label>";

                    if ($field->input == "input") {
                        $html .= "<input aria-describedBy='info-{$field->elementId}' type='{$field->type}' name='{$field->elementId}' id='{$field->elementId}' class='{$field->class()}' ".($field->required == 1 ? "required" : "" )." />";
                    } elseif ($field->input == "textarea") {
                        $html .= "<textarea aria-describedBy='info-{$field->elementId}' name='{$field->elementId}' id='{$field->elementId}' class='{$field->class()}' ".($field->required == 1 ? "required" : "" )."></textarea>";
                    } elseif ($field->input == "select") {
                        $html .= "<select aria-describedBy='info-{$field->elementId}' name='{$field->elementId}' id='{$field->elementId}' class='{$field->class()}'>";
                        foreach ($field->options() as $option) {
                            $html .= "<option value='{$option['value']}'>{$option['name']}</option>";
                        }
                        $html .= "</select>";
                    }
                    
                    $html .= "<p class='form-info' id='info-{$field->elementId}'>{$field->description}</p>";
                $html .= "
                </div>";
            }

        $html .= "<div class='form-group'>
                    <button class='form-button' type='submit'>Send</button>
                </div>
            </form>";

        return $html;
    }
}
