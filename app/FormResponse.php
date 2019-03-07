<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewFormResponse;
use App\Mail\NewFormResponseCopy;
use Illuminate\Support\Facades\Log;

class FormResponse extends Model
{
    protected $fillable = ['form_id', 'email', 'content'];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($formResponse) {
            if (Setting::get('mail.useQueue')) {
                Log::info("Queueing a new FormResponse mail to ".config('custom.adminEmailAddress')." with the following details: ", $formResponse->toArray());
                Mail::to(config('custom.adminEmailAddress'))->queue(new NewFormResponse($formResponse));

                if ($formResponse->email !== null) {
                    Log::info("Queueing a new FormResponseCopy mail to ".$formResponse->email." with the following details: ", $formResponse->toArray());
                    Mail::to($formResponse->email)->queue(new NewFormResponseCopy($formResponse));
                }
            } else {
                Log::info("Sending a new FormResponse mail to ".config('custom.adminEmailAddress')." with the following details: ", $formResponse->toArray());
                Mail::to(config('custom.adminEmailAddress'))->send(new NewFormResponse($formResponse));

                if ($formResponse->email !== null) {
                    Log::info("Sending a new FormResponseCopy mail to ".$formResponse->email." with the following details: ", $formResponse->toArray());
                    Mail::to($formResponse->email)->send(new NewFormResponseCopy($formResponse));
                }
            }
            
        });
    }

    public function getContent()
    {
        return json_decode($this->content, true);
    }

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
