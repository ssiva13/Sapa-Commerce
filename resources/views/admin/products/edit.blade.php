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
@endsection
@section('content')
<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <!-- Page Heading Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Edit Product<span>/ edit</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row mbn-30">

    <!--Default Form Start-->
    <div class="col-lg-12 col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h4 class="title">Edit Product Here</h4>
            </div>
            <div class="box-body">
                <form method="PUT" action="javascript:void(0)" id="add_product">
                    <style>
                        .error {
                            color: red;
                        }

                        #text_err {
                            color: red;
                        }

                    </style>
                    @csrf
                    <div class="row mbn-20">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="title">Product Title</label>
                                    <input value="{{$product->title}}" type="text" name="title" id="title"
                                        class="form-control" placeholder="Title">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="brand">Brand</label>
                                    <input value="{{$product->brand->title}}" name="brand_id" type="text" id="brand"
                                        class="form-control" placeholder="Brand">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-20">
                            <div class="row mbn-15">
                                <div class="col-12 mb-15">
                                    <label for="cat">Category</label>
                                    <select name="category_id" class="form-control select2" id="formLayoutEmail">
                                        <optgroup label="All Categories">
                                            <option id="cat" value="{{$product->category->id}}">
                                                {{$product->category->title}}</option>
                                            @foreach ($cats as $category)
                                            <option value="{{$category->id}}">{{$category->title}}
                                            </option>
                                            @endforeach


                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('#formLayoutEmail').change(function() {
                                    $("#formLayoutEmail11").empty();
                                    $("#formLayoutEmail11").append('<option value="">--- select subcategory ---</option>');
                                    var $option = $(this).find('option:selected');
                                    var cat_value = $option.val();
                                    var cat_name = $option.text();
                                    $.ajax({
                                        url : "{{url('autocomplete_sub')}}",
                                        type : "GET",
                                        data : { 'category' : cat_value },
                                        success:function(data){
                                            data.forEach(function(element) {
                                                // console.log(element);
                                                var e = $('<option value="'+ element.id +'">'+ element.title +'</option>');
                                                $('#formLayoutEmail11').append(e);    
                                            });
                                        },  
                                        error:function(e){
                                            console.log(e);
                                        }
                                    });
                                    
                                    
                                });
                        </script>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-20">
                            <div class="row mbn-15">
                                <div class="col-12 mb-15">
                                    <label for="formLayoutEmail1">Subcategory</label>
                                    <select name="subcategory" id="formLayoutEmail11" class="form-control select2">
                                        <optgroup label="All Subcategories">
                                            <option id="subcat" value="{{$product->subcategory->id}}">
                                                {{$product->subcategory->title}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-20">
                            <label for="desc">Description</label>
                            <textarea id="desc" name="description" class="form-control summernote"
                                placeholder="Add Description">{{$product->description}}</textarea>
                            <label id="text_err"></label>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="price">Price</label>
                                    <input value="{{$product->price}}" type="text" name="price" id="price"
                                        class="form-control" placeholder="Price">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div style="margin-top:15px;" class="col-12 mb-15">
                                    <label class="adomx-checkbox"><input id="top" @if($product->top == 'on')checked
                                        @else '' @endif type="checkbox" name="top"><i class="icon"></i>Mark as top
                                        product</label>
                                </div>
                            </div>
                        </div>
                        <textarea id="mytext" style="visibility:hidden;" name="image"></textarea>
                        <div style="text-align:center;" class="col-12 mb-20">
                            <button id="add_btn" type="submit" class="button button-primary">Update Product</button>
                        </div>

                    </div>
                </form>
                <script>
                    if ($("#add_product").length > 0) {
                         $("#add_product").validate({

                            rules: {
                                title: {
                                    required: true,
                                },

                                category_id: {
                                    required: true,
                                },
                                brand: {
                                    required: true,
                                },
                                description: {
                                    required: true,
                                },
                                price: {
                                    required: true,
                                },

                            },
                            messages: {
                                title: {
                                    required: "Please enter a title",
                                },
                                category_id: {
                                    required: "Please provide product category",
                                },
                                brand: {
                                    required: "Please provide product brand",
                                },
                                description: {
                                    required: "Please provide product description",
                                },
                                price: {
                                    required: "Please provide product price",
                                },
                            },
                         submitHandler: function(form) {
                          $.ajaxSetup({
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               }
                           });
                           if($('.summernote').summernote('isEmpty')) {
                                $('#text_err').html('Product Description is required')
                                $('#add_btn').preventDefault();
                            }
                            else {
                            $('#add_btn').html('updating...');
                            $('#add_btn').removeClass('button-primary');
                            $('#add_btn').addClass('button-default');
                            }

                           $.ajax({
                             url: '/admin/products/{{$product->id}}',
                             type: "PUT",
                             data: $('#add_product').serialize(),
                             success: function( response ) {

                                toastr.success(response.message,response.title);
                                document.getElementById("add_product").reset();
                                var p = JSON.parse(response.product);
                                console.log(p.top);
                                $('#title').val(p.title);
                                $('#brand').val(p.brand);
                                $('#cat').val(p.category_id);
                                $('#price').val(p.price);
                                if(p.top == 'on'){
                                    $( "#top" ).prop( "checked", true );
                                }
                                else{
                                    $( "#top" ).prop( "checked", false );
                                }
                                $('#add_btn').html('Update Product');
                                $('#add_btn').removeClass('button-default');
                                $('#add_btn').addClass('button-primary');
                                $('#mytext').html('') ;
                                $('#text_err').html('');
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