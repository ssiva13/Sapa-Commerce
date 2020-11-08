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
            <div class="col-lg-9 order-lg-last dashboard-content">
                <h2>My Orders</h2>

                <div class="alert alert-success alert-intro" role="alert">
                    Track all your orders from this page.
                </div><!-- End .alert -->

                <div class="mb-4"></div><!-- margin -->

                @if(count($orders) == 0) <p style="text-align:center">You haven't made any order yet</p>
                @else<h3>My Orders</h3>
                <div class="row">
                    @foreach ($orders as $order)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                    {{$order->title}}
                            </div><!-- End .card-header -->

                            <div class="card-body">
                                <p>
                                    <b>Date:</b> {{ date('l jS, M Y  h:i a', strtotime($order->created_at)) }}<br>
                                    <b>Ksh {{number_format($order->total)}}</b><br>
                                    @if($order->paid == true) <span class="text-success">Paid</span>@else <span class="text-danger">Not Paid</span> @endif<br>
                                    @if($order->delivered == true) <span class="tip tip-new">Delivered</span>@else <span class="tip tip-hot pull-right">Not Delivered</span> @endif<br>
                                <a href="/view-order/{{$order->id}}">View more</a>
                                </p>
                            </div><!-- End .card-body -->
                        </div><!-- End .card -->
                    </div><!-- End .col-md-6 -->
                    @endforeach
                </div><!-- End .row -->
                @endif
            </div><!-- End .col-lg-9 -->

            @include('client.layouts.dashboard_menu')
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- margin -->
</main><!-- End .main -->
@endsection
