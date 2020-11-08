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
            <li class="breadcrumb-item"><a href="{{route('get_category', ['category' => $product->category->id])}}">{{$product->category->title}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->brand->title}}</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 product-single-gallery">
                            <div class="product-slider-container product-item">
                                <div class="product-single-carousel owl-carousel owl-theme">
                                    @foreach ($images as $image)
                                    <div class="product-item">
                                        <img class="product-single-image" src="{{asset($image)}}"
                                            data-zoom-image="{{asset('zoom/' . $image)}}" />
                                    </div>
                                    @endforeach
                                </div>
                                <!-- End .product-single-carousel -->
                                <span class="prod-full-screen">
                                    <i class="icon-plus"></i>
                                </span>
                            </div>
                            <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                @foreach ($images as $image)
                                <div class="col-3 owl-dot">
                                    <img src="{{asset($image)}}" />
                                </div>
                                @endforeach
                            </div>
                        </div><!-- End .col-lg-7 -->

                        <div class="col-lg-5 col-md-6">
                            <div class="product-single-details">
                                <h1 class="product-title">{{$product->title}}</h1>

                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings"
                                            style="width:@if($product->top == null)90%@else 100%@endif"></span>
                                        <!-- End .ratings -->
                                        @if($product->top != null) TOP @else @endif
                                    </div><!-- End .product-ratings -->
                                </div><!-- End .product-container -->

                                <div class="price-box">
                                    <span class="product-price">Ksh {{number_format($product->price)}}</span>
                                </div><!-- End .price-box -->

                                <div class="product-desc">
                                </div><!-- End .product-desc -->

                                <div class="product-filters-container">
                                    <div class="product-single-filter">
                                        <h3>Brand:&nbsp;</h3>
                                        <h4><b> {{$product->brand->title}}</b></h4>
                                    </div><!-- End .product-single-filter -->
                                </div><!-- End .product-filters-container -->

                                <div class="product-filters-container">
                                    <div class="product-single-filter">
                                        <h3>Category:&nbsp;</h3>
                                        <h4><b> {{$product->category->title}}</b></h4>
                                    </div><!-- End .product-single-filter -->
                                </div><!-- End .product-filters-container -->

                                <div class="product-action product-all-icons">
                                    <div class="product-single-qty">
                                        @if (Session::has('cart') && array_key_exists('items', Session::get('cart')))
                                            @if (Session::has('cart') && array_key_exists($product->id, Session::get('cart')['items']))
                                                <input class="horizontal-quantity form-control" type="text"
                                                id="horizontal_quantity" value="{{ Session::get('cart')['items'][$product->id]['quantity'] }}">
                                            @else
                                                <input class="horizontal-quantity form-control" type="text" id="horizontal_quantity" value="0">
                                            @endif
                                        @else
                                            <input class="horizontal-quantity form-control" type="text" id="horizontal_quantity" value="0">
                                        @endif
                                    </div><!-- End .product-single-qty -->

                                    <a href="javascript:void(0)"
                                        onclick="var horizontal_quantity = $('#horizontal_quantity').val();
                                        addProduct('product-{{ $product->id }}', {{ $product->id }}, horizontal_quantity, 'true')"
                                        class="paction add-cart" title="Add to Cart" id="product-{{ $product->id }}">
                                        <span>Add to Cart</span>
                                    </a>
                                </div><!-- End .product-action -->
                            </div><!-- End .product-single-details -->
                        </div><!-- End .col-lg-5 -->
                    </div><!-- End .row -->
                </div><!-- End .product-single-container -->

                <div class="product-single-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab"
                                href="#product-desc-content" role="tab" aria-controls="product-desc-content"
                                aria-selected="true">Description</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                            aria-labelledby="product-tab-desc">
                            <div class="product-desc-content">
                                <p>{!!$product->description!!}</p>
                            </div><!-- End .product-desc-content -->
                        </div><!-- End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .product-single-tabs -->
            </div><!-- End .col-lg-9 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
    <div class="featured-section">
        <div class="container">
            <h2 class="carousel-title">Featured Products</h2>

            <div class="featured-products owl-carousel owl-theme owl-dots-top">
                @foreach ($featureds as $featured)
                <div class="product">
                    <figure class="product-image-container">
                        <a href="/show-product/{{$featured->id}}" class="product-image">
                            @if($featured->image == null)
                            <img src="{{ asset('no_img.png') }}" alt="{{ get_app_env('name') }} product">
                            @else
                            <img src="{{ asset(explode(',', $featured->image)[0]) }}" alt="{{ get_app_env('name') }} product">
                            @endif
                        </a>
                    </figure>
                    <div class="product-details">
                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                            </div><!-- End .product-ratings -->
                        </div><!-- End .product-container -->
                        <h2 class="product-title">
                            <a href="/show-product/{{$featured->id}}">{{$featured->title}}</a>
                        </h2>
                        <div class="price-box">
                            <span class="product-price">Ksh {{number_format($featured->price)}}</span>
                        </div><!-- End .price-box -->

                        <div class="product-action">
                            <a href="javascript:void(0)"
                                onclick="addProduct('featured-{{ $featured->id }}', {{ $featured->id }})"
                                class="paction add-cart" title="Add to Cart" id="featured-{{ $featured->id }}">
                                <span>Add to Cart</span>
                            </a>
                        </div><!-- End .product-action -->
                    </div><!-- End .product-details -->
                </div><!-- End .product -->
                @endforeach
            </div><!-- End .featured-proucts -->
        </div><!-- End .container -->
    </div><!-- End .featured-section -->
</main>

@endsection
