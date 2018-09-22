<?php

namespace App\Http\Controllers;

use App\MailChimp;
use Illuminate\Http\Request;
use App\Rules\Recaptcha;

class MailChimpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subscriptionEmail' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);
        
        $mc = new MailChimp();

        $r = redirect(route('home'));

        if ($mc->subscribe(request('subscriptionEmail'))) {
            $r->with('success', "Bedankt! Bij de volgende blogpost krijg je van mij een mailtje.");
        } else {
            $r->with('error', "Dat is jammer, er ging iets fout. Heb je je e-mailadres goed ingetypt of ben je misschien al aangemeld?");
        }

        return $r;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('mailchimp.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'subscriptionEmail' => 'required',
            'newSubscriptionEmail' => 'required'
        ]);

        $mc = new MailChimp();

        $r = redirect(route('home'));

        if ($mc->edit(request('subscriptionEmail'), request('newSubscriptionEmail'))) {
            $r->with('success', "Je e-mailadres is gewijzigd van {request('subscriptionEmail')} naar {request('newSubscriptionEmail')}");
        } else {
            $r->with('error', "Geen idee wat er fout ging, maar je adres is niet gewijzigd.");
        }

        return $r;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return view('mailchimp.destroy');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $request->validate([
            'subscriptionEmail' => 'required',
        ]);

        $mc = new MailChimp();

        $r = redirect(route('home'));

        if ($mc->unsubscribe(request('subscriptionEmail'))) {
            $r->with('success', "Jammer dat je gaat, maar ik zal je niet meer lastig vallen...");
        } else {
            $r->with('error', "Geen idee wat er fout ging, maar je bent niet van de lijst verwijderd.");
        }

        return $r;
    }
}
