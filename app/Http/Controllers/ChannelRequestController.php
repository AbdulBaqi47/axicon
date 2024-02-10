<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ChannelRequest;

class ChannelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channelrequests = ChannelRequest::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(6);

        return view('requests.requests')->with('channelrequests', $channelrequests);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $channelrequests = ChannelRequest::orderBy('id', 'desc')->paginate(9);
        
        return view('admin.requests.list')->with('channelrequests', $channelrequests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.requests.create');
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
            'user_id' => 'required',
            'type' => 'required',
            'contact_details' => 'email|required',
            'extra_details' => 'required',
        ]);

        // Create Request

        $channelrequests = new ChannelRequest;
        $channelrequests->user_id = $request->input('user_id');
        $channelrequests->type = $request->input('type');
        $channelrequests->contact_details = $request->input('contact_details');
        $channelrequests->extra_details = $request->input('extra_details');
        $channelrequests->status = '0';
        
        $channelrequests->save();

        // Redirect
        return redirect('/requests')->with('success', 'Request Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $channelrequest = ChannelRequest::where('id', $id)->first();
        
        return view('requests.show')->with('channelrequest', $channelrequest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $channelrequest = ChannelRequest::where('id', $id)->first();
        
        return view('admin.requests.edit')->with('channelrequest', $channelrequest);
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
        // Update Request

        $channelrequests = ChannelRequest::find($id);

        $channelrequests->request_link = $request->input('request_link');
        $channelrequests->status = $request->input('status');

        
        $channelrequests->save();

        // Redirect
        return redirect('/admin/requests')->with('success', 'Request Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $channelrequest = ChannelRequest::findOrFail($id);

        $channelrequest->delete();

        // Redirect
        return redirect('/admin/requests')->with('success', 'Request Deleted Successfully');
    }
}
