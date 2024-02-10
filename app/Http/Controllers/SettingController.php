<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        
        return view('user.settings')->with('user', $user);
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'image' => 'image|max:1999'
        ]);
        
        $user = User::where('id', Auth::user()->id)->first();

        if (null !== $request->file('image')) {

            // Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();

            // Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            
            // Get extension
            $extension = $request->file('image')->getClientOriginalExtension();

            // Create new filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            
            // Upload image
            $path = $request->file('image')->storeAs('public/photos/avatars', $filenameToStore);

            $user->avatar = $filenameToStore;

        };

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->influencer_bio = $request->input('influencer_bio');

        $user->save();

        // Redirect
        return redirect('/settings')->with('success', 'Settings Updated Successfully');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function avatarReset(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->avatar = 'no_avatar.jpg';

        $user->save();

        // Redirect
        return redirect('/settings')->with('success', 'Avatar Reset Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSocials(Request $request)
    {
        
        $user = User::where('id', Auth::user()->id)->first();

        if ($request->input('twitch_id') == '') {
            $user->twitch_id = null;
        } else {
            $user->twitch_id = $request->input('twitch_id');
        }
        if ($request->input('twitter_id') == '') {
            $user->twitter_id = null;
        } else {
            $user->twitter_id = $request->input('twitter_id');
        }
        if ($request->input('facebook_id') == '') {
            $user->facebook_id = null;
        } else {
            $user->facebook_id = $request->input('facebook_id');
        }
        if ($request->input('instagram_id') == '') {
            $user->instagram_id = null;
        } else {
            $user->instagram_id = $request->input('instagram_id');
        }

        $user->save();

        // Redirect
        return redirect('/settings')->with('success', 'Social Profiles Updated Successfully');
    }
}
