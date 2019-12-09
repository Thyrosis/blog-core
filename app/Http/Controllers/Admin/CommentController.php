<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscription;

class CommentController extends Controller
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
        return view('core.admin.comment.index')->with('comments', Comment::with('post')->latest()->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        dump($comment);
    }

    public function edit(Comment $comment)
    {
        return view('core.admin.comment.edit')->with('comment', $comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $data = request()->validate([
            'name' => 'nullable|max:255',
            'emailaddress' => 'nullable|email',
            'body' => 'nullable|min:3', 
            'post_id' => 'nullable|exists:posts,id',
            'notify' => 'nullable|boolean',
            'approved' => 'nullable|boolean',
        ]);

        $comment->update($data);
        
        return back()->with('success', 'Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        foreach (Subscription::where(['post_id' => $comment->post_id, 'emailaddress' => $comment->emailaddress])->get() as $subscription) {
            $subscription->delete();
        }

        $comment->delete();
        
        return redirect(route('admin.comment.index'))->with('success', 'Comment has been removed');
    }
}
