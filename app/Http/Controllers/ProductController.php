<?php

namespace App\Http\Controllers;
use App\Product;
use App\Brand;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Image;
use App\Photo;
use File;


class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')->paginate(50);
        return view('admin.products.index')->with('products',$products);
    }

    public function search(Request $request)
    {
        $message = $request->my_query;
        $products = Product::search($request->my_query, null, true)->paginate(50)->setPath ( '' );
        $pagination = $products->appends($request->all());
        return view('admin.products.index')->with('products', $products)
                                                ->with('message', $message)
                                                ->withQuery($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();

        return view('admin.products.add')->with('cats',$categories)->with('subcats',$subcategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required'
        ]);
        $brand = null;
        $brands = Brand::all();
        foreach($brands as $brand_item){
            if(strtoupper($brand_item->title) == strtoupper($request->brand)){
                $brand  = $brand_item;
                break;
            }
        }
        if($brand == null){
            $brand = Brand::create([
                'title' => $request->brand
            ]);
            $brand_id = $brand->id;
        }
        else {
            $brand_id = $brand->id;
        }
        Product::create([
            'title' => $request->title,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'brand_id' => $brand_id,
            'description' => $request->description,
            'price' => $request->price,
            'top' => $request->top,
            'image' => $request->image,
        ]);
        $result = ['message' => 'Product has been added', 'status' => 'true', 'title' => 'Product Added!'];

        return response()->json($result);
    }
    public function get_image(Request $request)
    {
        $photos = $request->file('file');
        if(!is_Array($photos)){
            $photos = [$photos];
        }
        $n = 1;
        foreach($photos as $image){
            $image_name = time() . $n . $image->getClientOriginalName();
            $image_new_name = 'uploads/' . $image_name;
            // $new_image = Image::make($image->getRealPath())->fit(270, 244, function ($constraint) {
            //     $constraint->upsize();
            // });
            $new_image = optimize_image($image, 270, 244);
            $zoomed_image = optimize_image($image, 800, 800);
            $new_image->save($image_new_name);
            $zoomed_image->save('zoom/'.$image_new_name);
            $image_names = $image_new_name;
            $n++;

            $photo = Photo::create([
                'photo' => $image_new_name,
                'original_name' => $image->getClientOriginalName()
            ]);
        }


        $arr = ['message' => 'Image saved Successfully', 'title' => 'Success', 'status' => 'true','image' => $image_names];


        return response()->json($arr);
    }
    public function cover_photo(Product $product, $cover_image)
    {
        if($product->image == null){
            // $stored_array = [];
            return redirect()->back()->with('error', 'Could not find any image.');
        }
        else {
            $stored_array = explode(',', $product->image);
            $temp = $stored_array[0];
            $stored_array[0] = $stored_array[$cover_image];
            $stored_array[$cover_image] = $temp;
            $product->image = implode(',', $stored_array);
            $product->save();
            return redirect()->back()->with('success', 'You successfully changed the cover photo');
        }

    }
    public function search_brand(Request $request)
    {
          $search = $request->get('term');

          $result = Brand::where('title', 'LIKE', '%'. $search. '%')->take(10)->get();

          return response()->json($result);

    }
    public function autocomplete_product(Request $request)
    {
        $search = $request->get('term');
        $category_id = $request->cat;
        if($category_id)
            $result = Product::where('category_id', $category_id)->where('title', 'LIKE', '%'. $search. '%')->take(10)->get();
        else
            $result = Product::where('title', 'LIKE', '%'. $search. '%')->take(10)->get();

        return response()->json($result);

    }
    public function autosearch()
    {
        return view('admin.search');
    }

    public function add_images(Request $request)
    {
        $product = Product::find($request->id);
        if($product->image == null){
            $stored_array = [];
        }
        else {
            $stored_array = explode(',', $product->image);
        }
        $photos = $request->file('file');
        if(!is_Array($photos)){
            $photos = [$photos];
        }
        $n = 1;
        $image_names = [];
        foreach($photos as $image){
            $image_name = time() . $n . $image->getClientOriginalName();
            $image_new_name = 'uploads/' . $image_name;

            // $new_image = Image::make($image->getRealPath())->fit(270, 244, function ($constraint) {
            //     $constraint->upsize();
            // });
            $new_image = optimize_image($image, 270, 244);
            $zoomed_image = optimize_image($image, 800, 800);
            $new_image->save($image_new_name);
            $zoomed_image->save('zoom/'.$image_new_name);
           
            $image_names[] = $image_new_name;
            $n++;

            $photo = Photo::create([
                'photo' => $image_new_name,
                'original_name' => $image->getClientOriginalName()
            ]);
        }
        $new_image_list = implode(',', array_merge($stored_array, $image_names));
        $product->image = $new_image_list;
        $product->save();

        $arr = ['message' => 'Image added Successfully', 'title' => 'Image Added', 'status' => 'true','image' => $image_names];


        return response()->json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();

        if($product->image == null){
            $prod_images = [];
        }
        else{
            $prod_images = explode(',',$product->image);
        }
        return view('admin.products.show')->with('product',$product)->with('images',$prod_images)->with('cats',$categories)->with('subcats',$subcategories);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.products.edit')->with('product',$product)->with('cats',$categories)->with('subcats',$subcategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $brand = Brand::where('title', $request->brand_id)->first();
        if($brand == null){
            $brand = Brand::create([
                'title' => $request->brand_id
            ]);
            $product->brand_id = $brand->id;
        }
        else {
            $product->brand_id = $brand->id;
        }
        $product->title = $request->title;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory;
        $product->price = $request->price;
        $product->top = $request->top;
        $product->description = $request->description;
        $product->save();


        $product_array = [
            'title' => $product->title,
            'category' => $product->category->title,
            'category_id' => $product->category->id,
            'subcategory' => $product->subcategory->title,
            'subcategory_id' => $product->subcategory->id,
            'brand' => $product->brand->title,
            'top' => $product->top,
            'desc' => $product->description,
            'price' => $product->price
        ];
        $prod_new = json_encode($product_array);
        // return $prod_new;
        $arr = ['message' => 'Product Details Updated', 'title' => 'Product Updated!', 'product' => $prod_new];
        return response()->json($arr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image == null){
            $product_images = [];
        }
        else{
            $product_images = explode(',',$product->image);
        }
        File::delete($product_images);
        $this->remove_zoomed($product_images);
        $product->delete();
        return redirect('/admin/products')->with('success','Product Deleted Successfully!!');

    }
    public function dropzone_destroy(Request $request)
    {
        $filename = $request->id;
        $image = Photo::where('original_name', $filename)->first();
        $product = Product::find( $request->product);
        $prod_images = $product->image;
        $prod_images_arr = explode(',',$prod_images);
        $key = array_search($image->photo, $prod_images_arr);
        if($key != false){
            unset($prod_images_arr[$key]);
        }
        $new_image_list = implode(',',$prod_images_arr);
        $product->image = $new_image_list;
        $product->save();
        File::delete($image->photo);
        $this->remove_zoomed($image->photo);
        $image->delete();
        $arr = ['message' => 'Image deleted Successfully', 'title' => 'Success', 'name' => $key];
        return response()->json($arr);
    }
    public function img_destroy(Request $request)
    {
        $image = Photo::where('photo', $request->name)->first();
        $product = Product::find( $request->product);
        $prod_images = $product->image;
        $prod_images_arr = explode(',',$prod_images);

        $key = array_search($image->photo, $prod_images_arr);

        if($key !== null){
            unset($prod_images_arr[$key]);
        }
        $new_image_list = implode(',',$prod_images_arr);

        $product->image = $new_image_list;
        $product->save();
        File::delete($image->photo);
        $this->remove_zoomed($image->photo);
        $image->delete();
        $arr = ['message' => 'Image deleted Successfully', 'title' => 'Success'];
        return redirect()->back()->with('success', 'Image Deleted');
    }

    public function img_pre(Request $request)
    {
        $image = Photo::where('original_name', $request->name)->first();
        File::delete($image->photo);
        $this->remove_zoomed($image->photo);
        $image->delete();
        $arr = ['message' => 'Image deleted Successfully', 'title' => 'Success', 'name' => $image->photo];
        return response()->json($arr);
    }

    protected function remove_zoomed($product_images){
        if(!is_array($product_images)){
            $product_images = array($product_images);
        }
        try{
            foreach($product_images as $image){
                File::delete('zoom/' . $image);
            }
        }
        catch(\Exception $e){
            return false;
        }
        return true;
    }
}
