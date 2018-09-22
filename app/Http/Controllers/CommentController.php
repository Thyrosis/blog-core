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
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'emailaddress' => 'required|email',
            'body' => 'required|min:3', 
            'post_id' => 'required|exists:posts,id',
            'notify' => 'nullable|boolean',
            'approved' => 'nullable|boolean',
        ]);

        $data['ip'] = $request->ip();

        if (Comment::preapprove($data)) {
            $data['approved'] = true;
            $message = "Bedankt! Je bericht wordt direct geplaatst.";
        } else {
            $data['approved'] = false;
            $message = "Bedankt! Je bericht wordt geplaatst zodra het gecontroleerd is.";
        }
        
        $comment = Comment::create($data);

        if ($comment->notify) {
            Subscription::createNew(['post_id' => $comment->post_id, 'emailaddress' => $comment->emailaddress]);            
        }

        return redirect(route('post.show', $comment->post))->with('success', $message);
    }
}
