<?php

namespace App\Http\Controllers;

use App\FeaturedVideo;
use Illuminate\Http\Request;

class FeaturedVideoController extends Controller
{
    /**
     * Display a listing of the resource including any applied filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->category)) {
            
            if ($request->category == 'all') {

                $videos = FeaturedVideo::orderBy('updated_at', 'desc')->paginate(9);
                $category = 'all';

                return view('videos.videos')->with(['videos' => $videos, 'category' => $category]);

            } else {

                $videos = FeaturedVideo::where('category', $request->category)->orderBy('updated_at', 'desc')->paginate(9);
                $category = $request->category;

                return view('videos.videos')->with(['videos' => $videos, 'category' => $category]);

            }

        } else {
            
            $videos = FeaturedVideo::orderBy('updated_at', 'desc')->paginate(9);
            $category = 'all';

            return view('videos.videos')->with(['videos' => $videos, 'category' => $category]);

        }
    }

    /**
     * Display a listing of the resource including any applied filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin(Request $request)
    {
        if (isset($request->category)) {
            
            if ($request->category == 'all') {

                $videos = FeaturedVideo::orderBy('id', 'asc')->paginate(9);
                $category = 'all';
                
                return view('admin.videos.list')->with(['videos' => $videos, 'category' => $category]);

            } else {

                $videos = FeaturedVideo::where('category', $request->category)->orderBy('id', 'asc')->paginate(9);
                $category = $request->category;

                return view('admin.videos.list')->with(['videos' => $videos, 'category' => $category]);

            }

        } else {
            
            $videos = FeaturedVideo::orderBy('id', 'asc')->paginate(9);
            $category = 'all';

            return view('admin.videos.list')->with(['videos' => $videos, 'category' => $category]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.videos.create');
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
            'url' => 'required',
            'creator' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        // Create Featured Video

        $video = new FeaturedVideo;
        $video->title = $request->input('title');
        $video->url = $request->input('url');
        $video->creator = $request->input('creator');
        $video->category = $request->input('category');
        $video->description = $request->input('description');
        
        $video->save();

        // Redirect
        return redirect('/admin/videos')->with('success', 'Video Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = FeaturedVideo::where('id', $id)->first();
        return view('admin.videos.edit')->with('video', $video);
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
            'url' => 'required',
            'creator' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        // Update Featured Video

        $video = FeaturedVideo::where('id', $id)->first();
        $video->title = $request->input('title');
        $video->url = $request->input('url');
        $video->creator = $request->input('creator');
        $video->category = $request->input('category');
        $video->description = $request->input('description');
        
        $video->save();

        // Redirect
        return redirect('/admin/videos')->with('success', 'Video Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = FeaturedVideo::where('id', $id)->first();
        $video->delete();

        return view('admin.videos.list')->with('success', 'Video Deleted Successfully');
    }
}
