<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Ticket;
use App\Comment;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ticket_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
        ]);

        // Create Comment

        $comment = new Comment;
        $comment->ticket_id = $request->input('ticket_id');
        $comment->user_id = $request->input('user_id');
        $comment->comment = htmlspecialchars($request->input('comment'));

        $user = User::where('id', $request->input('user_id'))->first();
        $comment->user_name = $user->name;
        $comment->user_avatar = $user->avatar;
        //$comment->user_role = $user->role;
        $comment->user_role = "User";

        $comment->save();

        // Update Ticket

        $ticket = Ticket::where('id', $comment->ticket_id)->first();

        if ($comment->user_id == $ticket->user_id) {
            $ticket->status = "Opened";
        }
        else {
            $ticket->status = "Update";
        }

        $ticket->touch();

        $ticket->save();

        // Redirect
        return redirect("/support/$comment->ticket_id")->with('success', 'Comment Added Successfully');
    }
    
}
