<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormResponse;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;

class FormResponseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @version 20190827    Only require reCAPTCHA if it's available in the settings
     */
    public function store(Request $request, Form $form)
    {
        $client = Setting::get('recaptcha.client');            
        if ($client) {
            $request->validate([
                'recaptcha_response' => ['required', new Recaptcha]
            ]);
        }

        $mailfield = $form->hasMailField();

        $formResponse = FormResponse::create([
            'form_id' => $form->id,
            'email' => ($mailfield) ? $request->$mailfield : $mailfield,
            'content' => json_encode($request->except(['_token', 'recaptcha_response'])),
        ]);
        
        if ($formResponse) {
            $request->session()->flash('success', \Setting::get('form.thanksForSubmission'));
            return redirect()->back();
        }

        $request->session()->flash('error', \Setting::get('form.submissionError'));
        return redirect()->back();
    }
}
