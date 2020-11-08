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
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <style>
        #particles {
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            position: absolute;
            z-index: -2;
        }

    </style>
    <div id="particles"><canvas class="pg-canvas" width="878" height="638"></canvas></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Create a New Account Here</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group required-field">
                                <label>Full Name </label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div><!-- End .form-group -->
                            <div class="form-group required-field">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div><!-- End .form-group -->
                            <div class="form-group required-field">
                                <label>Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div><!-- End .form-group -->
                    </li>
                </ul>
            </div><!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Summary</h3>

                    <h4>
                        @if (Session::has('cart'))
                        <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button"
                            aria-expanded="false" aria-controls="order-cart-section"
                            id="sammary-quantity">{{ Session::get('cart')['product_parameters']['total_quantity'] }}
                            Products in Cart</a>
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
                                                <a
                                                    href="{{ route('show_product', $item['id']) }}">{{ $item['title'] }}</a>
                                            </h2>

                                            <span class="product-qty">Qty: {{ $item['quantity'] }}</span>
                                        </div>
                                    </td>
                                    <td class="price-col">KES {{ number_format($item['price'] * $item['quantity']) }}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <p class="text-center">Your cart is empty.</p>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><b>Order Total</b></td>
                                    <td id="total-amount2"><b>KES
                                            {{ isset(Session::get('cart')['product_parameters']['total_amount']) ? number_format(Session::get('cart')['product_parameters']['total_amount']) : number_format(0) }}</b>
                                    </td>
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
                    <button style="background:#123560;" type="submit" class="btn btn-primary float-right">Sign
                        Up</button>
                    </form>
                </div><!-- End .checkout-steps-action -->
            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- margin -->
</main><!-- End .main -->
@endsection
