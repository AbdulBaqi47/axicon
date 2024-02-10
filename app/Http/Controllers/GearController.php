<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GearItem;
use App\GearCategory;

class GearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gearCategories = GearCategory::orderBy('id', 'asc')->paginate('9');

        return view('gear.gear')->with('gearCategories', $gearCategories);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $gearCategories = GearCategory::orderBy('id', 'asc')->paginate(10);

        return view('admin.gear.list')->with('gearCategories', $gearCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gear.create');
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
            'image' => 'image|max:1999|required'
        ]);

        // New Category


        // Get filename with extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();

        // Get filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // Get extension
        $extension = $request->file('image')->getClientOriginalExtension();

        // Create new filename
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        
        // Upload image
        $path = $request->file('image')->storeAs('public/photos/apps', $filenameToStore);


        $gearCategory = new GearCategory;
        $gearCategory->name = $request->input('name');
        $gearCategory->slug = str_slug($gearCategory->name);
        $gearCategory->image_url = $filenameToStore;
        
        $gearCategory->save();

        // Redirect
        return redirect('/admin/gear')->with('success', 'Category Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $gearCategory = GearCategory::where('slug', $slug)->first();
        $gearItems = GearItem::where('category_id', $gearCategory->id)->orderBy('id', 'asc')->paginate('12');

        return view('gear.show')->with(['gearCategory' => $gearCategory, 'gearItems' => $gearItems]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gearCategory = GearCategory::where('id', $id)->first();

        return view('admin.gear.edit')->with('gearCategory', $gearCategory);
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
            'image' => 'image|max:1999'
        ]);

        // Update Category

        $gearCategory = GearCategory::find($id);

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
            $path = $request->file('image')->storeAs('public/photos/apps', $filenameToStore);

            $gearCategory->image_url = $filenameToStore;

        };

        $gearCategory->name = $request->input('name');
        $gearCategory->slug = str_slug($gearCategory->name);
        
        $gearCategory->save();

        // Redirect
        return redirect('/admin/gear')->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gearCategory = GearCategory::findOrFail($id);

        /* Delete photo from db and storage
        if(Storage::delete("storage/photos/gear/$gearCategory->image_url")){
            $gearCategory->delete();
        } */

        $gearCategory->delete();

        // Redirect
        return redirect('/admin/gear')->with('success', 'Category Deleted Successfully');
    }


    // ITEMS

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminItem($slug)
    {
        $gearCategory = GearCategory::where('slug', $slug)->first();

        $gearItems = GearItem::where('category_id', $gearCategory->id)->orderBy('id', 'asc')->paginate(10);

        return view('admin.gear.items.list')->with(['gearCategory' => $gearCategory, 'gearItems' => $gearItems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createItem($slug)
    {
        $gearCategory = GearCategory::where('slug', $slug)->first();

        return view('admin.gear.items.create')->with('gearCategory', $gearCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editItem($slug, $id)
    {
        $gearCategory = GearCategory::where('slug', $slug)->first();
        $gearItem = GearItem::where('id', $id)->first();

        return view('admin.gear.items.edit')->with(['gearCategory' => $gearCategory, 'gearItem' => $gearItem]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyItem($slug, $id)
    {
        $gearItem = GearItem::findOrFail($id);
        $categoryFind = $gearItem->category_id;
        $gearCategory = GearCategory::where('id', $categoryFind)->first();

        $gearItem->delete();

        // Redirect
        return redirect('/admin/gear/'.$gearCategory->slug)->with('success', 'Item Deleted Successfully');
    }
}
