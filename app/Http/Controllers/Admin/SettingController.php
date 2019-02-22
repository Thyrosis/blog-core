<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('core.admin.setting.edit')->with('settings', Setting::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        foreach ($request->except(['_token', '_method']) as $code => $value) {
            Setting::updateSingle($code, $value);
        }

        return redirect(route('admin.setting.edit'))->with('success', 'Settings successfully updated.');
    }
}
