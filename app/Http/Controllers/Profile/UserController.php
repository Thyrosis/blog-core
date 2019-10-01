<?php

namespace App\Http\Controllers\Profile;

use App\User;
use App\Meta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('core.admin.profile.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (auth()->id() !== $user->id) {
            return redirect(route('home'))->with('warning', "You tried to access a page you are not allowed to see.");
        }

        return view('core.admin.profile.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (auth()->id() !== $user->id) {
            return redirect(route('home'))->with('warning', "You tried to access a page you are not allowed to see.");
        }

        $data = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        if (isset($request->api_token) && !empty($request->api_token)) {
            $data['api_token'] = Hash::make($request->api_token);
        }
        
        $user->update($data);

        foreach (Meta::all() as $meta) {
            if ($meta->updateable) {
                $user->updateMeta($meta->code, $request->{$meta->code});
            }
        }

        return redirect(route('profile.show', $user))->with("success", "User updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
