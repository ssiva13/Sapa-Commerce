<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;
use File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        return view('admin.brands.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required | max:225',
            'photo' => 'nullable | image | max:1999',
            'active-brand' => 'nullable'
        ));


        $brand = new Brand();

        $brand->title = $request->input('title');

        if (($brand->active = $request->input('active-brand')) != "") {
            $brand->active = "active";
        }

        if ($request->hasFile('photo')) {


            $brand_image = $request->file('photo');
            $filename = $brand->title . '-' . time() . '-' . $brand_image->getClientOriginalName();

            $brand_image->move('zoom/brands/', $filename);

            $brand->photo = $filename;
        } else {
            $filename = '';
            $brand->photo = $filename;
        }
        $brand->save();
        return redirect()->route('brands.index')->with('success', 'Brand Added Successfully');
        // return redirect()->route('/admin/brands')->with('success', 'Brand Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(brand $brand)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, brand $brand)
    {
        $brand->title = $request->input('title');

        if (($brand->active = $request->input('active-brand')) != "") {
            $brand->active = "active";
        }

        if ($request->hasFile('photo')) {


            $brand_image = $request->file('photo');
            $filename = $brand->title . '-' . time() . '-' . $brand_image->getClientOriginalName();

            $brand_image->move('zoom/brands/', $filename);

            $oldFilename = $brand->photo;
            $brand->photo = $filename;
            if (!empty($brand->photo)) {
                File::delete('zoom/brands/'. $oldFilename);
            }

            $brand->photo = $filename;
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(brand $brand)
    {
        $assoc_prods = Product::where('brand_id', $brand->id)->get();
        $no = $assoc_prods->count();
        if ($no > 0) {
            return redirect('/admin/brands')->with('info', 'You Cannot Delete this brand. It has products associated to it!!');
        } else {
            $brand->delete();
            return redirect('/admin/brands')->with('success', 'Brand Deleted Successfully!!');
        }
    }
}
