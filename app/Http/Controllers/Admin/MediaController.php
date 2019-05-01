<?php

namespace App\Http\Controllers\Admin;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('core.admin.media.index')->with('medias', Media::all())->with('categories', Media::categories());;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'uploadedFiles' => 'required',
            'label' => 'nullable',
            'description' => 'nullable'
        ]);

        foreach ($request->uploadedFiles as $file) {
            $category = (!empty($request->category)) ? $request->category : "random";
            $path = $file->store($category);
            Media::create(['user_id' => auth()->id(), 'filepath' => $path, 'filename' => $file->getClientOriginalName(), 'category' => $category, 'filetype' => $file->getClientMimeType(), 'label' => $data['label'], 'description' => $data['description']]);
        }

        return redirect(route('admin.media.index'))->with('success', 'De bestanden zijn succesvol geupload.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }
}
