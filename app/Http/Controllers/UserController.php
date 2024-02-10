<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except('brand.influencers');
        $this->middleware('auth', ['except' => 'brandView']);
    }

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $users = User::orderBy('id', 'asc')->paginate(9);

        return view('admin.users.list')->with('users', $users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brandView()
    {
        $users = User::orderBy('id', 'asc')->paginate(10);

        return view('brand.influencers')->with('users', $users);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        if (null !== User::where('id', $id)->value('id'))
        {
            return view('admin.users.show')->with('user', $user);
        } else {
            // Redirect
            return redirect('/admin/users')->with('danger', 'The requested user does not exist.');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        return view('admin.users.edit')->with('user', $user);
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
            'image' => 'image|max:1999',
            'role' => 'required',
        ]);
        
        $user = User::where('id', $id)->first();

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

        $role = $request->input('role');

        if ($role == "admin") {
            $user->removeRole('admin');
            $user->removeRole('partner-manager');
            $user->removeRole('support');
            
            $user->assignRole('admin');
        } elseif ($role == "partner-manager") {
            $user->removeRole('admin');
            $user->removeRole('partner-manager');
            $user->removeRole('support');
            
            $user->assignRole('partner-manager');
        } elseif ($role == "support") {
            $user->removeRole('admin');
            $user->removeRole('partner-manager');
            $user->removeRole('support');
            
            $user->assignRole('support');
        } else {
            $user->removeRole('admin');
            $user->removeRole('partner-manager');
            $user->removeRole('support');
        }

        $user->save();

        // Redirect
        return redirect('/admin/users')->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        // Redirect
        return redirect('/admin/users')->with('success', 'User Deleted Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function avatarReset(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->avatar = 'no_avatar.jpg';

        $user->save();

        // Redirect
        return redirect('/admin/users')->with('success', 'User Avatar Reset Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSocials(Request $request, $id)
    {
        
        $user = User::where('id', $id)->first();

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
        return redirect('/admin/users')->with('success', 'User Updated Successfully');
    }
}
