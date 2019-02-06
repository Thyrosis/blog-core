<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use App\Search;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view()->first(['search.create', 'core.search.create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate(
            [
                'term' => 'required'
            ]
        );
        
        $term = $data['term'];

        $data['result'] = Post::where('published', 1)->where(function ($query) use ($term) {
            $query->where('body', 'like', '%' . $term . '%')
            ->orWhere('summary', 'like', '%' . $term . '%')
            ->orWhere('longTitle', 'like', '%' . $term . '%')
            ->orWhere('title', 'like', '%' . $term . '%');
        })->pluck('id');

        $data['uuid'] = (string)Str::uuid();

        $data['user_id'] = auth()->id();

        return redirect(route('search.show', Search::create($data)));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Search $search)
    {
        return view()->first(['search.show', 'core.search.show'])->with('search', $search)->with('posts', Post::find($search->result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
