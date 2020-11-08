@extends('admin.layouts.app')

@section('search')
<form action="{{ route('users.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search... Admins: Name, phone or email">
    <input type="text" name="user_type" style="display: none" value="Admin">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection


@section('styles')
  <link id="cus-style" rel="stylesheet" href="{{ asset('/admn/assets/css/style-primary.css') }}">
@endsection
@section('scripts')
  <script src="{{ asset('/admn/assets/js/plugins/select2/select2.full.min.js') }}"></script>
  <script src="{{ asset('/admn/assets/js/plugins/select2/select2.active.js') }}"></script>
  <script src="{{ asset('/admn/assets/js/plugins/dropify/dropify.min.js') }}"></script>
  <script src="{{ asset('/admn/assets/js/plugins/dropify/dropify.active.js') }}"></script>
@endsection
@section('content')
     <!-- Page Headings Start -->
     <div class="row justify-content-between align-items-center mb-10">

      <!-- Page Heading Start -->
      <div class="col-12 col-lg-auto mb-20">
          <div class="page-heading">
              <h3>Fill Admin Details <span>Fields with asterik(*) are madatory | Note that Password defaults to
                '@{{ get_app_env('name') }}'</span></h3>
          </div>
      </div><!-- Page Heading End -->

  </div><!-- Page Headings End -->

  <div class="row mbn-30">


      <!--Horizontal Form Start-->
      <div class="col-lg-12 col-12 mb-30">
          <div class="box">
              <div class="box-head">
                  <h4 class="title">Add an Admin</h4>
              </div>
              <div class="box-body">
                <form action="{{ route('admin.store') }}" id="demo-form2" data-parsley-validate
                class="form-horizontal form-label-left" method="post">
                @csrf
                      <div class="row mbn-20">

                          <div class="col-12 mb-20">
                              <div class="row mbn-10">
                                  <div class="col-sm-3 col-12 mb-10"><label  for="name">Name <span class="required">*</span></label></div>
                                  <div class="col-sm-9 col-12 mb-10"><input type="text" id="name" name="name" required="required" class="form-control" placeholder="Name"></div>
                              </div>
                          </div>
                          <div class="col-12 mb-20">
                              <div class="row mbn-10">
                                  <div class="col-sm-3 col-12 mb-10"><label for="email">Email Address <span class="required">*</span></label></div>
                                  <div class="col-sm-9 col-12 mb-10"><input type="email" name="email" id="email" class="form-control" placeholder="Email"></div>
                              </div>
                          </div>
                          <div class="col-12 mb-20">
                              <div class="row mbn-10">
                                  <div class="col-sm-3 col-12 mb-10"><label for="phone">Phone Number <span class="required">*</span></label></div>
                                  <div class="col-sm-9 col-12 mb-10"><input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number"></div>
                              </div>
                          </div>
                          <div class="col-9 offset-3 mb-20"><label class="adomx-checkbox"><input type="checkbox" name="super"><i class="icon"></i>Make Super Admin</label></div>

                          <div class="col-12 mb-20">
                              <input type="submit" value="submit" class="button button-primary">
                          </div>

                      </div>
                  </form>
              </div>
          </div>
      </div>
      <!--Horizontal Form End-->

  </div>

@endsection
