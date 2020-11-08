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
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 order-lg-last dashboard-content">
                        <h2>Edit Account Information</h2>

                        <form action="/user-dashboard/update/{{ $user->slug }}" method="post" class="form-horizontal form-label-left" autocomplete="off">
                        @csrf
                        <div class="form-group required-field">
                            <label for="acc-lastname">Full Name</label>
                            <input value="{{Auth::user()->name}}" type="text" class="form-control" id="acc-lastname"
                                name="name" required>
                        </div><!-- End .form-group -->

                        <div class="form-group required-field">
                            <label for="acc-email">Email</label>
                            <input value="{{Auth::user()->email}}" type="email" class="form-control" id="acc-email"
                                name="email" required>
                        </div><!-- End .form-group -->

                        <div class="form-group required-field">
                            <label for="acc-phone">Phone</label>
                            <input value="{{Auth::user()->phone}}" type="text" class="form-control" id="acc-phone"
                                name="phone" required>
                        </div><!-- End .form-group -->

                        <div class="mb-2"></div><!-- margin -->

                            <h3 class="mb-2">Change Password</h3>
                            <div class="row">
                                    (Enter only if you want to change, otherwise leave blank)
                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label for="acc-pass2">Password </label>
                                        <input autocomplete="false" type="password" class="form-control" id="acc-pass2" name="password">
                                    </div><!-- End .form-group -->
                                </div><!-- End .col-md-6 -->

                                <div class="col-md-6">
                                    <div class="form-group required-field">
                                        <label for="acc-pass3">Confirm Password</label>
                                        <input type="password" class="form-control" id="acc-pass3"
                                            name="confirm_password">
                                    </div><!-- End .form-group -->
                                </div><!-- End .col-md-6 -->
                            </div><!-- End .row -->
                    </div><!-- End .col-lg-9 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-lg-last dashboard-content">
                <h2>My Dashboard</h2>
                <div class="alert alert-success" role="alert">
                    Hello, <strong>{{$user->name}}</strong> From this Dashboard you have the ability to view a snapshot
                    of your orders and update your account information.
                </div><!-- End .alert -->

                <div class="mb-4"></div><!-- margin -->
                <div class="row">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">
                                Account Information
                                <a href="#" class="card-edit">Edit</a>
                            </div><!-- End .card-header -->

                            <div class="card-body">
                                <p>
                                    Name:&nbsp;&nbsp;&nbsp;&nbsp;<b>{{$user->name}}</b><br>
                                    Email:&nbsp;&nbsp;&nbsp;&nbsp; <b>{{$user->email}}</b><br>
                                    Phone:&nbsp;&nbsp;&nbsp;&nbsp; <b>{{$user->phone}}</b>
                                    <br><br>
                                    <a class="btn btn-primary" style="font-size:13px; color:white;" data-toggle="modal"
                                        data-target="#exampleModalCenter"><i class="fa fa-edit"></i> Edit Details</a>
                                </p>
                            </div><!-- End .card-body -->
                        </div><!-- End .card -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .col-lg-9 -->
            @include('client.layouts.dashboard_menu')
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- margin -->
</main><!-- End .main -->
@endsection
