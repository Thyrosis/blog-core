<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Setting;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'emailaddress' => 'required|email',
            'post_id' => 'required|int',
        ]);

        try {
            Subscription::create($data);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                return redirect()->back()->with("success", "Thanks! But you're already subscribed.");
            }

            return redirect()->back()->with("error", "Oops... I don't know what happened, but adding your subscription obviously failed.");
        }

        return redirect()->back()->with("success", Setting::get('comment.notification.subscribed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->back()->with("success", "So long and thanks for all the fish!");
    }
}
