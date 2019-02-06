<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class TagController extends Controller
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
        return view('core.admin.tag.index')->with('tags', Tag::with('posts')->get());
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
            'name' => 'required|unique:tags',
            'description' => 'nullable',
        ]);

        Tag::create($data);

        return redirect(route('admin.tag.index'))->with('success', 'Tag saved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('tags')->ignore($tag->id),
            ],
            'description' => 'nullable',
        ]);

        $tag->update($data);

        return redirect(route('admin.tag.index'))->with('success', 'Tag updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->posts()->sync([]);

        $tag->delete();

        return redirect(route('admin.tag.index'))->with('success', 'Tag deleted');
    }
}
