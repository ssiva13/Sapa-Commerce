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
                <li class="breadcrumb-item"><a href="/">{{ get_app_env('name') }}"</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <aside class="sidebar-shop col-lg-3 order-lg-first">
                <div class="sidebar-wrapper">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-y" role="button" aria-expanded="false"
                                aria-controls="widget-body-y" class="collapsed">CATEGORIES</a>
                        </h3>

                        <div class="collapse show" id="widget-body-y">
                            <div class="side-custom-menu">
                                <div class="side-menu-body">
                                    <ul>
                                        @foreach ($cats as $category)
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
                                                    @foreach ($subcats as $subcategory)
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
                            <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true"
                                aria-controls="widget-body-2">BRANDS</a>
                        </h3>

                        <div class="collapse show" id="widget-body-2">
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
            <div class="col-lg-9">
                <div class="row row-sm">
                    @foreach ($products as $product)
                    <div class="col-6 col-md-4">
                        <div class="product">
                            <figure class="product-image-container">
                                <a href="/show-product/{{$product->id}}" class="product-image">
                                    @if($product->image == null)
                                    <img src="{{ asset('no_img.png') }}" alt="{{ get_app_env('name') }} product">
                                    @else
                                    <img src="{{ asset(explode(',', $product->image)[0]) }}" alt="{{ get_app_env('name') }} product">
                                    @endif
                                </a>
                            </figure>
                            <div class="product-details">
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings"
                                            style="width:@if($product->top == null)90%@else 100%@endif"></span>
                                        <!-- End .ratings -->
                                    </div><!-- End .product-ratings -->
                                </div><!-- End .product-container -->
                                <h2 class="product-title">
                                    <a href="/show-product/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price-box">
                                    <span class="product-price">ksh {{number_format($product->price)}}</span>
                                </div><!-- End .price-box -->

                                <div class="product-action">
                                    <a href="javascript:void(0)"
                                        onclick="addProduct('product-{{ $product->id }}', {{ $product->id }})"
                                        class="paction add-cart" title="Add to Cart" id="product-{{ $product->id }}">
                                        <span>Add to Cart</span>
                                    </a>
                                </div><!-- End .product-action -->
                            </div><!-- End .product-details -->
                        </div><!-- End .product -->
                    </div><!-- End .col-md-4 -->
                    @endforeach
                </div><!-- End .row -->

                <nav class="toolbox toolbox-pagination">
                    <div class="toolbox-item toolbox-show">
                        <label>Showing {{$products->firstItem()}}–{{ $products->lastItem() }} of {{$products->total()}}
                            results</label>
                    </div><!-- End .toolbox-item -->

                    <ul class="pagination">
                        {{$products->links()}}
                    </ul>
                </nav>
            </div><!-- End .col-lg-9 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- margin -->
</main><!-- End .main -->
@endsection
