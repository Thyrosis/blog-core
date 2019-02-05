<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Form;
use App\FormField;
use App\FormResponse;

class FormController extends Controller
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
        // $forms = Form::all();
        // $responses = FormResponse::all();

        return view('core.admin.form.index')->with('forms', Form::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('core.admin.form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @version 20190123    Added required option to create form and store route
     * 
     * @todo    Need to make some validation rules for form (token/action).
     *          Also need to repopulate formfields on validation error.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        $form = Form::create($data);
        $form->fresh();

        for ($i = 0; $i < 5; $i++) {
            if (isset($request->elementName[$i]) && null !== $request->elementName[$i]) {
                FormField::create([
                    'form_id' => $form->id,
                    'input' => $request->input[$i],
                    'type' => ($request->input[$i] == "input" ? $request->type[$i] : null),
                    'name' => $request->elementName[$i],
                    'elementId' => str_slug($request->elementName[$i]),
                    'class' => $request->class[$i],
                    'description' => $request->description[$i],
                    'required' => $request->required[$i],
                ]);
            }
        }

        return redirect(route('admin.form.index'))->with('success', 'Form created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
