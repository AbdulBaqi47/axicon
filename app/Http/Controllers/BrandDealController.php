<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use App\BrandDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brandIndex()
    {
        $user = User::where('id', Auth::id())->first();
        $brand = Brand::where('representative_id', $user->id)->first();
        $brandDeals = BrandDeal::where('brand_id', $brand->id)->paginate(5);

        return view('brand.deals.list')->with(['user' => $user, 'brand' => $brand, 'brandDeals' => $brandDeals]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brandShow($id)
    {
        $user = User::where('id', Auth::id())->first();
        $brand = Brand::where('representative_id', $user->id)->first();
        $deal = BrandDeal::where('id', $id)->first();
        
        $creatorList = explode(',', $deal->creators);
        $creators = [];

        foreach ($creatorList as $creator) {
            $c = User::where('id', $creator)->first();
            array_push($creators, $c);
        }

        $submissionList = explode(',', $deal->submissions);
        $submissions = [];
        $submissionCount = 0;

        foreach ($submissionList as $s) {
            array_push($submissions, $s);
        }
        
        return view('brand.deals.show')->with(['user' => $user, 'brand' => $brand, 'deal' => $deal, 'creators' => $creators, 'submissions' => $submissions, 'submissionCount' => $submissionCount]);
    }

    /**
     * Toggles the selected task between incomplete and complete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $deal = BrandDeal::where('id', $id)->first();
        $deal->approved = 1;
        $deal->save();

        return redirect('/brand/deals/'.$id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $brand = Brand::find($id);

        // Gather Creators
        $userList = User::all();
        $unassignedCreatorArray = [];

        foreach ($userList as $user) {
            if ($user->subscribed('influencer')) {
                array_push($unassignedCreatorArray, $user);
            }
        }

        return view('admin.brands.deals.create')->with(['brand' => $brand, 'unassignedCreatorArray' => $unassignedCreatorArray]);
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
            'status' => 'required',
            'brand_id' => 'integer|required'
        ]);

        // Creator Array
        if (null !== ($request->input('creators'))) {
            if (count($request->input('creators')) > 1) {
                $c = implode(',', $request->input('creators'));
            } else {
                $c = implode('', $request->input('creators'));
            } 
        } else {
            $c = null;
        }

        $countCreators = explode(',', $c);
        $submissions = [];
        foreach ($countCreators as $creator) {
            array_push($submissions, 'null');
        }
        $subs = implode(',', $submissions);
        

        // Create Brand Deal
        $brandDeals = new BrandDeal;
        $brandDeals->title = $request->input('title');
        $brandDeals->description = $request->input('description');
        $brandDeals->creators = $c;
        $brandDeals->submissions = $subs;
        $brandDeals->price = $request->input('price');
        $brandDeals->brand_id = $request->input('brand_id');
        $brandDeals->status = $request->input('status');
        $brandDeals->approved = 0;
        
        $brandDeals->save();

        // Redirect
        return redirect('/admin/brands/'.$brandDeals->brand_id)->with('success', 'Brand Deal Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($brand_id, $id)
    {
        $brand = Brand::where('id', $brand_id)->first();
        $brandDeal = BrandDeal::where('id', $id)->first();

        // Gather Creators
        $userList = User::all();
        $creatorList = explode(',', $brandDeal->creators);
        $unassignedCreatorArray = [];
        $creatorArray = [];

        foreach ($userList as $user) {

            if ($user->subscribed('influencer')) {

                if (in_array($user->id, $creatorList)) {
                    array_push($creatorArray, $user);
                } else {
                    array_push($unassignedCreatorArray, $user);
                }
                
            }
        }

        return view('admin.brands.deals.edit')->with(['brand' => $brand, 'brandDeal' => $brandDeal, 'unassignedCreatorArray' => $unassignedCreatorArray, 'creatorArray' => $creatorArray]);
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
            'status' => 'required',
            'brand_id' => 'integer|required'
        ]);

        // Update Brand Deal
        $brandDeals = BrandDeal::find($id);

        $currentCreators = explode(',', $brandDeals->creators);
        $currentSubmissions = explode(',', $brandDeals->submissions);
        $currentCombined = array_combine($currentCreators, $currentSubmissions);
        $subsArray = []; 

        // Creator Array
        if (null !== ($request->input('creators'))) {

            if (count($request->input('creators')) > 1) {

                $c = implode(',', $request->input('creators'));

                foreach ($request->input('creators') as $creator) {
                    if (array_key_exists($creator, $currentCombined)) {
                        array_push($subsArray, $currentCombined[$creator]);
                    } else {
                        array_push($subsArray, 'null');
                    }
                }

                $subs = implode(',', $subsArray);

            } else {

                $c = implode('', $request->input('creators'));

                if (array_key_exists($c, $currentCombined)) {
                    array_push($subsArray, $currentCombined[$c]);
                } else {
                    array_push($subsArray, 'null');
                }

                $subs = implode('', $subsArray);
            }

        } else {
            $c = null;
            $subs = null; 
        }

        $brandDeals->title = $request->input('title');
        $brandDeals->description = $request->input('description');
        $brandDeals->creators = $c;
        $brandDeals->submissions = $subs; 
        $brandDeals->price = $request->input('price');
        $brandDeals->brand_id = $request->input('brand_id');
        $brandDeals->status = $request->input('status');
        $brandDeals->approved = 0;
        
        $brandDeals->save();

        // Redirect
        return redirect('/admin/brands/'.$brandDeals->brand_id)->with('success', 'Brand Deal Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brandDeal = BrandDeal::findOrFail($id);
        $brands = Brand::where('id', $brandDeal->brand_id)->first();

        $brandDeal->delete();

        // Redirect
        return redirect('/admin/brands/'.$brands->id)->with('success', 'Brand Deal Deleted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewSubmissions($brand_id, $id)
    {
        $user = User::where('id', Auth::id())->first();
        $brand = Brand::where('id', $brand_id)->first();
        $deal = BrandDeal::where('id', $id)->first();
        
        $creatorList = explode(',', $deal->creators);
        $creators = [];

        foreach ($creatorList as $creator) {
            $c = User::where('id', $creator)->first();
            array_push($creators, $c);
        }

        $submissionList = explode(',', $deal->submissions);
        $submissions = [];
        $submissionCount = 0;

        foreach ($submissionList as $s) {
            array_push($submissions, $s);
        }

        return view('admin.brands.deals.submissions')->with(['brand' => $brand, 'deal' => $deal, 'creators' => $creators, 'submissions' => $submissions, 'submissionCount' => $submissionCount]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSubmissions(Request $request, $id)
    {   
        $deal = BrandDeal::find($id);
        $brand = Brand::where('id', $deal->brand_id)->first();

        $creatorList = explode(',', $deal->creators);

        $submissions = [];

        foreach ($creatorList as $c) {
            if (null !== $request->input($c)) {
                array_push($submissions, $request->input($c));
            } else {
                $sub = 'null';
                array_push($submissions, $sub);
            }
        }

        $deal->submissions = implode(',', $submissions);
        
        $deal->save();

        // Redirect
        return redirect('/admin/brands/'.$brand->id)->with('success', 'Deal Submissions Updated Successfully');
    }
}
