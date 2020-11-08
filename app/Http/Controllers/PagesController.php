<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use Session;
use App\Category;
use App\Slider;
use App\SubCategory;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Invoice;
use App\User;

class PagesController extends Controller
{
    public function index()
    {
        check_cart();
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $subcategories = SubCategory::orderBy('created_at', 'DESC')->get();
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        $tops = Product::where('top', 'on')->orderBy('created_at', 'DESC')->take(10)->get();
        $sliders = Slider::where('active', 'active')->orderBy('created_at', 'DESC')->take(6)->get();
        $brand_images = Brand::whereNotNull('photo')->where('active', 'active')->orderBy('created_at', 'DESC')->take(10)->get();
        $recents = Product::orderBy('created_at', 'DESC')->take(10)->get();
        $default_slide = asset('/brand_banner.png');
        if(count($sliders) < 0){
            $default_slide = '';
        }

        return view('client.index')->with('recents', $recents)->with('tops', $tops)->with('categories', $categories)->with('default_slide', $default_slide)
            ->with('subcategories', $subcategories)->with('brands', $brands)->with('sliders', $sliders)->with('brand_images',$brand_images);

    }
    public function about()
    {
        return view('client.about');
    }
    public function dashboard()
    {
        $user = Auth::user();
        return view('client.dashboard')->with('user', $user);
    }
    public function orders()
    {
        $user = Auth::user();
        $orders = Invoice::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return view('client.orders')->with('orders', $orders);
    }
    public function services()
    {
        $tops = Product::where('top', 'on')->orderBy('created_at', 'DESC')->take(10)->get();
        return view('client.services')->with('tops', $tops);
    }
    public function show_order($order_id)
    {
        $invoice = Invoice::find($order_id);
        return view('client.show_order')->with('invoice', $invoice);
    }

    public function shop()
    {
        check_cart();
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $subcategories = SubCategory::orderBy('created_at', 'DESC')->get();
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        $products = Product::orderBy('created_at', 'DESC')->paginate(18);

        return view('client.shop')->with('products', $products)->with('categories', $categories)->with('subcategories', $subcategories)->with('brands', $brands);
    }
    public function search_by_category(Request $request)
    {
        check_cart();
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $subcategories = SubCategory::orderBy('created_at', 'DESC')->get();
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        $message = $request->my_query;
        $category_id = $request->category_id;
        if ($category_id) {
            $products = Product::where('category_id', $category_id)->search($request->my_query, null, true)->paginate(18)->setPath('');
            $cat = Category::find($category_id)->title;
        } else {
            $products = Product::search($request->my_query, null, true)->paginate(18)->setPath('');
            $cat = 'All Categories';
        }
        $pagination = $products->appends($request->all());
        return view('client.shop')->with('products', $products)
            ->with('categories', $categories)
	    ->with('subcategories', $subcategories)
            ->with('brands', $brands)
            ->with('message', $message)
            ->with('cat', $cat)
            ->withQuery($request->all());
    }
    public function show_product(Product $product)
    {
        check_cart();
        $featureds = Product::where('category_id', $product->category->id)->inRandomOrder()->take(10)->get();
        if ($product->image == null) {
            $images = [];
        } else {
            $images = explode(',', $product->image);
        }
        return view('client.show_product')->with('product', $product)->with('images', $images)->with('featureds', $featureds);
    }

    public function category(Category $category)
    {
        $cats = Category::orderBy('created_at', 'DESC')->get();
        $subcats = SubCategory::orderBy('created_at', 'DESC')->get();
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        $products = Product::where('category_id', $category->id)->paginate(18);
        return view('client.categories')->with('products', $products)->with('category', $category)->with('brands', $brands)->with('cats', $cats)->with('subcats', $subcats);
    }
    public function subcategory(SubCategory $subcategory)
    {
        $subcats = SubCategory::orderBy('created_at', 'DESC')->get();
        $cats = Category::orderBy('created_at', 'DESC')->get();
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        $products = Product::where('category_id', $subcategory->id)->paginate(18);
        return view('client.subcategories')->with('products', $products)->with('subcategory', $subcategory)->with('brands', $brands)->with('cats', $cats)->with('subcats', $subcats);
    }
    public function brand(Brand $brand)
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $subcats = SubCategory::orderBy('created_at', 'DESC')->get();
        $all_brands = Brand::orderBy('created_at', 'DESC')->get();
        $products = Product::where('brand_id', $brand->id)->paginate(18);
        return view('client.brands')->with('products', $products)->with('brand', $brand)->with('all_brands', $all_brands)->with('categories', $categories)->with('subcats', $subcats);
    }
    public function checkout(Request $request)
    {
        if (!check_cart())
            return redirect('/')->with('error', 'Your cart is empty.');
        if ($request->order_id) {
            $order = Order::find($request->order_id);
            if ($order->user_id == Auth::user()->id) {
                return view('client.checkout')->with('order', $order);
            }
            return view('client.checkout');
        }
        return view('client.checkout');
    }
    public function make_order(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);
        $order = Order::create([
            'user_id' => \Auth::user()->id,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
        ]);
        return redirect('/pay-now/' . $order->id);
    }
    public function pay(Request $request)
    {
        try {
            if (!check_cart())
                return redirect('/')->with('error', 'Your cart is empty.');
            if ($request->order_id) {
                $order = Order::find($request->order_id);
                if ($order->user_id == Auth::user()->id) {
                    return view('client.pay')->with('order', $order);
                }
                return view('client.checkout')->with('order', $order)->with('info', 'Unauthorized access to this order.');
            }
            return redirect('/checkout')->with('info', 'Fill the checkout form.');
        } catch (\Exception $e) {
            return redirect('/checkout')->with('info', 'Fill the checkout form.');
        }
    }
    public function cart()
    {
        check_cart();
        return view('client.cart');
    }
}
