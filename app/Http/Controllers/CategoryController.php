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
     * @version 2018-08-27  - Added Category in return
     * @version 2018-09-21  - Added default view
     *                      - Pass through posts based on new Category::publishedPosts method
     * @version 2018-10-01  - Call upon category.index view first, then post.index and lastly core.category.index for default
     */
    public function show(Category $category)
    {
        $posts = $category->publishedPosts()->latest()->simplePaginate(config('custom.postsPerPage'));
        return view()->first(['category.index', 'post.index', 'core.category.index'])->with('category', $category)->with('posts', $posts);
    }
}
