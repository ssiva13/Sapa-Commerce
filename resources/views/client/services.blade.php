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
    <div class="page-header page-header-bg" style="background-image: url('client/assets/images/banner-top.jpg');">
        <div class="container">
            <h1><span>OUR</span>
                SERVICES</h1>
            <a href="/shop" class="btn btn-dark">Visit Shop</a>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    {{-- <div class="about-section">
        <div class="container">
            <h2 class="subtitle">WE OFFER THE FOLLOWING SERVICES</h2>
            <h4>Service One</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

            <h4>Service Two</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

        </div><!-- End .container -->
    </div><!-- End .about-section --> --}}

    <div class="features-section">
        <div class="container">
            <h2 class="subtitle">WE OFFER THE FOLLOWING SERVICES</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="feature-box">
                        <i class="fa fa-money"></i>

                        <div class="feature-box-content">
                            <h3>Service One</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industr in some form.</p>
                        </div><!-- End .feature-box-content -->
                    </div><!-- End .feature-box -->
                </div><!-- End .col-lg-4 -->

                <div class="col-lg-4">
                    <div class="feature-box">
                        <i class="icon-us-dollar"></i>

                        <div class="feature-box-content">
                            <h3>Service Two</h3>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                        </div><!-- End .feature-box-content -->
                    </div><!-- End .feature-box -->
                </div><!-- End .col-lg-4 -->

                <div class="col-lg-4">
                    <div class="feature-box">
                        <i class="fa fa-home"></i>

                        <div class="feature-box-content">
                            <h3>Service Three</h3>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                        </div><!-- End .feature-box-content -->
                    </div><!-- End .feature-box -->
                </div><!-- End .col-lg-4 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .features-section -->

    <div class="featured-section">
        <div class="container">
            <h2 class="carousel-title">Top Products</h2>

            <div class="featured-products owl-carousel owl-theme owl-dots-top">
                @foreach ($tops as $top)
                <div class="product">
                    <figure class="product-image-container">
                        <a href="/show-product/{{$top->id}}" class="product-image">
                            @if($top->image == null)
                            <img src="{{ asset('no_img.png') }}" alt="{{ get_app_env('name') }} product">
                            @else
                            <img src="{{ asset(explode(',', $top->image)[0]) }}" alt="{{ get_app_env('name') }} product">
                            @endif
                        </a>
                    </figure>
                    <div class="product-details">
                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:@if($top->top == null)90%@else 100%@endif"></span><!-- End .ratings -->
                            </div><!-- End .product-ratings -->
                        </div><!-- End .product-container -->
                        <h2 class="product-title">
                            <a href="/show-product/{{$top->id}}">{{$top->title}}</a>
                        </h2>
                        <div class="price-box">
                            <span class="product-price">Ksh {{number_format($top->price)}}</span>
                        </div><!-- End .price-box -->

                        <div class="product-action">
                            <a href="javascript:void(0)" onclick="addProduct('top-{{ $top->id }}', {{ $top->id }})" class="paction add-cart" title="Add to Cart" id="top-{{ $top->id }}">
                                <span>Add to Cart</span>
                            </a>
                        </div><!-- End .product-action -->
                    </div><!-- End .product-details -->
                </div><!-- End .product -->
                @endforeach
            </div><!-- End .featured-proucts -->
        </div><!-- End .container -->
    </div><!-- End .top -->
</main><!-- End .main -->
@endsection
