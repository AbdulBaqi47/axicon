<?php

namespace App\Http\Controllers;

use App\Home;
use App\User;
use App\YoutubeChannel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();

        $home = Home::where('id', '1')->first();

        //Role::create(['name' => 'admin']);
        //Role::create(['name' => 'partner-manager']);
        //Role::create(['name' => 'support']);
        //Role::create(['name' => 'brand']);

        //$user->assignRole('admin');
        //$user->removeRole('admin');

        //$user->assignRole('partner-manager');
        //$user->removeRole('partner-manager');

        //$user->assignRole('support');
        //$user->removeRole('support');

        //$user->assignRole('brand');
        //$user->removeRole('brand');


        return view('home')->with(['user' => $user, 'home' => $home]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $home = Home::where('id', '1')->first();

        return view('edit')->with('home', $home);
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
            'name' => 'max:255',
            'creator' => 'max:255',
            'url' => 'required'
        ]);

        // Update Featured Video

        $home = Home::where('id', '1')->first();

        $home->featured_video_name = $request->input('name');
        $home->featured_video_creator = $request->input('creator');
        $home->featured_video_url = $request->input('url');
        
        $home->save();

        // Redirect
        return redirect('/home');
    }
}
