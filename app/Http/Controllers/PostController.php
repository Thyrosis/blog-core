<?php

namespace App\Http\Controllers;

use App\Post;
use App\Setting;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @version 2018-09-14  Pass all published posts to the view, regardless of featured status.
     *                      Featured posts can be extracted by view logic, not controller.
     */
    public function index()
    {
        $posts = Post::getPublished()->simplePaginate(Setting::get('post.showPerPage'));

        return view()->first(['post.index', 'core.post.index'])->with('posts', $posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (!$post->isPublished() && auth()->guest()) {
            return redirect(route('home'));
        }

        $post->view();

        $post->previous = $post->previous();
        $post->next = $post->next();
        
        return view()->first(['post.show', 'core.post.show'])->with('post', $post);
    }
}
