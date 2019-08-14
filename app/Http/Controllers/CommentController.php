<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\User;
use App\Subscription;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @version 2018-08-27      Set post_id to be required
     * @version 2019-08-12      Make the comment before preapproving for 
     *                          Akismet check in preapprove method.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'emailaddress' => 'required|email',
            'body' => 'required|min:3', 
            'post_id' => 'required|exists:posts,id',
            'notify' => 'nullable|boolean',
        ]);

        $data['ip'] = $request->ip();

        $comment = Comment::make($data);

        if ($comment->preapprove()) {
            $comment->approved = true;
            $message = "Bedankt! Je bericht wordt direct geplaatst.";
        } else {
            $comment->approved = false;
            $message = "Bedankt! Je bericht wordt geplaatst zodra het gecontroleerd is.";
        }
        
        $comment->save();

        if ($comment->notify) {
            Subscription::createNew(['post_id' => $comment->post_id, 'emailaddress' => $comment->emailaddress]);            
        }

        return redirect(route('post.show', $comment->post))->with('success', $message);
    }
}
