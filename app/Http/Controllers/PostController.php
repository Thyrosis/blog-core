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
        $posts = Post::getPublished()->whereType('post')->simplePaginate(Setting::get('post.showPerPage'));

        return view()->first(['post.index', 'core.post.index'])->with('posts', $posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     * @version 20190702    Load view based on post type, or post.show when not found
     */
    public function show(Post $post)
    {
        $show = false;

        if ($post->isPublished()) {
            $show = true;
        }

        if (auth()->check()) {
            $show = true;
        }

        if (isset($post->hash) && !empty($post->hash)) {
            $hash = request()->query('hash');

            if ($hash == $post->hash) {
                $show = true;
            }
        }

        if ($show) {
            $post->view();

            $post->previous = $post->previous();
            $post->next = $post->next();
            
            return view()->first([$post->type.'.show', 'post.show', 'core.post.show'])->with('post', $post);
        }

        return redirect(route('home'));
    }
}
