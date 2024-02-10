<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Education;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educations = Education::where('published', '1')->orderBy('id')->paginate(9);
        //$educations = Education::orderBy('id', 'asc')->paginate(9);

        return view('education.education')->with('educations', $educations);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $educations = Education::orderBy('id', 'asc')->paginate(9);
        
        return view('admin.education.list')->with('educations', $educations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.education.create');
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
            'added_by' => 'required',
            'published' => 'required',
            'content' => 'required',
            'image' => 'image|max:1999|required'
        ]);

        // Create Education Post

        $filenameWithExt = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        // Upload image
        $path = $request->file('image')->storeAs('public/photos/education', $filenameToStore);


        $education = new Education;
        $education->title = $request->input('title');
        $education->slug = str_slug($education->title);
        $education->added_by = $request->input('added_by');
        $education->published = $request->input('published');
        $education->content = $request->input('content');
        $education->image_url = $filenameToStore;
        
        $education->save();

        // Redirect
        return redirect('/admin/education')->with('success', 'Post Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $education = Education::where('slug', $slug)->first();

        return view('education.show')->with('education', $education);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $education = Education::find($id);

        return view('admin.education.edit')->with('education', $education);
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
            'added_by' => 'required',
            'published' => 'required',
            'content' => 'required',
            'image' => 'image|max:1999'
        ]);

        // Update Education Post

        $education = Education::find($id);

        if (null !== $request->file('image')) {

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('image')->storeAs('public/photos/education', $filenameToStore);

            $education->image_url = $filenameToStore;

        }

        $education->title = $request->input('title');
        $education->slug = str_slug($education->title);
        $education->added_by = $request->input('added_by');
        $education->published = $request->input('published');
        $education->content = $request->input('content');
        
        $education->save();

        // Redirect
        return redirect('/admin/education')->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $education = Education::findOrFail($id);

        /* Delete photo from db and storage
        if(Storage::delete("storage/photos/apps/$app->image_url")){
            $app->delete();
        } */

        $education->delete();

        // Redirect
        return redirect('/admin/education')->with('success', 'Post Deleted Successfully');
    }
}
