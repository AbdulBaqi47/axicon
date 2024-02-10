<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sponsorship;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsorships = Sponsorship::orderBy('id', 'asc')->paginate(6);

        return view('sponsorships.sponsorships')->with('sponsorships', $sponsorships);

    }

    /**
     * Display an admin listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $sponsorships = Sponsorship::orderBy('id', 'asc')->paginate(9);

        return view('admin.sponsorships.list')->with('sponsorships', $sponsorships);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sponsorships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'added_by' => 'required',
            'requirements' => 'required',
            'image' => 'image|max:1999|required'
        ]);

        // Create Sponsorship

        // Get filename with extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();

        // Get filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // Get extension
        $extension = $request->file('image')->getClientOriginalExtension();

        // Create new filename
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        
        // Upload image
        $path = $request->file('image')->storeAs('public/photos/sponsorships', $filenameToStore);

        $sponsorships = new Sponsorship;
        $sponsorships->title = $request->input('title');
        $sponsorships->description = $request->input('description');
        $sponsorships->link = $request->input('link');
        $sponsorships->image_url = $filenameToStore;
        $sponsorships->added_by = $request->input('added_by');
        $sponsorships->requirements = $request->input('requirements');
        
        $sponsorships->save();

        // Redirect
        return redirect('/admin/sponsorships')->with('success', 'Sponsorship Added Successfully');
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
        $sponsorship = Sponsorship::find($id);

        return view('admin.sponsorships.edit')->with('sponsorship', $sponsorship);
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
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
            'added_by' => 'required',
            'requirements' => 'required',
            'image' => 'image|max:1999'
        ]);

        // Update App

        $app = App::find($id);

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
            $path = $request->file('image')->storeAs('public/photos/sponsorships', $filenameToStore);

            $app->image_url = $filenameToStore;

        };

        $app->title = $request->input('title');
        $app->description = $request->input('description');
        $app->link = $request->input('link');
        $app->added_by = $request->input('added_by');
        $app->requirements = $request->input('requirements');
        
        $app->save();

        // Redirect
        return redirect('/admin/sponsorships')->with('success', 'Sponsorship Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsorship = Sponsorship::findOrFail($id);

        /* Delete photo from db and storage
        if(Storage::delete("storage/photos/sponsorships/$sponsorship->image_url")){
            $sponsorship->delete();
        } */

        $sponsorship->delete();

        // Redirect
        return redirect('/admin/sponsorships')->with('success', 'Sponsorship Deleted Successfully');
    }
}