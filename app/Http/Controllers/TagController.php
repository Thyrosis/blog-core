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
     * @version 2018-09-21  - Added default view
     *                      - Pass through posts based on new Tag::publishedPosts method
     * @version 2018-10-01  - Call upon tag.index view first, then post.index and lastly core.tag.index for default
     */
    public function show(Tag $tag)
    {
        $posts = $tag->publishedPosts()->latest()->simplePaginate(config('custom.postsPerPage'));
        return view()->first(['tag.index', 'post.index', 'core.tag.index'])->with('tag', $tag)->with('posts', $posts);
    }
}
