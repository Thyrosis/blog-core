<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::all()->groupBy(function ($subscription) {
            return $subscription->post_id;
        });
        
        return view('core.admin.subscription.index')->with('subscriptions', $subscriptions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $posts = Post::where('published', 0)->get();

        foreach ($posts as $post) {
            $post->subscriptions->each(function ($subscription) {
                $subscription->delete();
            });
        }

        return redirect(route('admin.subscription.index'));
    }
}
