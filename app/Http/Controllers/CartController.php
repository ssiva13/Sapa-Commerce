<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Product;

class CartController extends Controller
{
    public function add(Request $request){
        // Session::forget('cart');
        // Session::save();
        // dd(Session::get('cart'));
        $product = Product::find($request->id);
        $title = $product->title;
        $price = $product->price;
        $quantity = $request->quantity;
        if ($quantity <= 0 || $quantity > 100) {
            return null;
        }
        $set = $request->set;
        $image = asset(explode(',', $product->image)[0]);
        $cart = Session::get('cart');
        if(!$cart) {
            $previous_quantity = 0;
            $cart = [
                'product_parameters' => [
                    'total_quantity' => $quantity,
                    'total_amount' => $price * $quantity,
                ],
                'items' => [
                    $request->id => [
                        'id' => $request->id,
                        "title" => $title,
                        "quantity" => $quantity,
                        "price" => $price,
                        "image" => $image,
                    ],
                ],
            ];
            Session::put('cart', $cart);
            Session::save();
            $result = [
                'message' => 'Item added to cart', 
                'status' => true, 'title' => 'Success here!', 
                'total_amount' => $cart['product_parameters']['total_amount'], 
                'total_quantity' =>  $cart['product_parameters']['total_quantity'], 
                'item_title' => $cart['items'][$request->id]['title'], 
                'quantity' => $cart['items'][$request->id]['quantity'], 
                'price' => $cart['items'][$request->id]['price'], 
                'image' => $cart['items'][$request->id]['image'], 
                'previous_quantity' => $previous_quantity
            ];

            return response()->json($result);
        }
        $previous_quantity = $cart['product_parameters']['total_quantity'];
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart['items'][$request->id])) {
            if($set === 'true'){
                $prv_qty = $cart['items'][$request->id]['quantity'];
                $cart['items'][$request->id]['quantity'] = $quantity;
                $cart['product_parameters']['total_quantity'] = $cart['product_parameters']['total_quantity'] + $quantity - $prv_qty;
                $cart['product_parameters']['total_amount'] = $cart['product_parameters']['total_amount'] + $price * $quantity - $price * $prv_qty;
            }
            else{
                $cart['items'][$request->id]['quantity'] = $cart['items'][$request->id]['quantity'] + $quantity;
                $cart['product_parameters']['total_quantity'] = $cart['product_parameters']['total_quantity'] + $quantity;
                $cart['product_parameters']['total_amount'] = $cart['product_parameters']['total_amount'] + $price * $quantity;
            }
                
 
            session()->put('cart', $cart);

            Session::save();
            $result = [
                'message' => 'Item added to cart', 
                'status' => true, 'title' => 'Success here!', 
                'total_amount' => $cart['product_parameters']['total_amount'], 
                'total_quantity' =>  $cart['product_parameters']['total_quantity'], 
                'item_title' => $cart['items'][$request->id]['title'], 
                'quantity' => $cart['items'][$request->id]['quantity'], 
                'price' => $cart['items'][$request->id]['price'], 
                'image' => $cart['items'][$request->id]['image'], 
                'previous_quantity' => $previous_quantity,
                'set' => $set,
            ];

            return response()->json($result);
 
        }
        // if item not exist in cart then add to cart with quantity = $quantity
        $cart['items'][$request->id] = [
            'id' => $request->id,
            "title" => $title,
            "quantity" => $quantity,
            "price" => $price,
            "image" => $image,
        ];
        $cart['product_parameters']['total_quantity'] = $cart['product_parameters']['total_quantity'] + $quantity;
        $cart['product_parameters']['total_amount'] = $cart['product_parameters']['total_amount'] + $price * $quantity;
        session()->put('cart', $cart);
        Session::save();
        $result = [
            'message' => 'Item added to cart', 
            'status' => true, 
            'title' => 'Success here!', 
            'total_amount' => $cart['product_parameters']['total_amount'], 
            'total_quantity' =>  $cart['product_parameters']['total_quantity'], 
            'item_title' => $cart['items'][$request->id]['title'], 
            'quantity' => $cart['items'][$request->id]['quantity'], 
            'price' => $cart['items'][$request->id]['price'], 
            'image' => $cart['items'][$request->id]['image'], 
            'previous_quantity' => $previous_quantity];

        return response()->json($result);
    }

    public function remove_product(Request $request)
    {
        $cart = Session::get('cart');
        $previous_quantity = $cart['product_parameters']['total_quantity'];
        $item = $cart['items'][$request->id];
        unset($cart['items'][$request->id]);
        $cart['product_parameters']['total_quantity'] = $cart['product_parameters']['total_quantity'] - $item['quantity'];
        $cart['product_parameters']['total_amount'] = $cart['product_parameters']['total_amount'] - $item['quantity'] * $item['price'];
        session()->put('cart', $cart);
        Session::save();
        $result = [
            'message' => 'Item removed from cart', 
            'status' => true, 'title' => 'Success here!', 
            'total_amount' => $cart['product_parameters']['total_amount'], 
            'total_quantity' =>  $cart['product_parameters']['total_quantity'], 
            'previous_quantity' => $previous_quantity
        ];

        return response()->json($result);
    }
    public function empty_cart()
    {
        Session::forget('cart');
        Session::save();

        return redirect()->back()->with('success', 'Cart emptied successfully');
    }
}
