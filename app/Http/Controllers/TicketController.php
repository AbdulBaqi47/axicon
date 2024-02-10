<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Ticket;
use App\Comment;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(6);
        
        return view('support.support')->with('tickets', $tickets);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $tickets = Ticket::orderBy('id', 'asc')->paginate(10);
        
        return view('admin.support.list')->with('tickets', $tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.support.create');
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
            'message' => 'required',
            'priority' => 'required',
        ]);

        // Create Ticket

        $ticket = new Ticket;
        $ticket->title = $request->input('title');
        $ticket->message = htmlspecialchars($request->input('message'));
        $ticket->priority = $request->input('priority');
        $ticket->user_id = Auth::user()->id;
        $ticket->status = 'Opened';
        
        $ticket->save();

        // Redirect
        return redirect('/support')->with('success', 'Ticket Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $comments = Comment::where('ticket_id', $id)->paginate(10);
        $user = User::where('id', $ticket->user_id);

        return view('support.show')->with(['ticket' => $ticket, 'comments' => $comments, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::where('id', $id)->first();

        return view('admin.support.edit')->with('ticket', $ticket);
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
            'message' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);

        // Update Ticket

        $ticket = Ticket::find($id);

        $ticket->title = $request->input('title');
        $ticket->message = htmlspecialchars($request->input('message'));
        $ticket->priority = $request->input('priority');
        $ticket->status = $request->input('status');
        
        $ticket->save();

        // Redirect
        return redirect('/support')->with('success', 'Ticket Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $comments = Comment::where('ticket_id', $id)->get();

        $ticket->delete();
        
        foreach ($comments as $comment) {
            $comment->delete();
        }

        // Redirect
        return redirect('/admin/support')->with('success', 'Ticket Deleted Successfully');
    }
}
