<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GearItem;
use App\GearCategory;

class ItemController extends Controller
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
            'title' => 'required',
            'description' => 'required',
            'link' => 'url|required',
            'category_id' => 'required',
            'image' => 'image|max:1999|required'
        ]);

        // New Item


        // Get filename with extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();

        // Get filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // Get extension
        $extension = $request->file('image')->getClientOriginalExtension();

        // Create new filename
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        
        // Upload image
        $path = $request->file('image')->storeAs('public/photos/gear/items', $filenameToStore);


        $gearItem = new GearItem;
        $gearItem->title = $request->input('title');
        $gearItem->description = $request->input('description');
        $gearItem->link = $request->input('link');
        $gearItem->category_id = $request->input('category_id');
        $gearItem->image_url = $filenameToStore;
        
        $gearItem->save();

        // Redirect
        $gearCategory = GearCategory::where('id', $gearItem->category_id)->first();
        return redirect('/admin/gear/'.$gearCategory->slug)->with('success', 'Item Created Successfully');
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
            'link' => 'url|required',
            'category_id' => 'required',
            'image' => 'image|max:1999'
        ]);

        // New Item

        $gearItem = GearItem::find($id);

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
            $path = $request->file('image')->storeAs('public/photos/gear/items', $filenameToStore);

            $gearItem->image_url = $filenameToStore;

        };

        $gearItem->title = $request->input('title');
        $gearItem->description = $request->input('description');
        $gearItem->link = $request->input('link');
        $gearItem->category_id = $request->input('category_id');
        
        $gearItem->save();

        // Redirect
        $gearCategory = GearCategory::where('id', $gearItem->category_id)->first();
        return redirect('/admin/gear/'.$gearCategory->slug)->with('success', 'Item Updated Successfully');
    }

}
