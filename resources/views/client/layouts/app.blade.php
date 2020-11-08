<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @yield('title')
        @yield('metadata')
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('client/assets/images/favicon.ico') }}">

        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.min.css') }}">

        <!-- Main CSS File -->
        <link rel="stylesheet" href="{{ asset('client/assets/css/style.min.css') }}">
        <style>
            .logo{
                width: 40%;
                margin: -10% 0%;
            }
        </style>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        {{-- toastr --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    </head>

    <body>

        <div class="page-wrapper">
            <header style="background-color:white;" class="header">
                <div class="header-middle" id="parbticles">
                    <div class="container">
                            {{-- <div id="particles"></div> --}}
                        <div class="header-left" >
                            @auth
                            <a href="/home" class="logo">
                                <img src="{{ asset('/logo.png') }}" alt=" Logo" height="40px">
                            </a>
                            @endauth
                            @guest
                            <a href="/" class="logo">
                                <img src="{{ asset('/logo.png') }}" alt=" Logo" height="40px">
                            </a>
                            @endguest

                        </div><!-- End .header-left -->

                        <div class="header-center">
                            <div class="header-search">
                                <a href="#" class="search-toggle" role="button" style="color: #EE3D29"><i
                                        class="icon-magnifier"></i></a>
                                <form action="{{ route('products.search_by_category') }}" method="get">
                                    <div class="header-search-wrapper">
                                        <input type="search" class="form-control" name="my_query" id="my_query"
                                            placeholder="Search..." required>
                                        <div class="select-custom" >
                                            <select id="category_id" name="category_id">
                                                <option value="">All Categories</option>
                                                @foreach ($global_categories as $global_category)
                                                <option value="{{ $global_category->id }}" class="select_custom_options">{{ $global_category->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div><!-- End .select-custom -->
                                        <button class="btn" type="submit"><i class="icon-magnifier" style="color:#EE3D29;"></i></button>
                                    </div><!-- End .header-search-wrapper -->
                                </form>
                            </div><!-- End .header-search -->
                            <script type="text/javascript">
                                $(document).ready(function() {
                                $( "#my_query").autocomplete({
                                limit: 10,
                                source: function(request, response) {
                                    $.ajax({

                                        url: "{{url('autocomplete-product')}}",
                                        data: {
                                            term : request.term,
                                            cat : $('#category_id').val()
                                        },
                                        dataType: "json",
                                        success: function(data){
                                            var resp = $.map(data,function(obj){
                                                return obj.title;
                                            });

                                            response(resp);
                                        }
                                    });
                                },
                                minLength: 1
                                });
                            });
                            </script>
                        </div><!-- End .headeer-center -->

                        <div class="header-right">
                            <button style="color:#EE3D29" class="mobile-menu-toggler" type="button">
                                <i class="icon-menu"></i>
                            </button>

                            <div class="dropdown cart-dropdown">
                                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" data-display="static">
                                    @if(Session::has('cart'))
                                    <span class="cart-count"
                                        id="cart-count">{{ Session::get('cart')['product_parameters']['total_quantity'] }}</span>
                                    @else
                                    <span class="cart-count" id="cart-count">0</span>
                                    @endif
                                </a>
                                <div class="dropdown-menu">
                                    @if(Session::has('cart'))
                                    <div class="dropdownmenu-wrapper">
                                        <div class="dropdown-cart-header">
                                            <span
                                                id="items-count">{{ Session::get('cart')['product_parameters']['total_quantity'] }}
                                                Item{{ Session::get('cart')['product_parameters']['total_quantity'] > 1?'s':'' }}</span>

                                            <a href="/cart">View Cart</a>
                                        </div><!-- End .dropdown-cart-header -->
                                        <div class="dropdown-cart-products" id="cart-items-container">
                                            @foreach (Session::get('cart')['items'] as $item)
                                            <div class="product" id="cart-item-{{ $item['id'] }}">
                                                <div class="product-details">
                                                    <h4 class="product-title">
                                                        <a
                                                            href="{{ route('show_product', $item['id']) }}">{{ $item['title'] }}</a>
                                                    </h4>

                                                    <span class="cart-product-info">
                                                        <span class="cart-product-qty">{{ $item['quantity'] }}</span>
                                                        x {{ number_format($item['price']) }}
                                                    </span>
                                                </div><!-- End .product-details -->

                                                <figure class="product-image-container">
                                                    <a href="{{ route('show_product', $item['id']) }}"
                                                        class="product-image">
                                                        <img src="{{ $item['image'] }}" alt="product"
                                                            id="img-{{ $item['id'] }}">
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn-remove"
                                                        title="Remove Product"
                                                        onclick="removeProduct({{ $item['id'] }})"><i
                                                            class="icon-cancel"></i></a>
                                                </figure>
                                            </div><!-- End .product -->
                                            @endforeach
                                        </div><!-- End .cart-product -->

                                        <div class="dropdown-cart-total">
                                            <span>Total</span>

                                            <span class="cart-total-price" id="total-amount">Kes
                                                {{ isset(Session::get('cart')['product_parameters']['total_amount']) ? number_format(Session::get('cart')['product_parameters']['total_amount']) : number_format(0) }}
                                            </span>
                                        </div><!-- End .dropdown-cart-total -->

                                        <div class="dropdown-cart-action">
                                            <a href="/checkout" class="btn btn-block"> Checkout</a>
                                        </div><!-- End .dropdown-cart-total -->
                                    </div><!-- End .dropdownmenu-wrapper -->
                                    @else
                                    <div class="dropdownmenu-wrapper">
                                        <div class="dropdown-cart-header">
                                            <span id="items-count">0
                                                Items</span>

                                            <a href="/cart">View Cart</a>
                                        </div><!-- End .dropdown-cart-header -->
                                        <div class="dropdown-cart-products" id="cart-items-container">
                                            {{-- Here goes the appending by js --}}
                                        </div><!-- End .cart-product -->

                                        <div class="dropdown-cart-total">
                                            <span>Total</span>

                                            <span class="cart-total-price" id="total-amount">Kes
                                                {{ isset(Session::get('cart')['product_parameters']['total_amount']) ? number_format(Session::get('cart')['product_parameters']['total_amount']) : number_format(0) }}
                                            </span>
                                        </div><!-- End .dropdown-cart-total -->

                                        <div class="dropdown-cart-action">
                                            <a href="/checkout" class="btn btn-block">Checkout</a>
                                        </div><!-- End .dropdown-cart-total -->
                                    </div><!-- End .dropdownmenu-wrapper -->
                                    @endif
                                </div><!-- End .dropdown-menu -->
                            </div><!-- End .dropdown -->
                        </div><!-- End .header-right -->
                    </div><!-- End .container -->
                </div><!-- End .header-middle -->

                <div style="" class="header-bottom sticky-header">
                {{-- <div style="background-color:#0088cc; color:white;" class="header-bottom sticky-header"> --}}
                    <div class="container" >
                        <nav class="main-nav" >
                            <ul class="menu sf-arrows">
                                <li class="{{ isActiveRoute('landing')}}"><a href="/">Home</a></li>
                                <li
                                    class="{{ areActiveRoutes(['shop','get_brands','get_category','show_cart','show_product'])}}">
                                    <a href="/shop">Shop</a></li>
                                <li class="{{ isActiveRoute('services')}}"><a href="/our-services">services</a></li>
                                @if(Auth::check())
                                <li class="float-right"><a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a>
                                </li>
                                <li class="float-right"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Sign
                                        out ({{Auth::user()->name}})</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                @else
                                <li class="{{ isActiveRoute('login')}} float-right"><a href="/login"><i
                                            class="fa fa-user"></i> Login</a></li>
                                <li class=" {{ isActiveRoute('register')}} float-right"><a href="/register"><i
                                            class="fa fa-plus"></i>Signup</a></li>
                                @endif
                                <li class="{{ isActiveRoute('about')}}"><a href="/about-us">About us</a></li>
                            </ul>
                        </nav>
                    </div><!-- End .header-bottom -->
                </div><!-- End .header-bottom -->
                {{-- <div id="particles"></div> --}}
            </header><!-- End .header -->
        </div>
            @yield('content')

            <footer class="footer">
                <div class="footer-middle">
                    <div class="container">
                        <div class="footer-ribbon">
                            {{ get_app_env('name') }}
                        </div><!-- End .footer-ribbon -->
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="widget">
                                    <h4 class="widget-title">Contact Us</h4>
                                    <ul class="contact-info">
                                        <li>
                                            <span class="contact-info-label">Address:</span>123 Street Name, City, Kenya
                                        </li>
                                        <li>
                                            <span class="contact-info-label">Phone:</span>Toll Free <a href="tel:">(123)
                                                456-7890</a>
                                        </li>
                                        <li>
                                            <span class="contact-info-label">Email:</span> <a
                                                href="mailto:mail@example.com">mail@example.com</a>
                                        </li>
                                        <li>
                                            <span class="contact-info-label">Working Days/Hours:</span>
                                            Mon - Sun / 9:00AM - 8:00PM
                                        </li>
                                    </ul>
                                    <div class="social-icons">
                                        <a href="#" class="social-icon" target="_blank"><i
                                                class="icon-facebook"></i></a>
                                        <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon" target="_blank"><i
                                                class="icon-linkedin"></i></a>
                                    </div><!-- End .social-icons -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-lg-3 -->

                            <div class="col-lg-9">
                                <div class="widget widget-newsletter">
                                    <h4 class="widget-title">Subscribe to our newsletter</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Get all the latest information on Sales and Offers. Sign up for our
                                                newsletter
                                                today</p>
                                        </div><!-- End .col-md-6 -->

                                        <div class="col-md-6">
                                            <form action="#">
                                                <input type="email" class="form-control" placeholder="Email address"
                                                    required>

                                                <input type="submit" class="btn" value="Subscribe">
                                            </form>
                                        </div><!-- End .col-md-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .widget -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="widget">
                                            <h4 class="widget-title">Quick Links</h4>

                                            <div class="row">
                                                <div class="col-sm-6 col-md-5">
                                                    <ul class="links">
                                                        <li><a href="/">Home</a></li>
                                                        <li><a href="/services">services</a></li>
                                                        <li><a href="/about-us">About-us</a></li>
                                                    </ul>
                                                </div><!-- End .col-sm-6 -->
                                                <div class="col-sm-6 col-md-5">
                                                    <ul class="links">
                                                        <li><a href="/shop">Shop</a></li>
                                                        @if(Auth::check())
                                                        <li><a href="/home">Dashboard</a></li>
                                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i
                                                                    class="zmdi zmdi-lock-open"></i>Sign Out</a></li>
                                                        @else
                                                        <li><a href="/register">Register Now</a></li>
                                                        <li><a href="/login">Login</a></li>
                                                        @endif
                                                    </ul>
                                                </div><!-- End .col-sm-6 -->
                                            </div><!-- End .row -->
                                        </div><!-- End .widget -->
                                    </div><!-- End .col-md-5 -->


                                </div><!-- End .row -->
                            </div><!-- End .col-lg-9 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .footer-middle -->

                <div class="container">
                    <div class="footer-bottom">
                        <p class="footer-copyright">{{ get_app_env('name') }} Systems. &copy; {{date('Y')}}. All Rights Reserved</p>

                        <img src="{{ asset('client/assets/images/payments.png') }}" alt="payment methods"
                            class="footer-payments">
                    </div><!-- End .footer-bottom -->
                </div><!-- End .container -->
            </footer><!-- End .footer -->
        </div><!-- End .page-wrapper -->

        <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

        <div class="mobile-menu-container">
            <div class="mobile-menu-wrapper">
                <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
                <nav class="mobile-nav">
                    <ul class="mobile-menu">
                        <li class="{{ isActiveRoute('landing')}} "><a href="/">Home</a></li>
                        <li class="{{ isActiveRoute('about')}}"><a href="/about-us">About us</a></li>
                        <li
                            class="{{ areActiveRoutes(['shop','get_brands','get_category','show_cart','show_product'])}}">
                            <a href="/shop">Shop</a></li>
                        <li class="{{ isActiveRoute('services')}}"><a href="/our-services">services</a></li>
                        @if(Auth::check())
                        <li><a href="/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Sign
                                out ({{Auth::user()->name}})</a></li>
                        @else
                        <li class="{{isActiveRoute('login')}}"><a href="/login"><i class="fa fa-user"></i> Login</a>
                        </li>
                        <li class="{{ isActiveRoute('register')}}"><a href="/register"><i class="fa fa-plus"></i>
                                Signup</a>
                        </li>
                        @endif
                    </ul>
                </nav><!-- End .mobile-nav -->

                <div class="social-icons">
                    <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
                </div><!-- End .social-icons -->
            </div><!-- End .mobile-menu-wrapper -->
        </div><!-- End .mobile-menu-container -->

        <div class="newsletter-popup mfp-hide" id="newsletter-popup-form"
            style="background-image: url(assets/images/newsletter_popup_bg.jpg') }})">
            <div class="newsletter-popup-content">
                <img src="{{ asset('/logo.png') }}" alt="Logo" class="logo-newsletter">
                <h2>BE THE FIRST TO KNOW</h2>
                <p>Subscribe to the Portal eCommerce newsletter to receive timely updates from your favorite products.
                </p>
                <form action="#">
                    <div class="input-group">
                        <input type="email" class="form-control" id="newsletter-email" name="newsletter-email"
                            placeholder="Email address" required>
                        <input type="submit" class="btn" value="Go!">
                    </div><!-- End .from-group -->
                </form>
                <div class="newsletter-subscribe">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1">
                            Don't show this popup again
                        </label>
                    </div>
                </div>
            </div><!-- End .newsletter-popup-content -->
        </div><!-- End .newsletter-popup -->

        <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

        <!-- Plugins JS File -->
        <script src="{{ asset('client/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('client/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('client/assets/js/plugins.min.js') }}"></script>
        <script src="{{ asset('client/assets/js/nouislider.min.js') }}"></script>
        <script src="{{ asset('client/assets/js/canvas.min.js') }}"></script>

        <!-- Main JS File -->
        <script src="{{ asset('client/assets/js/main.min.js') }}"></script>
        <script>
            function removeProduct(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('cart/remove-product')}}",
                type: "POST",
                data: {
                    id : id,
                },
                dataType: "json",
                success: function(data){
                    toastr.success(data.message);
                    if($('#cart-item2-'+id).length){
                        $('#cart-item1-'+id).remove();
                        $('#cart-item2-'+id).remove();
                    }
                    if($('#cart-item-'+id).length){
                        $('#cart-item-'+id).remove();
                    }
                    if($('#summary-item-'+id).length){
                        $('#summary-item-'+id).remove();
                    }
                    if($('#cart-count').text() != data.previous_quantity){
                        location.reload();
                    }
                    $('#cart-count').text(data.total_quantity);
                    $('#items-count').text(data.total_quantity + ' Items');
                    $('#total-amount').text('Kes ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    if($('#total-amount2').length){
                        $('#total-amount1').text('KES ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#total-amount2').text('KES ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    }
                    if($('#prod-total-'+id).length){
                        $('#prod-total-'+id).text('KES ' + (data.quantity * data.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    }
                    if($('#sammary-quantity').length){
                        $('#sammary-quantity').text(data.total_quantity + ' Products in Cart');
                    }
                },
                error: function(){
                    location.reload();
                }
            });
        }

        function addProduct(button, id, horizontal_quantity = 1, set = false){
            var button = $('#' + button);
            console.log(set);
            button.find('span').text('Adding...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('cart/add-product')}}",
                type: "POST",
                data: {
                    id : id,
                    quantity : horizontal_quantity,
                    set: set,
                },
                dataType: "json",
                success: function(data){
                    console.log(data.set);
                    toastr.success(data.message);
                    if($('#cart-item-'+id).length){
                        $('#cart-item-'+id).remove();
                    }
                    if($('#cart-count').text() != data.previous_quantity){
                        location.reload();
                    }
                    $('#cart-count').text(data.total_quantity);
                    $('#items-count').text(data.total_quantity + ' Items');
                    if($('#total-amount2').length){
                        $('#total-amount1').text('KES ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#total-amount2').text('KES ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    }
                    if($('#prod-total-'+id).length){
                        $('#prod-total-'+id).text('KES ' + (data.quantity * data.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    }
                    $('#total-amount').text('Kes ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    if($('#total-amount2').length){
                        $('#total-amount1').text('KES ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#total-amount2').text('KES ' + (data.total_amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    }
                    // var price = (data.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    var div_string = '<div class="product" id="cart-item-' + id + '"> <div class="product-details"> <h4 class="product-title"> <a href="show-product/' + id + '">' + data.item_title + '</a>  </h4> <span class="cart-product-info"> <span class="cart-product-qty">' + data.quantity + '</span> x ' + data.price + ' </span> </div><!-- End .product-details --> <figure class="product-image-container"> <a href="show-product/' + id + '" class="product-image"> <img src="' + data.image + '" alt="product" id="img-' + id + '">  </a> <a href="javascript:void(0)" class="btn-remove" title="Remove Product" onclick="removeProduct(' + id + ')"><i class="icon-cancel"></i></a> </figure> </div> ';
                    $('#cart-items-container').append(
                        div_string
                    );
                    button.find('span').text('Add to Cart');
                },
                error: function(){
                    location.reload();
                }
            });
        }
        </script>
        {{-- Toastr --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @include('layouts.messages')
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </body>

</html>
