<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->is_admin){
            $users = \App\User::where('type', 'user')->count();
            $admins = \App\User::where('is_admin', true)->where('view', true)->count();
            $products = \App\Product::all()->count();
            $paid_orders = \App\Invoice::where('paid', true)->count();
            $pending_deliveries = \App\Invoice::where('paid', true)->where('delivered', null)->orWhere('delivered', false)->count();
            return view('admin.dashboard')->with('admins', $admins)
                                          ->with('users', $users)
                                          ->with('paid_orders', $paid_orders)
                                          ->with('products', $products)
                                          ->with('pending_deliveries', $pending_deliveries);
        }
        return redirect('/user-dashboard');
    }
}
