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
            <h3>Add Category<span>/ categories</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row mbn-30">

    <!--Default Form Start-->
    <div class="col-lg-12 col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h4 class="title">Add Category</h4>
            </div>
            <div class="box-body">
                <form id="add_cat" method="POST" action="javascript:void(0)">
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
                                    <label for="formLayoutTitle">Category Title</label>
                                    <input type="text" name="title" id="formLayoutTitle" class="form-control"
                                        placeholder="Enter category here">
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;" class="col-12 mb-20">
                            <button id="add_btn" type="submit" class="button button-primary">Add Category</button>
                        </div>

                    </div>
                </form>
                <script>
                    if ($("#add_cat").length > 0) {
                         $("#add_cat").validate({

                            rules: {
                                title: {
                                    required: true,
                                }
                            },
                            messages: {
                                title: {
                                    required: "You must provide a category",
                                }
                            },
                         submitHandler: function(form) {
                          $.ajaxSetup({
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               }
                           });

                            $('#add_btn').html('adding..');
                            $('#add_btn').removeClass('button-primary');
                            $('#add_btn').addClass('button-default');


                           $.ajax({
                             url: '/admin/categories',
                             type: "POST",
                             data: $('#add_cat').serialize(),
                             success: function( response ) {
                                toastr.success(response.message);
                                document.getElementById("add_cat").reset();
                                $('#add_btn').html('Add Category');
                                $('#add_btn').removeClass('button-default');
                                $('#add_btn').addClass('button-primary');
                             },

                            });
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
