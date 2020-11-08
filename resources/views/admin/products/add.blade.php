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
            <h3>Add Products<span>/ products</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row mbn-30">

    <!--Default Form Start-->
    <div class="col-lg-12 col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h4 class="title">Add Products</h4>
            </div>
            <script>
                $(document).ready(function () {
                    (function () {
                        $('#images').wrap('<form id="images-send" action="{{route('image_store')}}" method="post" class="dropzone" enctype="multipart/form-data" ></form>');
                })();});
            </script>
            {{-- <form method="POST" action="/admin/image-store" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file[]" multiple>
                <input type="submit" value="send">
            </form> --}}
            <div class="box-body">
                <form id="add_product" method="POST" action="javascript:void(0)">
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
                                    <label for="formLayoutTitle">Product Title</label>
                                    <input type="text" name="title" id="formLayoutTitle" class="form-control"
                                        placeholder="Title">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="images">Image(s)</label>
                                    <div id="images">
                                        @csrf
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="formLayoutPassword1">Brand</label>
                                    <input name="brand" type="text" id="formLayoutPassword1" class="form-control"
                                        placeholder="Brand">
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $( "#formLayoutPassword1").autocomplete({
                                limit: 2,
                                source: function(request, response) {
                                    $.ajax({
                                        url: "{{url('autocomplete')}}",
                                        data: {
                                            term : request.term
                                        },
                                        dataType: "json",
                                        success: function(data){
                                            var resp = $.map(data,function(obj){
                                                //   console.log(obj.title);
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
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-20">
                            <div class="row mbn-15">
                                <div class="col-12 mb-15">
                                    <label for="formLayoutEmail1">Category</label>
                                    <select name="category" id="formLayoutEmail" class="form-control select2">
                                        <optgroup label="All Categories">
                                            <option value="{{null}}">--- select category ---</option>
                                            @foreach ($cats as $category)
                                            <option value="{{$category->id}}">{{$category->title}} - {{$category->id}}</option>
                                            @endforeach


                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <script>
                            
                            $('#formLayoutEmail').change(function() {
                                $("#formLayoutEmail1").empty();
                                $("#formLayoutEmail1").append('<option value="">--- select subcategory ---</option>');
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
                                            $('#formLayoutEmail1').append(e);    
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
                                    <select name="subcategory" id="formLayoutEmail1" class="form-control select2">
                                        <optgroup label="All Categories">
                                            <option value="{{null}}">--- select subcategory ---</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mb-20">
                            <label for="formLayoutDescription">Description</label>
                            <textarea id="formLayoutDescription" name="description" class="form-control summernote"
                                placeholder="Add Description"></textarea>
                            <label id="text_err"></label>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-15">
                                    <label for="formLayoutPrice">Price</label>
                                    <input type="text" name="price" id="formLayoutPrice" class="form-control"
                                        placeholder="Price">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                            <div class="row">
                                <div style="margin-top:15px;" class="col-12 mb-15">
                                    <label class="adomx-checkbox"><input type="checkbox" name="top"><i
                                            class="icon"></i>Mark as top product</label>
                                </div>
                            </div>
                        </div>
                        <textarea id="mytext" style="visibility:hidden;" name="image"></textarea>
                        <div style="text-align:center;" class="col-12 mb-20">
                            <button id="add_btn" type="submit" class="button button-primary">Add Product</button>
                        </div>

                    </div>
                </form>
                <script>
                    var img_name = [];
                    var total_photos_counter = 0;
                    window.reset = false;
                    Dropzone.options.imagesSend = {
                        paramName: "file", // The name that will be used to transfer the file
                        uploadMultiple: true,
                        parallelUploads: 1,
                        maxFilesize: 2,
                        addRemoveLinks: true,
                        dictRemoveFile: 'Remove image',
                        dictFileTooBig: 'Image is larger than 2MB',
                        timeout: 10000,

                        renameFile: function(file){
                            var today = new Date()
                            newName = today.getTime()+file.name;
                            return newName;
                        },

                        init: function(){

                            this.on("addedfile", function(file) {
                                $('.dz-message').hide();
                                window.total_photos = Dropzone.forElement('#images-send').getUploadingFiles().length;
                                $('#add_btn').html('Images Uploading...');
                            });

                            this.on("complete", function(file) {
                                window.total_photos = Dropzone.forElement('#images-send').getUploadingFiles().length;
                                if(window.total_photos == 0){
                                    $('#add_btn').html('Add Product');
                                }
                            });
                            this.on("removedfile", function (file) {
                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/del-pre',
                                    data: {name: file.upload.filename, _token: $('[name="_token"]').val()},
                                    dataType: 'json',
                                    success: function (response) {
                                        var idx = img_name.indexOf(response.name);
                                        if(idx != -1){
                                            img_name.splice(idx, 1);
                                        }
                                        console.log(idx);
                                        document.getElementById('mytext').innerHTML = img_name;
                                        total_photos_counter--;
                                        $("#counter").text("# " + total_photos_counter);
                                        toastr.success(response.message);

                                    }
                                });
                            });

                        },

                        success: function(file, response){
                            console.log(file.upload.filename);
                            total_photos_counter++;
                            img_name.push(response.image);
                            document.getElementById('mytext').innerHTML = img_name;

                        }
                    };

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
                                image: {
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
                                image: {
                                    required: "You Must Provide at least one valid image"
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
                            $('#add_btn').html('adding..');
                            $('#add_btn').removeClass('button-primary');
                            $('#add_btn').addClass('button-default');
                            }

                           $.ajax({
                             url: '/admin/products',
                             type: "POST",
                             data: $('#add_product').serialize(),
                             success: function( response ) {

                                toastr.success(response.message);
                                document.getElementById("add_product").reset();
                                $('.dz-preview').empty();
                                $('.dz-message').show();
                                $('.dz-message').css('display','inline');
                                //Dropzone.forElement('#images-send').removeAllFiles();
                                $('.summernote').summernote("reset");
                                $('#add_btn').html('Add Product');
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