<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     * @version 2018-08-27  Added Category in return
     * @version 2018-09-21  - Added default view
     *                      - Pass through posts based on new Category::publishedPosts method   
     */
    public function show(Category $category)
    {
        $posts = $category->publishedPosts()->latest()->simplePaginate(config('custom.postsPerPage'));
        return view()->first(['post.index', 'core.post.index'])->with('category', $category)->with('posts', $posts);

        //$posts = $category->posts()->where('published', true)->where('published_at', '<', now())->latest()->simplePaginate(config('custom.postsPerPage'));
        //return view('post.index')->with('posts', $posts)->with('category', $category);
    }
}
