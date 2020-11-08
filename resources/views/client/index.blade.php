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
    <div class="home-top-container">
        <div class="container">
            <div class="row" style="height: 800px;">
                <div class="col-lg-9">
                    <style>
                        .tech-slideshow {
                            transform: translate3d(0, 0, 0);
                        }
                        .tech-slideshow .m{
                            opacity: 1;
                            transition: opacity 5s linear;
                            background-position: 0 -200px;
                            animation: moveSlideshow 10s linear infinite;
                            background-position: 0 400px;
                            transition: opacity 5s linear;
                            animation: moveSlideshowBack 10s linear infinite;
                        }
                        @keyframes moveSlideshow {
                            100% {
                                transform: translateX(-70%);
                            }
                        }
                        @keyframes moveSlideshowBack {
                            30% {
                                transform: translateX(70%);
                            }
                        }
                    </style>
                    <div id="brand_ims" class="tech-slideshow col-lg-12 d-flex"
                        style="margin:1% 0%; overflow:hidden; white-space: nowrap;">
                        @if (count($brand_images)>0)
                        @foreach ($brand_images as $brand_image)
                        <div style="">
                            <div class="m text-center" style="height:50px; width:90px">
                                <a href="{{route('get_brands', ['brand' => $brand_image->id])}}">
                                    <img class="m1" style="margin-top:7px" height="30px" width="70px"
                                        src="{{ url('/zoom/brands')}}/{{$brand_image->photo}}"
                                        alt="{{$brand_image->photo}}">
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div style="margin:0% 1;">

                        </div>
                        @endif
                    </div><!-- End .home-slider -->
                    <div class="home-slider owl-carousel owl-carousel-lazy">
                        @if (count($sliders)>0)
                        @foreach ($sliders as $slider)
                        <div class="home-slide">
                            <div class="owl-lazy slide-bg" data-interval="5000"
                                data-src="{{url('/zoom/slides')}}/{{$slider->photo}}">
                            </div>
                        </div><!-- End .home-slide -->
                        @endforeach
                        @else
                        <div class="home-slide">
                            <div class="owl-lazy slide-bg"
                                data-src="{{ $default_slide }}">
                            </div>
                        </div>
                        <div class="home-slide">
                            <div class="owl-lazy slide-bg"
                                data-src="{{ $default_slide }}">
                            </div>
                        </div>
                        <div class="home-slide">
                            <div class="owl-lazy slide-bg"
                                data-src="{{ $default_slide }}">
                            </div>
                        </div>

                        <!-- End .home-slide -->
                        @endif

                    </div><!-- End .home-slider -->
                </div><!-- End .col-lg-9 -->



                <aside class="sidebar-shop col-lg-3 order-lg-first">
                    <div class="sidebar-wrapper">
                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-x" role="button" aria-expanded="false"
                                    aria-controls="widget-body-x" class="collapsed">CATEGORIES</a>
                            </h3>

                            <div class="collapse" id="widget-body-x">
                                <div class="side-custom-menu">
                                    <div class="side-menu-body">
                                        <ul>
                                            @foreach ($categories as $category)
                                            <li>
                                                <h6 class="">
                                                    <div class="d-flex">
                                                        <div class="w-100">
                                                            <a
                                                                href="{{route('get_category', ['category' => $category->id])}}">{{$category->title}}</a>
                                                        </div>

                                                        <h6 class="widget-title">
                                                            <a data-toggle="collapse"
                                                                href="#widget-body-{{$category->id}}" role="button"
                                                                aria-expanded="false" aria-controls="widget-body-y"
                                                                class="collapsed"></a>
                                                        </h6>

                                                    </div>
                                                </h6>
                                                <div class="collapse" id="widget-body-{{$category->id}}">
                                                    <ul>
                                                        @foreach ($subcategories as $subcategory)
                                                        @if ($subcategory->category_id == $category->id)

                                                        <li>
                                                            <a
                                                                href="{{route('get_subcategory', ['subcategory' => $subcategory->id])}}"><i
                                                                    class="fa fa-arrow-right"></i>{{$subcategory->title}}</a>
                                                        </li>

                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div><!-- End .collapse -->
                                            </li>
                                            @endforeach

                                        </ul>
                                    </div><!-- End .side-menu-body -->
                                </div><!-- End .side-custom-menu -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-y" role="button" aria-expanded="true"
                                    aria-controls="widget-body-y" class="collapsed">BRANDS</a>
                            </h3>

                            <div class="collapse" id="widget-body-y">
                                <div class="side-custom-menu">
                                    <div class="side-menu-body">
                                        <ul>
                                            @foreach ($brands as $brand)
                                            <li><a href="{{route('get_brands', ['brand' => $brand->id])}}"><i
                                                        class="fa fa-arrow-right"></i>{{$brand->title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div><!-- End .side-menu-body -->
                                </div><!-- End .side-custom-menu -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->

            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .home-top-container -->

    <div class="info-boxes-container">
        <div class="container">
            <div class="info-box">
                <i class="icon-shipping"></i>

                <div class="info-box-content">
                    <h4>FREE SHIPPING & RETURN</h4>
                    <p>Free shipping on all orders over $99.</p>
                </div><!-- End .info-box-content -->
            </div><!-- End .info-box -->

            <div class="info-box">
                <i class="icon-us-dollar"></i>

                <div class="info-box-content">
                    <h4>MONEY BACK GUARANTEE</h4>
                    <p>100% money back guarantee</p>
                </div><!-- End .info-box-content -->
            </div><!-- End .info-box -->

            <div class="info-box">
                <i class="icon-support"></i>

                <div class="info-box-content">
                    <h4>ONLINE SUPPORT 24/7</h4>
                    <p>Get help any time of the day.</p>
                </div><!-- End .info-box-content -->
            </div><!-- End .info-box -->
        </div><!-- End .container -->
    </div><!-- End .info-boxes-container -->


    <div class="featured-section">
        <div class="container">
            <h2 class="carousel-title">Recent Products</h2>

            <div class="featured-products owl-carousel owl-theme owl-dots-top">
                @foreach ($recents as $recent)
                <div class="product">

                    <figure class="product-image-container">
                        <a href="/show-product/{{$recent->id}}" class="product-image">
                            @if($recent->image == null)
                            <img src="{{ asset('no_img.png') }}" alt="{{ get_app_env('name') }} product">
                            @else
                            <img src="{{ asset(explode(',', $recent->image)[0]) }}" alt="{{ get_app_env('name') }} product">
                            @endif
                        </a>
                    </figure>
                    <div class="product-details">
                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:@if($recent->top == null)90%@else 100%@endif"></span>
                                <!-- End .ratings -->
                            </div><!-- End .product-ratings -->
                        </div><!-- End .product-container -->
                        <h2 class="product-title">
                            <a href="/show-product/{{$recent->id}}">{{$recent->title}}</a>
                        </h2>
                        <div class="price-box">
                            <span class="product-price">Ksh {{number_format($recent->price)}}</span>
                        </div><!-- End .price-box -->

                        <div class="product-action">
                            <a href="javascript:void(0)"
                                onclick="addProduct('recent-{{ $recent->id }}', {{ $recent->id }})"
                                class="paction add-cart" title="Add to Cart" id="recent-{{ $recent->id }}">
                                <span>Add to Cart</span>
                            </a>
                        </div><!-- End .product-action -->
                    </div><!-- End .product-details -->
                </div><!-- End .product -->
                @endforeach

            </div><!-- End .featured-proucts -->
        </div><!-- End .container -->
    </div><!-- End .recent -->
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
                                <span class="ratings" style="width:@if($top->top == null)90%@else 100%@endif"></span>
                                <!-- End .ratings -->
                            </div><!-- End .product-ratings -->
                        </div><!-- End .product-container -->
                        <h2 class="product-title">
                            <a href="/show-product/{{$top->id}}">{{$top->title}}</a>
                        </h2>
                        <div class="price-box">
                            <span class="product-price">Ksh {{number_format($top->price)}}</span>
                        </div><!-- End .price-box -->

                        <div class="product-action">
                            <a href="javascript:void(0)" onclick="addProduct('top-{{ $top->id }}', {{ $top->id }})"
                                class="paction add-cart" title="Add to Cart" id="top-{{ $top->id }}">
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
