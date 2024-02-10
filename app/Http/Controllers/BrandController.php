<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use App\BrandDeal;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $brands = Brand::orderBy('id', 'asc')->paginate(10);

        return view('admin.brands.list')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userList = User::all();
        
        return view('admin.brands.create')->with('userList', $userList);
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
            'name' => 'required',
            'representative_id' => 'required'
        ]);

        // Create Brand

        $brands = new Brand;
        $brands->name = $request->input('name');
        $brands->email = $request->input('email');
        $brands->phone = $request->input('phone');
        $brands->website = $request->input('website');
        $brands->notes = $request->input('notes');

        // Brand Representative
        $newRep = User::where('id', $request->input('representative_id'))->first();
        $newRep->assignRole('brand');
        $brands->representative_id = $request->input('representative_id');
        
        $brands->save();

        // Redirect
        return redirect('/admin/brands')->with('success', 'Brand Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        $brandDeals = BrandDeal::where('brand_id', $id)->paginate(5);

        return view('admin.brands.show')->with(['brand' => $brand, 'brandDeals' => $brandDeals]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::where('id', $id)->first();
        $userList = User::all();

        return view('admin.brands.edit')->with(['brand' => $brand, 'userList' => $userList]);
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
            'name' => 'required',
            'representative_id' => 'required'
        ]);

        // Update Brand

        $brands = Brand::find($id);
        $brands->name = $request->input('name');
        $brands->email = $request->input('email');
        $brands->phone = $request->input('phone');
        $brands->website = $request->input('website');
        $brands->notes = $request->input('notes');
        
        if ($brands->representative_id != $request->input('representative_id')) {
            // If existing rep's ID is not equal to the new rep's ID.
            $oldRep = User::where('id', $brands->representative_id)->first();
            $newRep = User::where('id', $request->input('representative_id'))->first();
            $oldRep->removeRole('brand');
            $newRep->assignRole('brand');

            $brands->representative_id = $request->input('representative_id');
        }
        
        $brands->save();

        // Redirect
        return redirect('/admin/brands')->with('success', 'Brand Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $deals = BrandDeal::where('brand_id', $id)->get();

        foreach ($deals as $deal) {
            $deal->delete();
        }
        
        $brand->delete();

        // Redirect
        return redirect('/admin/brands')->with('success', 'Brand Deleted Successfully');
    }
}
