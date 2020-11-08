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
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <ul class="checkout-progress-bar">
            <li class="active">
                <span>Shipping</span>
            </li>
            <li>
                <span>Review &amp; Payments</span>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-8">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Shipping Details</h2>
                        <form action="{{ route('make_order') }}" id="checkout_form" method="POST">
                            @csrf
                            <div class="form-group required-field">
                                <label>Full Name </label>
                                <input name='name' type="text" class="form-control" value="{{ Auth::user()->name }}" required disabled>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Phone Number</label>
                                <input name='phone' type="text" class="form-control" value="{{ isset($order)? $order->phone: Auth::user()->phone }}" required>
                            </div><!-- End .form-group -->
                            <div class="form-group required-field">
                                <label>Email</label>
                                <input name='email' type="email" class="form-control" value="{{ isset($order)? $order->email: Auth::user()->email }}" required>
                            </div><!-- End .form-group -->
                            <div class="form-group required-field">
                                <label>City</label>
                                <input name='city' type="text" class="form-control" value="{{ isset($order)? $order->city: '' }}" required>
                            </div><!-- End .form-group -->
                            <div class="form-group required-field">
                                <label>Address</label>
                                <input name='address' type="text" class="form-control" value="{{ isset($order)? $order->address: '' }}" required>
                            </div><!-- End .form-group -->
                            <button type="submit" style="display:none" id="checkout_submit"></button>
                        </form>
                    </li>
                </ul>
            </div><!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Summary</h3>

                    <h4>
                        @if (Session::has('cart'))
                            <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button"
                            aria-expanded="false" aria-controls="order-cart-section" id="sammary-quantity">{{ Session::get('cart')['product_parameters']['total_quantity'] }} Product{{ Session::get('cart')['product_parameters']['total_quantity'] > 1?'s':'' }} in Cart</a>
                        @else
                            <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button"
                            aria-expanded="false" aria-controls="order-cart-section">No Products in Cart</a>
                        @endif
                    </h4>

                    <div class="collapse" id="order-cart-section">
                        <table class="table table-mini-cart">
                            <tbody>
                                @if(Session::has('cart'))
                                    @foreach (Session::get('cart')['items'] as $item)
                                        <tr id="summary-item-{{ $item['id'] }}">
                                            <td class="product-col">
                                                <figure class="product-image-container">
                                                    <a href="{{ route('show_product', $item['id']) }}" class="product-image">
                                                        <img src="{{ $item['image'] }}" alt="product">
                                                    </a>
                                                </figure>
                                                <div>
                                                    <h2 class="product-title">
                                                        <a href="{{ route('show_product', $item['id']) }}">{{ $item['title'] }}</a>
                                                    </h2>

                                                    <span class="product-qty">Qty: {{ $item['quantity'] }}</span>
                                                </div>
                                            </td>
                                            <td class="price-col">KES {{ number_format($item['price'] * $item['quantity']) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p class="text-center">Your cart is empty.</p>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><b>Order Total</b></td>
                                    <td id="total-amount2"><b>KES {{ number_format(Session::get('cart')['product_parameters']['total_amount']) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- End #order-cart-section -->
                </div><!-- End .order-summary -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->

        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-steps-action">
                    <a href="javascript:void(0)" class="btn btn-primary float-right" onclick="$('#checkout_submit').click()">NEXT</a>
                </div><!-- End .checkout-steps-action -->
            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- margin -->
</main><!-- End .main -->
@endsection
