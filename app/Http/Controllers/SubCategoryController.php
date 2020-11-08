<?php

namespace App\Http\Controllers;

use App\SubCategory;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::orderBy('created_at', 'DESC')->get();
        return view('admin.subcategories.index')->with('subcategories', $subcategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();

        return view('admin.subcategories.add')->with('cats', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $subCategory = new SubCategory();
        $subCategory->title = $request->input('title');
        $subCategory->category_id = $request->input('category_id');

        $subCategory->save();

        $result = [
            'message' => 'Subcategory Added successfully',
            'status' => 'true',
        ];

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subCategoryid)
    {
        $subCategory = SubCategory::find($subCategoryid);
        $subCategory->title = $request->title;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        return redirect('/admin/subcategories')->with('success', 'SubCategory Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($subCategoryid)
    {
        $assoc_prods = Product::where('subcategory_id', $subCategoryid)->get();

        $no = $assoc_prods->count();



        if ($no > 0) {
            return redirect('/admin/subcategories')->with('info', 'You Cannot Delete this subcategory. It has products associated to it!!');
        } else {
            $subCategory = SubCategory::find($subCategoryid);
            $subCategory->delete();
            return redirect('/admin/subcategories')->with('success', 'SubCategory Deleted Successfully!!');
        }
    }
    public function search_subcategory(Request $request)
    {
          $category = $request->input('category');

          $subCategory = SubCategory::where('category_id',$category)->get();

          return response()->json($subCategory);
        // return $subCategory;
    }
}
