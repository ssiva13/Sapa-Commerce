@extends('admin.layouts.app')

@section('search')
<form action="{{ route('products.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search for products...">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection

@section('styles')
{{-- <link id="cus-style" rel="stylesheet" href="{{ asset('/admn/assets/css/style-primary.css') }}"> --}}
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
<script>
    $('.summernote').summernote({
        height: 250,
    });
</script>
{{-- TypeAhead: PLEASE NO MORE scripts below this - within this section --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> ::Duplicate --}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
@section('content')
<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <!-- Page Heading Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Add Sliders<span>/ sliders</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row mbn-30">

    <!--Default Form Start-->
    <div class="col-lg-12 col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h4 class="title">Add Sliders</h4>
            </div>
            <div class="box-body">
                <form id="add_slider" method="POST" action="{{url('/admin/sliders')}}" enctype="multipart/form-data">
                    <style>
                        .error {
                            color: red;
                        }

                        #text_err {
                            color: red;
                        }

                    </style>
                    @csrf
                    {{-- <input type="text" value="{{ $slider->id }}" name="slide_id" id="slide_id" class="form-control" readonly> --}}
                    <div class="row mbn-20">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="formLayoutTitle">Slide Title</label>
                                    <input type="text" name="title" id="formLayoutTitle" class="form-control"
                                        placeholder="Title">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="sliders">Slider</label>
                                    <div id="sliders">
                                        <input type="file" name="slider" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div style="margin-top:15px;" class="col-12 mb-15">
                                    <label class="adomx-checkbox"><input type="checkbox" name="active-slide"><i
                                            class="icon"></i>Mark as active slide</label>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;" class="col-12 mb-20">
                            <button id="add_btn" type="submit" class="button button-primary">Add Slider</button>
                        </div>

                    </div>
                </form>
                <script>


                </script>
            </div>
        </div>
    </div>
    <!--Default Form End-->
</div>

@endsection