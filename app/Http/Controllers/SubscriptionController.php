<?php

namespace App\Http\Controllers;

use App\User;
use Braintree\ClientToken;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.subscriptions');
    }

    /**
     * Return the braintree client token to the front-end.
     *
     * @return \Illuminate\Http\Response
     */
    public function token()
    {
        return response()->json([
            'data' => [
                'token' => \Braintree_ClientToken::generate()
            ]
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $subscriptions = Subscription::orderBy('id', 'asc')->paginate(10);

        return view('admin.subscriptions.list')->with('subscriptions', $subscriptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $nonce = $request->payment_method_nonce;

        $user->newSubscription('influencer', 'influencer-monthly')->create($nonce);

        return redirect('/settings')->with('success', 'You are now subscribed to Influencer Social!');

    }

    /**
     * Cancels the user's influencer subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $request->user()->subscription('influencer')->cancel();

        return redirect('/settings')->with('success', 'You have successfully cancelled your subscription');
    }

    /**
     * Resumes the user's influencer subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resume(Request $request)
    {
        $request->user()->subscription('influencer')->resume();

        return redirect('/settings')->with('success', 'You have successfully resumed your subscription');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
