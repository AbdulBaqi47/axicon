<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\App;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = App::orderBy('id', 'asc')->paginate(6);

        return view('apps.apps')->with('apps', $apps);

    }

    /**
     * Display an admin listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $apps = App::orderBy('id', 'asc')->paginate(9);

        return view('admin.apps.list')->with('apps', $apps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apps.create');
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
            'image' => 'image|max:1999|required'
        ]);

        // Create App

        // Get filename with extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();

        // Get filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // Get extension
        $extension = $request->file('image')->getClientOriginalExtension();

        // Create new filename
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        
        // Upload image
        $path = $request->file('image')->storeAs('public/photos/apps', $filenameToStore);

        $apps = new App;
        $apps->title = $request->input('title');
        $apps->description = $request->input('description');
        $apps->link = $request->input('link');
        $apps->image_url = $filenameToStore;
        $apps->added_by = $request->input('added_by');
        
        $apps->save();

        // Redirect
        return redirect('/admin/apps')->with('success', 'App Added Successfully');
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
        $app = App::find($id);

        return view('admin.apps.edit')->with('app', $app);
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
            $path = $request->file('image')->storeAs('public/photos/apps', $filenameToStore);

            $app->image_url = $filenameToStore;

        };

        $app->title = $request->input('title');
        $app->description = $request->input('description');
        $app->link = $request->input('link');
        $app->added_by = $request->input('added_by');
        
        $app->save();

        // Redirect
        return redirect('/admin/apps')->with('success', 'App Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $app = App::findOrFail($id);

        /* Delete photo from db and storage
        if(Storage::delete("storage/photos/apps/$app->image_url")){
            $app->delete();
        } */

        $app->delete();

        // Redirect
        return redirect('/admin/apps')->with('success', 'App Deleted Successfully');
    }
}
