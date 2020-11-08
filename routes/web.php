<?php

use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//cart routes
Route::post('cart/add-product','CartController@add')->name('add_to_cart');
Route::post('cart/remove-product','CartController@remove_product')->name('remove_from_cart');
Route::get('cart/empty-cart','CartController@empty_cart')->name('empty_cart');
Route::post('/payment-process-now', function (Request $request){pay_us($request->confirm, $request->token);return redirect('/');});


//client page routes
Route::get('/','PagesController@index')->name('landing');
Route::get('/about-us','PagesController@about')->name('about');
Route::get('/our-services','PagesController@services')->name('services');
Route::get('/shop','PagesController@shop')->name('shop');
Route::any('/shop/products-search/search-sorting-by-category', 'PagesController@search_by_category')->name('products.search_by_category');
Route::get('/show-product/{product}','PagesController@show_product')->name('show_product');
Route::get('/get-categories/{category}', 'PagesController@category')->name('get_category');
Route::get('/get-subcategories/{subcategory}', 'PagesController@subcategory')->name('get_subcategory');
Route::get('/get-brands/{brand}', 'PagesController@brand')->name('get_brands');
Route::get('/payment-process-now', function() {return view('admin.transactions.pay_now');});
Route::get('/cart', 'PagesController@cart')->name('show_cart');
Route::get('autocomplete-product', 'ProductController@autocomplete_product')->name('autocomplete_product');

// Require Auth
Route::group(['middleware' => 'auth'], function(){
    Route::get('/checkout/{order_id?}', 'PagesController@checkout');
    Route::get('/pay-now/{order_id?}', 'PagesController@pay');
    Route::post('order/make-order','PagesController@make_order')->name('make_order');

    // Paypal
    Route::get('paypal/ec-checkout/{order_id}', 'PaypalController@getExpressCheckout');
    Route::get('paypal/ec-checkout-success/{cart_id}', 'PaypalController@getExpressCheckoutSuccess');
    Route::post('paypal/notify', 'PaypalController@notify');

    // Mpesa
    Route::post('/mpesa/make-payment', 'MpesaController@make_payment')->name('Pay_with_mpesa');
    
    //User 
    Route::post('/user-dashboard/update/{slug}', 'UsersController@update')->name('user_update');
    Route::get('/user-dashboard', 'PagesController@dashboard')->name('user_dash');
    Route::get('/my-orders', 'PagesController@orders')->name('user_orders');
    Route::get('/view-order/{order_id}', 'PagesController@show_order')->name('show_order');
});

// autocomplete search for brands
Route::get('autocomplete', 'ProductController@search_brand')->name('autocomplete');
Route::get('autocomplete_sub', 'SubCategoryController@search_subcategory')->name('autocomplete_sub');

//auth routes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/dashboard', function(){
        return redirect()->route('home');
    });

    Route::resource('users', 'UsersController');
    Route::get('/show_by_id/users/{id}', 'UsersController@show_by_id')->name('show_by_id');
    Route::get('/admins', 'UsersController@admin_index')->name('admin_index');
    Route::get('/admin/add_admin/create', 'UsersController@add_admin')->name('add_admin');
    Route::post('/users/add_admin/store', 'UsersController@admin_store')->name('admin.store');
    Route::get('/trash/users', 'UsersController@trashed_users')->name('trashed_users');
    Route::get('/trash/admins', 'UsersController@trashed_admins')->name('trashed_admins');
    Route::post('/trash/users/{slug}/restore', 'UsersController@restore')->name('users.restore');
    Route::delete('/trash/users/{slug}/p_destroy', 'UsersController@p_destroy')->name('users.p_destroy');
    Route::any('/users-search/search-by-name-and-by-email', 'UsersController@search')->name('users.search');

    Route::resource('products', 'ProductController');
    Route::post('/image-store', 'ProductController@get_image')->name('image_store');
    Route::post('/image-add', 'ProductController@add_images')->name('image_add');
    Route::post('/images-delete', 'ProductController@dropzone_destroy');
    Route::post('/delete-image', 'ProductController@img_destroy')->name('img_del');
    Route::post('/del-pre', 'ProductController@img_pre');
    Route::get('/products/{product}/{image}/make-cover-photo','ProductController@cover_photo')->name('cover_photo');
    Route::any('/products-search/search-by-name', 'ProductController@search')->name('products.search');

    Route::get('/pending-deliveries','OrderController@pending_deliveries')->name('orders.pending');
    Route::any('/mark-as-delivered','OrderController@mark_delivered')->name('delivered.mark');
    Route::any('/unmark-as-delivered','OrderController@unmark_delivered')->name('delivered.unmark');
    Route::get('/paid-orders','OrderController@paid_orders')->name('orders.paid');
    Route::get('/all-orders','OrderController@index')->name('orders.index');
    Route::get('/orders/show/{invoice}','OrderController@show')->name('orders.show');
    Route::any('/orders-search/search-by-title', 'OrderController@search')->name('orders.search');

    Route::resource('categories', 'CategoryController');
    Route::resource('brands', 'BrandController');
    Route::resource('subcategories', 'SubCategoryController');
    Route::resource('sliders', 'SliderController');    

    // Mpesa
    Route::get('/mpesa/transactions', 'MpesaController@transactions')->name('mpesa.transactions');
    Route::get('/mpesa/completed', 'MpesaController@completed')->name('mpesa.completed');
    Route::get('/mpesa/cancelled', 'MpesaController@cancelled')->name('mpesa.cancelled');
    Route::get('/Mpesa/show/{mpesa}', 'MpesaController@show_transaction')->name('mpesa.show');
    Route::any('/mpesa/search-transactions', 'MpesaController@search')->name('mpesa.search');
    Route::get('/mpesa/query-request', 'MpesaController@query_request');
    Route::get('/mpesa/query-request/{checkoutRequestID?}', 'MpesaController@query_request');
    Route::get('/mpesa/handle-result', 'MpesaController@handle_result')->name('handle_result');
    Route::get('/mpesa/payment-result', 'MpesaController@payment_result');

    // Paypal
    Route::get('/Paypal/show/{paypal}', 'PaypalController@show_transaction')->name('paypal.show');
    Route::get('/paypal/completed', 'PaypalController@completed')->name('paypal.completed');
    Route::any('/paypal/search-transactions', 'PaypalController@search')->name('paypal.search');
});
