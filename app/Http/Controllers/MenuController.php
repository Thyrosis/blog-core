<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class MenuController extends Controller
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
        return view('menu.index')->with('menus', Menu::orderBy('order')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::all();
        $categories = Category::all();
        $tags = Tag::all();

        return view('menu.create', compact('posts', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = Menu::all()->count()+1;

        if ($request->categories) {
            foreach ($request->categories as $category) {
                $category = Category::find($category);
                Menu::create(['name' => $category->name, 'url' => route('category.show', $category), 'order' => $i]);
                $i++;
            }
        }

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                $tag = Tag::find($tag);
                Menu::create(['name' => $tag->name, 'url' => route('tag.show', $tag), 'order' => $i]);
                $i++;
            }
        }

        if ($request->posts) {
            foreach ($request->posts as $post) {
                $post = Post::find($post);
                Menu::create(['name' => $post->title, 'url' => route('post.show', $post), 'order' => $i]);
                $i++;
            }
        }
        
        return redirect(route('menu.index'))->with('success', "Menu-items toegevoegd.");        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
