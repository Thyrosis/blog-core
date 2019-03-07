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
     */
    public function store(Request $request, Form $form)
    {
        $request->validate([
            'recaptcha_response' => ['required', new Recaptcha]
        ]);

        $mailfield = $form->hasMailField();

        $formResponse = FormResponse::create([
            'form_id' => $form->id,
            'email' => ($mailfield) ? $request->$mailfield : $mailfield,
            'content' => json_encode($request->except('_token')),
        ]);
        
        if ($formResponse) {
            $request->session()->flash('success', 'Form submission successful. Thank you!');
            return redirect()->back();
        }

        $request->session()->flash('error', 'Form submission failed. Please try again.');
        return redirect()->back();
    }
}
