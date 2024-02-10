<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Download;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $downloads = Download::where('access', 'all')->orderBy('id', 'asc')->paginate(10);
        
        return view('downloads.downloads')->with('downloads', $downloads);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $downloads = Download::orderBy('id', 'asc')->paginate(10);

        return view('admin.downloads.list')->with('downloads', $downloads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.downloads.create');
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
            'access' => 'required',
            'file' => 'file|max:1999|required'
        ]);

        // Create Download

        $filenameWithExt = $request->file('file')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        // Upload file
        $path = $request->file('file')->storeAs('public/files/downloads', $filenameToStore);


        $download = new Download;
        $download->title = $request->input('title');
        $download->description = $request->input('description');
        $download->link = $filenameToStore;
        $download->access = $request->input('access');
        
        $download->save();

        // Redirect
        return redirect('/admin/downloads')->with('success', 'Download Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $download = Download::where('id', $id)->first();
        
        return view('admin.downloads.edit')->with('download', $download);
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
            'access' => 'required',
            'file' => 'file|max:1999'
        ]);

        // Update Download

        $download = Download::find($id);

        if (null !== $request->file('file')) {
            
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload file
            $path = $request->file('file')->storeAs('public/files/downloads', $filenameToStore);

            $download->link = $filenameToStore;
        }

        $download->title = $request->input('title');
        $download->description = $request->input('description');
        $download->access = $request->input('access');
        
        $download->save();

        // Redirect
        return redirect('/admin/downloads')->with('success', 'Download Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $download = Download::findOrFail($id);

        /* Delete photo from db and storage
        if(Storage::delete("storage/photos/apps/$app->image_url")){
            $app->delete();
        } */

        $download->delete();

        // Redirect
        return redirect('/admin/downloads')->with('success', 'Download Deleted Successfully');
    }

    /**
     * Downloads the specified resource.
     *
     * @param  int  $link
     * @return \Illuminate\Http\Response
     */
    public function download($link)
    {
        $filePath = storage_path('app/public/files/downloads/'.$link);
        if (! file_exists($filePath)) {
            return redirect('/downloads')->with('danger', 'Download Not Found');
        }

        return response()->download($filePath);
    }

}
