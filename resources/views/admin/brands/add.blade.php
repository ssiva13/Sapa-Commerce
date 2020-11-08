@extends('admin.layouts.app')


@section('search')
<form action="{{ route('products.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search for products...">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection


@section('styles')
<link id="cus-style" rel="stylesheet" href="{{ asset('/admn/assets/css/style-primary.css') }}">
<link id="cus-style" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
@endsection
@section('scripts')
<script src="{{ asset('/admn/assets/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('/admn/assets/js/plugins/select2/select2.active.js') }}"></script>
<script src="{{ asset('/admn/assets/js/plugins/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('/admn/assets/js/plugins/dropify/dropify.active.js') }}"></script>
<script src="{{ asset('admn/assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('admn/assets/js/plugins/summernote/summernote.active.js') }}"></script>
{{-- <script src="{{ asset('admn/assets/js/plugins/quill/quill.min.js') }}"></script> --}}

{{-- <script src="{{ asset('admn/assets/js/plugins/quill/quill.active.js') }}"></script> --}}

@endsection
@section('content')
<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <!-- Page Heading Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Add Brand<span>/ Brands</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row mbn-30">

    <!--Default Form Start-->
    <div class="col-lg-12 col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h4 class="title">Add Brand</h4>
            </div>
            <div class="box-body">
                <form id="add_brand" method="POST" action="{{url('/admin/brands')}}" enctype="multipart/form-data">
                    <style>
                        .error{
                            color:red;
                        }
                    </style>
                    @csrf
                    <div class="row mbn-20">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="formLayoutTitle">Brand Title</label>
                                    <input type="text" name="title" id="formLayoutTitle" class="form-control"
                                        placeholder="Enter brand here">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                                <div class="row">
                                    <div class="col-12 mb-15">
                                        <label for="brand_photo">Brand Image</label>
                                        <div id="brand_photo">
                                            <input type="file" name="photo" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
    
    
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                                <div class="row">
                                    <div style="margin-top:15px;" class="col-12 mb-15">
                                        <label class="adomx-checkbox"><input type="checkbox" name="active-brand"><i
                                                class="icon"></i>Mark as active brand image</label>
                                    </div>
                                </div>
                            </div>

                        <div style="text-align:center;" class="col-12 mb-20">
                            <button id="add_btn" type="submit" class="button button-primary">Add Brand</button>
                        </div>

                    </div>
                </form>
                <script>
                    if ($("#add_brand").length > 0) {
                         $("#add_brand").validate({

                            rules: {
                                title: {
                                    required: true,
                                }
                            },
                            messages: {
                                title: {
                                    required: "You must provide a brand",
                                }
                            }
                       })
                     }
                </script>
            </div>
        </div>
    </div>
    <!--Default Form End-->
</div>

@endsection
