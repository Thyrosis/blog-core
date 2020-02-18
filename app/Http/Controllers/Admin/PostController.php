<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\UniqueSlug;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class PostController extends Controller
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
        return view('core.admin.post.index')->with('posts', Post::with(['comments'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('core.admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'min:3', 'max:255', new UniqueSlug],
            'longTitle' => 'nullable|min:3|max:255',
            'summary' => 'nullable',
            'body' => 'required|min:3',
            'keywords' => 'nullable',
            'metadescription' => 'nullable',
            'commentable' => 'required|boolean',
            'featured' => 'required|boolean',
            'featureimage' => 'nullable',
            'published' => 'required|boolean',
            'published_at_date' => 'required|date',
            'published_at_time' => 'required|date_format:"H:i"',
            'type' => 'nullable',
            'use_hash' => 'required',
        ]);

        $data = Post::processData($data);

        $post = Post::create($data)->sync($request);
        
        return redirect(route('admin.post.edit', $post))->with("success", "Post posted");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (request()->get('action') == 'duplicate') {
            return redirect(route('admin.post.edit', $post->duplicate()));
        }

        return view('core.admin.post.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'user_id' => 'nullable',
            'title' => ['nullable', 'min:3', 'max:255'],
            'longTitle' => 'nullable|min:3|max:255',
            'slug' => [
                'nullable',
                Rule::unique('posts')->ignore($post->id),
            ],
            'summary' => 'nullable',
            'body' => 'nullable|min:3',
            'keywords' => 'nullable',
            'metadescription' => 'nullable',
            'commentable' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'featureimage' => 'nullable',
            'published' => 'nullable|boolean',
            'published_at_date' => 'nullable|date',
            'published_at_time' => 'nullable|date_format:"H:i"',
            'type' => 'nullable',
            'use_hash' => 'nullable|boolean',
            'hash' => 'nullable',
        ]);

        $data = Post::processData($data);
        $post->update($data);
        $post->sync($request);

        return redirect(route('admin.post.edit', $post))->with("success", "Post updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect(route('admin.post.index'))->with('success', 'The post has been deleted.');
    }
}
