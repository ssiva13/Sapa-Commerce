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
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            @include('client.layouts.dashboard_menu')
            <div class="col-12 mb-30">
                <div class="row mbn-15">
                    <div class="text-left text-md-right col-12 col-md-4 mb-15">
                        <p>Date: {{ date('l jS, M Y  h:i a', strtotime($invoice->created_at)) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
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
                            @foreach ($invoice->items as $item)
                            <tr class="product-row" id="cart-item1-{{ $item->id }}">
                                <td class="product-col">
                                    <h2 class="product-title">
                                        {{$item->title}}
                                    </h2>
                                </td>
                                <td>KES {{ number_format($item['price']) }}</td>
                                <td>
                                    {{$item->quantity}}
                                </td>
                                <td id="prod-total-{{ $item['id'] }}">KES
                                    {{ number_format($item['price'] * $item['quantity']) }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div><!-- End .cart-table-container -->
            </div><!-- End .col-lg-8 -->
            <div class="col-lg-3">
                <div class="cart-summary">
                    <b>{{$invoice->title}}</b><br>
                    {{$invoice->payment_method}} <br>
                    {{$invoice->total}}<br>
                    @if($invoice->paid == true) <span class="text-success">Paid</span>@else <span class="text-danger">Not
                        Paid</span> @endif<br>
                    @if($invoice->delivered == true) <span class="tip tip-new">Delivered</span>@else <span
                        class="tip tip-hot">Not Delivered</span> @endif<br>
                </div><!-- End .cart-summary -->
                <div class="checkout-info-box">
                    <h3 class="step-title">Ship To:
                    </h3>

                    <address>
                        {{ $invoice->order->user->name }} <br>
                        Kenya <br>
                        {{ $invoice->order->address }},
                        {{ $invoice->order->city }} <br>
                        {{ $invoice->order->email }} <br>
                        {{ $invoice->order->phone }}
                    </address>
                </div><!-- End .checkout-info-box -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
    <div class="mb-5"></div><!-- margin -->
</main><!-- End .main -->
@endsection
