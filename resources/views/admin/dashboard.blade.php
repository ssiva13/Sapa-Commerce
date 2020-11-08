@extends('admin.layouts.app')


@section('search')
<form action="{{ route('products.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search for products...">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection


@section('styles')
@endsection
@section('scripts')
    <!-- Plugins & Activation JS For Only This Page -->

    <!--Moment-->
    <script src="{{ asset('/admn/assets/js/plugins/moment/moment.min.js') }}"></script>

    <!--Daterange Picker-->
    <script src="{{ asset('/admn/assets/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/admn/assets/js/plugins/daterangepicker/daterangepicker.active.js') }}"></script>

    <!--Echarts-->
    <script src="{{ asset('/admn/assets/js/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('/admn/assets/js/plugins/chartjs/chartjs.active.js') }}"></script>

    <!--VMap-->
    <script src="{{ asset('/admn/assets/js/plugins/vmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('/admn/assets/js/plugins/vmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('/admn/assets/js/plugins/vmap/maps/samples/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('/admn/assets/js/plugins/vmap/vmap.active.js') }}"></script>
@endsection
@section('content')
    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Admin <span>| Dashboard</span></h3>
            </div>
        </div><!-- Page Heading End -->


    </div><!-- Page Headings End -->

    <!-- Top Report Wrap Start -->
    <div class="row">
        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Admins</h4>
                    <a href="{{ route('admin_index') }}" class="view"><i class="zmdi zmdi-eye"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h5>Total</h5>
                    <h2>{{ $admins }}</h2>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar" style="width: 100%;"></div>
                    </div>
                    <p>Total number of admins</p>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Users</h4>
                    <a href="{{ route('users.index') }}" class="view"><i class="zmdi zmdi-eye"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h5>Total</h5>
                    <h2>{{ $users }}</h2>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar" style="width: 100%;"></div>
                    </div>
                    <p>Total number of users</p>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Products</h4>
                    <a href="{{ route('products.index') }}" class="view"><i class="zmdi zmdi-eye"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h5>Total</h5>
                    <h2>{{ $products }}</h2>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar" style="width: 100%;"></div>
                    </div>
                    <p>Total number of products</p>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Pending deliveries</h4>
                    <a href="{{ route('orders.pending') }}" class="view"><i class="zmdi zmdi-eye"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h5>Total</h5>
                    <h2>{{ $pending_deliveries }}</h2>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar" style="width: 100%;"></div>
                    </div>
                    <p>Total number of pending deliveries</p>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Paid Orders</h4>
                    <a href="{{ route('orders.paid') }}" class="view"><i class="zmdi zmdi-eye"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h5>Total</h5>
                    <h2>{{ $paid_orders }}</h2>
                </div>
                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar" style="width: 100%;"></div>
                    </div>
                    <p>Total number of paid orders</p>
                </div>
            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head">
                    <h4>Users</h4>
                    <a href="{{ route('users.index') }}" class="view"><i class="zmdi zmdi-eye"></i></a>
                </div>

                <!-- Content -->
                <div class="content">
                    <h5>Total</h5>
                    <h2>{{ $users }}</h2>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="progess">
                        <div class="progess-bar" style="width: 100%;"></div>
                    </div>
                    <p>Total number of users</p>
                </div>

            </div>
        </div><!-- Top Report End -->
    </div><!-- Top Report Wrap End -->
@endsection
