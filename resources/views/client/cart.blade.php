@extends('client.layouts.app')
@section('metadata')
<meta name="description" content = "{{ get_app_env('name') }}">
<meta name="description" content = "{{ get_app_env('description') }}">
<meta name="author" content = "{{ get_app_env('author') }}">
@endsection
@section('title')
<title>{{ get_app_env('name') }}</title>
@endsection
@section('content')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table-container">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th class="product-col">Product</th>
                                <th class="price-col">Price</th>
                                <th class="qty-col">Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Session::has('cart'))
                                @foreach (Session::get('cart')['items'] as $item)
                                    <tr class="product-row" id="cart-item1-{{ $item['id'] }}">
                                        <td class="product-col">
                                            <figure class="product-image-container">
                                                <a href="{{ route('show_product', $item['id']) }}" class="product-image">
                                                    <img src="{{ $item['image'] }}" alt="product">
                                                </a>
                                            </figure>
                                            <h2 class="product-title">
                                                <a href="{{ route('show_product', ['id' => $item['id']]) }}">{{ $item['title'] }}</a>
                                            </h2>
                                        </td>
                                        <td>KES {{ number_format($item['price']) }}</td>
                                        <td>
                                            <a href="javascript:void(0)" id="fake-button-{{ $item['id'] }}" style="display:none"></a>
                                            <input class="vertical-quantity form-control" type="text" value="{{ $item['quantity'] }}" id="vertical-quantity-{{ $item['id'] }}" onchange="var horizontal_quantity = $('#vertical-quantity-{{ $item['id'] }}').val();
                                            addProduct('fake-button-{{ $item['id'] }}', {{$item['id']}}, horizontal_quantity, 'true')">
                                        </td>
                                        <td  id="prod-total-{{ $item['id'] }}">KES {{ number_format($item['price'] * $item['quantity']) }}</td>
                                    </tr>
                                    <tr class="product-action-row" id="cart-item2-{{ $item['id'] }}">
                                        <td colspan="4" class="clearfix">
                                            {{-- <div class="float-left">
                                                <a href="#" class="btn-move">Move to Wishlist</a>
                                            </div><!-- End .float-left --> --}}

                                            <div class="float-right">
                                                {{-- <a href="#" title="Edit product" class="btn-edit"><span
                                                        class="sr-only">Edit</span><i class="icon-pencil"></i></a> --}}
                                                <a href="javascript:void(0)" title="Remove product" class="btn-remove" onclick="removeProduct({{ $item['id'] }})"><span
                                                        class="sr-only">Remove</span></a>
                                            </div><!-- End .float-right -->
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">Your cart is empty.</p>
                            @endif

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="clearfix">
                                    <div class="float-left">
                                        <a href="/shop" class="btn btn-outline-secondary">Continue Shopping</a>
                                    </div><!-- End .float-left -->
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- End .cart-table-container -->
            </div><!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3>Summary</h3>
                    <table class="table table-totals">
                        @if(Session::has('cart'))
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td id="total-amount1">KES {{ number_format(Session::get('cart')['product_parameters']['total_amount']) }}</td>
                                </tr>

                                <tr>
                                    <td>Tax</td>
                                    <td>KES 0.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Order Total</td>
                                    <td id="total-amount2">KES {{ number_format(Session::get('cart')['product_parameters']['total_amount']) }}</td>
                                </tr>
                            </tfoot>
                        @else
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td id="total-amount1">KES 0.00</td>
                            </tr>

                            <tr>
                                <td>Tax</td>
                                <td>KES 0.00</td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Order Total</td>
                                    <td id="total-amount2">KES 0.00</td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>

                    <div class="checkout-methods">
                        <a href="/checkout" class="btn btn-block btn-sm btn-primary">Go to Checkout</a>
                    </div><!-- End .checkout-methods -->
                </div><!-- End .cart-summary -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- margin -->
</main><!-- End .main -->
@endsection
