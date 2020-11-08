<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ get_app_env('name') }}| Admin</title>
        <meta name="robots" content="noindex, follow" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/admn/assets/images/favicon.ico') }}">

        <!-- CSS
	============================================ -->

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/vendor/bootstrap.min.css') }}">

        <!-- Icon Font CSS -->
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/vendor/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/vendor/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/vendor/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/vendor/cryptocurrency-icons.css') }}">

        <!-- Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/plugins/plugins.css') }}">

        <!-- Helper CSS -->
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/helper.css') }}">

        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{ asset('/admn/assets/css/style.css') }}">

        <style>
            .logo {
                width: 40%;
                margin: -10% 0%;
            }

        </style>

        {{-- toastr --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        @yield('styles')

        <!-- jQuery Validate -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    </head>

    <body>

        <div class="main-wrapper">


            <!-- Header Section Start -->
            <div class="header-section">
                <div class="container-fluid">
                    <div class="row justify-content-between align-items-center">

                        <!-- Header Logo (Header Left) Start -->
                        <div class="header-logo col-auto">
                            <a href="/">
                                <img src="{{ asset('/logo.png') }}" alt="logo" height="40px">
                            </a>
                        </div><!-- Header Logo (Header Left) End -->

                        <!-- Header Right Start -->
                        <div class="header-right flex-grow-1 col-auto">
                            <div class="row justify-content-between align-items-center">

                                <!-- Side Header Toggle & Search Start -->
                                <div class="col-auto">
                                    <div class="row align-items-center">

                                        <!--Side Header Toggle-->
                                        <div class="col-auto"><button class="side-header-toggle"><i
                                                    class="zmdi zmdi-menu"></i></button></div>

                                        <!--Header Search-->
                                        <div class="col-auto">

                                            <div class="header-search">

                                                <button class="header-search-open d-block d-xl-none"><i
                                                        class="zmdi zmdi-search"></i></button>

                                                <div class="header-search-form">

                                                    @yield('search')

                                                    <button class="header-search-close d-block d-xl-none"><i
                                                            class="zmdi zmdi-close"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div><!-- Side Header Toggle & Search End -->

                                <!-- Header Notifications Area Start -->
                                <div class="col-auto">

                                    <ul class="header-notification-area">


                                        <!--User-->
                                        <li class="adomx-dropdown col-auto">
                                            <a class="toggle" href="#">
                                                <span class="user">
                                                    <span class="avatar">
                                                        <img src="{{ asset('/avatar.jpg') }}" alt="">
                                                        <span class="status"></span>
                                                    </span>
                                                    <span class="name">{{ Auth::user()->name }}</span>
                                                </span>
                                            </a>

                                            <!-- Dropdown -->
                                            <div class="adomx-dropdown-menu dropdown-menu-user">
                                                <div class="head">
                                                    <h5 class="name"><a
                                                            href="{{ route('users.show', ['slug' => Auth::user()->slug]) }}">{{ Auth::user()->name }}</a>
                                                    </h5>
                                                    <a class="mail"
                                                        href="javascript:void(0)">{{ Auth::user()->email }}</a>
                                                </div>
                                                <div class="body">
                                                    <ul>
                                                        <li><a
                                                                href="{{ route('users.show', ['slug' => Auth::user()->slug]) }}"><i
                                                                    class="zmdi zmdi-account"></i>Profile</a></li>
                                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i
                                                                    class="zmdi zmdi-lock-open"></i>Sign out</a></li>
                                                    </ul>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>

                                        </li>

                                    </ul>

                                </div><!-- Header Notifications Area End -->

                            </div>
                        </div><!-- Header Right End -->

                    </div>
                </div>
            </div><!-- Header Section End -->
            <!-- Side Header Start -->
            <div class="side-header show">
                <button class="side-header-close"><i class="zmdi zmdi-close"></i></button>
                <!-- Side Header Inner Start -->
                <div class="side-header-inner custom-scroll">

                    <nav class="side-header-menu" id="side-header-menu">
                        <ul>
                            <li><a href="{{ route('home') }}"><i class="ti-home"></i> <span>Dashboard</span></a></li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-users"></i> <span>Admins</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('admin_index') }}"><i class="fa fa-eye"></i><span>View
                                                Admins</span></a></li>
                                    <li><a href="{{ route('add_admin') }}"><i class="fa fa-user-plus"></i><span>Add
                                                Admin</span></a></li>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-users"></i> <span>Users</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('users.index') }}"><i class="fa fa-eye"></i><span>View
                                                Users</span></a></li>
                                    <li><a href="{{ route('users.create') }}"><i class="fa fa-user-plus"></i><span>Add
                                                User</span></a></li>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-shopping-cart"></i>
                                    <span>Categories</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('categories.index') }}"><span>All Categories</span></a></li>
                                    <li><a href="{{ route('categories.create') }}"><span>Add Category</span></a></li>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-shopping-cart"></i>
                                    <span>Subcategories</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('subcategories.index') }}"><span>All Subcategories</span></a>
                                    </li>
                                    <li><a href="{{ route('subcategories.create') }}"><span>Add Subcategory</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-shopping-cart"></i>
                                    <span>Brands</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('brands.index') }}"><span>All Brands</span></a></li>
                                    <li><a href="{{ route('brands.create') }}"><span>Add Brand</span></a></li>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-shopping-bag"></i>
                                    <span>Products</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('products.index') }}"><span>All Products</span></a></li>
                                    <li><a href="{{ route('products.create') }}"><span>Add Product</span></a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('orders.pending') }}"><i class="fa fa-hourglass"></i> <span>Pending
                                        Deliveries</span></a></li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-shopping-bag"></i>
                                    <span>Orders</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('orders.paid') }}"><span>Paid Orders</span></a></li>
                                    <li><a href="{{ route('orders.index') }}"><span>All Orders</span></a></li>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="javascript:void(0)"><i class="fa fa-google-wallet"></i>
                                    <span>Transactions</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('mpesa.transactions') }}"><span>Mpesa Transactions</span></a>
                                    </li>
                                    <li><a href="{{ route('mpesa.completed') }}"><span>Mpesa Completed</span></a></li>
                                    <li><a href="{{ route('mpesa.cancelled') }}"><span>Mpesa Cancelled/Failed</span></a>
                                    </li>
                                    <li style="display:none"><a href="{{ route('mpesa.search') }}"><span>Searching
                                                Mpesa</span></a></li>
                                    <li style="display:none"><a href="{{ route('paypal.search') }}"><span>Searching
                                                Paypal</span></a></li>
                                    <li><a href="{{ route('paypal.completed') }}"><span>Paypal Completed</span></a>
                                </ul>
                            </li>
                            <li class="has-sub-menu"><a href="#"><i class="fa fa-shopping-bag"></i>
                                    <span>Sliders</span></a>
                                <ul class="side-header-sub-menu">
                                    <li><a href="{{ route('sliders.index') }}"><span>All Sliders</span></a></li>
                                    <li><a href="{{ route('sliders.create') }}"><span>Add Slider</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>

                </div><!-- Side Header Inner End -->
            </div><!-- Side Header End -->

            <!-- Content Body Start -->
            <div class="content-body">
                @yield('content')
            </div><!-- Content Body End -->

            <!-- Footer Section Start -->
            <div class="footer-section">
                <div class="container-fluid">

                    <div class="footer-copyright text-center">
                        <p class="text-body-light">2019 &copy; <a href="{{ route('home') }}">{{ get_app_env('name') }}</a></p>
                    </div>

                </div>
            </div><!-- Footer Section End -->

        </div>

        <!-- JS
============================================ -->

        <!-- Global Vendor, plugins & Activation JS -->
        <script src="{{ asset('/admn/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>

        <script src="{{ asset('/admn/assets/js/vendor/popper.min.js') }}"></script>
        <script src="{{ asset('/admn/assets/js/vendor/bootstrap.min.js') }}"></script>
        <!--Plugins JS-->
        <script src="{{ asset('/admn/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('/admn/assets/js/plugins/tippy4.min.js.js') }}"></script>
        <!--Main JS-->
        <script src="{{ asset('/admn/assets/js/main.js') }}"></script>
        {{-- Toastr --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @include('layouts.messages')
        @yield('scripts')

    </body>

</html>
