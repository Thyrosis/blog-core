<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $posts = $tag->publishedPosts()->latest()->simplePaginate(config('custom.postsPerPage'));
        return view()->first(['post.index', 'core.post.index'])->with('tag', $tag)->with('posts', $posts);
    }
}
