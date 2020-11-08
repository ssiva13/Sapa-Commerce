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
            <li>
                <span>Shipping</span>
            </li>
            <li class="active">
                <span>Review &amp; Payments</span>
            </li>
        </ul>
        <div class="row">
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

                <div class="checkout-info-box">
                    <h3 class="step-title">Ship To:
                        <a href="/checkout/{{ $order->id }}" title="Edit" class="step-title-edit"><span class="sr-only">Edit</span><i
                                class="icon-pencil"></i></a>
                    </h3>

                    <address>
                        {{ $order->user->name }} <br>
                        {{ $order->address }},
                        {{ $order->city }} <br>
                        {{ $order->email }} <br>
                        {{ $order->phone }}
                    </address>
                </div><!-- End .checkout-info-box -->

                <div class="checkout-info-box">
                    <h3 class="step-title">Shipping Method:
                        {{-- <a href="#" title="Edit" class="step-title-edit"><span class="sr-only">Edit</span><i
                                class="icon-pencil"></i></a> --}}
                    </h3>

                    <p>Flat Rate - Fixed</p>
                </div><!-- End .checkout-info-box -->
            </div><!-- End .col-lg-4 -->

            <div class="col-lg-8 order-lg-first">
                <div class="checkout-payment">
                    <h2 class="step-title">Select Payment Method:</h2>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('Pay_with_mpesa') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLongTitle">Enter Phone Number</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Enter an <b>MPESA</b> enabled number to process the payment of Ksh 12,500.00
                                        </h4>
                                        <div class="input-group flex-nowrap">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="addon-wrapping">+254</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="7XX XXX XXX"
                                                aria-label="Phone" aria-describedby="addon-wrapping" name="phone" maxlength="10" minlength="9" required>
                                            <input type="text" name="order_id" value="{{ $order->id }}"  style="display:none">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Make Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <a data-toggle="modal" data-target="#exampleModalLong"> <img src="{{asset('mpesa.png')}}" alt=""></a>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <a class="checkout-link" href="/paypal/ec-checkout/{{ $order->id }}" onclick="$('#paypal-submit').click()"><img src="{{asset('pp.png')}}" alt=""></a>
                            <form action="/paypal/ec-checkout" method="post" style="display:none">
                                @csrf
                                <input type="text" name="order_id" value="{{ $order->id }}">
                                <button type="submit" id="paypal-submit">text</button>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="clearfix">
                        <a href="#" class="btn btn-primary float-right">Place Order</a>
                    </div><!-- End .clearfix --> --}}
                </div><!-- End .checkout-payment -->

            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-6"></div><!-- margin -->
</main><!-- End .main -->
@endsection
