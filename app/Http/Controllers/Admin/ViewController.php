<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\View;
use Illuminate\Http\Request;

class ViewController extends Controller
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
        return view('core.admin.view.index')->with('views', View::with('post')->get()); 
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\View  $View
     * @return \Illuminate\Http\Response
     */
    public function show(View $view)
    {
        return view('core.admin.view.show')->with('view', $view); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\View  $View
     * @return \Illuminate\Http\Response
     */
    public function edit(View $View)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\View  $View
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, View $View)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\View  $View
     * @return \Illuminate\Http\Response
     */
    public function destroy(View $View)
    {
        //
    }
}
