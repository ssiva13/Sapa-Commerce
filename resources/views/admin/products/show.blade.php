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
<div style="display:none;">{{$n = 0}}</div>

@foreach ($images as $image)
<div class="modal fade bs-example-modal-sm mod{{ $n }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Remove image</h4>
            </div>
            <div class="modal-body">
                <h4>Confirmation</h4>
                <p>Are you sure you want to remove image? changes cannot be undone.</p>

            </div>
            <form id="del" method="POST" action="{{route('img_del', ['name' => $image, 'product' => $product->id])}}">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-xs btn-danger" id="del_btn{{$n}}" type="submit">Remove</button>

                </div>
            </form>
        </div>
    </div>
</div>
<div style="display:none;">{{$n++}}</div>
@endforeach

<div class="row mbn-50">
    <!--Timeline / Activities Start-->
    <div class="col-xlg-8 col-12 mb-50">
        <div class="box">

            <div class="box-head">
                <h3 class="title">Product Details</h3>
            </div>

            <div class="box-body">
                <div class="timeline-wrap row mbn-50">
                    <div class="col-12 mb-50"><span class="timeline-date">BRAND: {{$product->brand->title}}</span></div>

                    <div class="col-12 mb-50">
                        <ul class="timeline-list">
                            <li>
                                <span class="icon"><i class="fa fa-image"></i></span>
                                <div class="details">
                                    <h5 class="title"><a href="#">{{$product->title}}</a></h5>
                                    <div class="gallery">
                                        <div class="cont row mbn-30">
                                            <div style="display:none;">{{$n = 0}}</div>
                                            @foreach ($images as $image)
                                            <div style="display:relative" id="img_cont"
                                                class="container container-img col-md-4 col-sm-6 col-12 mb-30">
                                                <img src="{{ asset($image) }}" alt="">
                                                <a data-toggle="modal" data-target=".mod{{ $n }}"><i title="delete"
                                                        class="fa fa-trash text-danger btn1"></i></a>
                                                @if($n == 0)
                                                <a href="javascript:void(0)" class="text-primary btn2"><i
                                                        class="fa fa-check-circle"></i>cover photo</a>
                                                @else
                                                <a
                                                    href="{{ route('cover_photo', ['id' => $product->id, 'image' => $n]) }}"><i
                                                        class="fa fa-photo text-primary btn2"> mark cover</i></a>
                                                @endif
                                            </div>
                                            <style>
                                                .container-img {
                                                    position: relative;
                                                }

                                                .container-img img {
                                                    width: 100%;
                                                    height: auto;
                                                }

                                                .container-img .btn1 {
                                                    position: absolute;
                                                    top: 90%;
                                                    left: 30%;
                                                    transform: translate(-20%, -20%);
                                                    -ms-transform: translate(-50%, -50%);
                                                    color: white;
                                                    font-size: 16px;
                                                    width: 120px;
                                                    border: none;
                                                    cursor: pointer;
                                                    border-radius: 5px;

                                                }

                                                .container-img .btn2 {
                                                    position: absolute;
                                                    top: 90%;
                                                    left: 50%;
                                                    transform: translate(-20%, -20%);
                                                    -ms-transform: translate(-50%, -50%);
                                                    color: white;
                                                    font-size: 16px;
                                                    border: none;
                                                    cursor: pointer;
                                                    border-radius: 5px;
                                                    width: 120px;
                                                }

                                                .btn2 {
                                                    margin-left: 15px;
                                                }
                                            </style>
                                            <div style="display:none;">{{$n++}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <span class="icon"><i class="zmdi zmdi-receipt"></i></span>
                                <div class="details">
                                    <h5 class="title"><a href="#">Product Details</a></h5>
                                    <div class="box-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">Title: {{$product->title}}</li>
                                            <li class="list-group-item">Category: {{$product->category->title}}</li>
                                            <li class="list-group-item">Subcategory: {{$product->subcategory->title}}</li>
                                            <li class="list-group-item">Brand: {{$product->brand->title}}</li>
                                            <li class="list-group-item">Price: Ksh{{$product->price}}</li>
                                            <li class="list-group-item">Top: @if($product->top == 'on') Yes @else No
                                                @endif</li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <span class="icon"><i class="zmdi zmdi-receipt"></i></span>
                                <div class="details">
                                    <h5 class="title"><a href="#">Product Description</a></h5>
                                    <p class="mb-1">{!!$product->description!!}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                        <div class="row">
                            <div class="col-12 mb-15">
                                <h5 class="title"><a href="#">Add Images</a></h5>
                                <script>
                                    $(document).ready(function () {
                                                    (function () {
                                                        $('#images').wrap('<form id="images-send" action="{{route('image_add')}}" method="post" class="dropzone" enctype="multipart/form-data" ></form>');
                                                })();});
                                </script>
                                <div id="images">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br><br>
                <div class="col-lg-12 col-md-12 col-sm-12 mb-20" style="text-align:center">
                    <a href="{{route('products.edit',['product' => $product->id])}}"><button
                            class="button button-primary right"><span><i
                                    class="fa fa-pencil"></i>Edit</span></button></a>
                    <style>
                        .modal {
                            width: 400px;
                            height: 400px;
                            left: 50%;
                            top: 50%;
                            position: absolute;
                            margin-left: -150px;
                            margin-top: -150px;
                        }
                    </style>
                    <!-- Small modal -->
                    <a data-toggle="modal" data-target=".mod{{ $product->id }}"><span class="button button-danger"><i
                                class="fa fa-trash"></i> Delete</span></a>

                    <div class="modal fade bs-example-modal-sm mod{{ $product->id }}" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4>Confirmation</h4>
                                    <p>Are you sure you want to remove product?</p>

                                </div>
                                {!! Form::open(['action' => ['ProductController@destroy', $product->id],
                                'method' => 'DELETE']) !!}
                                @csrf
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-xs btn-default"
                                        data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-xs btn-danger" type="submit">Remove</button>

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <script>
                Dropzone.options.imagesSend = {
                        paramName: "file", // The name that will be used to transfer the file
                        uploadMultiple: true,
                        parallelUploads: 1,
                        maxFilesize: 2,
                        addRemoveLinks: true,
                        dictRemoveFile: 'Remove image',
                        dictFileTooBig: 'Image is larger than 2MB',
                        timeout: 10000,

                        init: function(){
                            this.on("removedfile", function (file) {
                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/images-delete',
                                    data: {id: file.name, product: {{$product->id}}, _token: $('[name="_token"]').val()},
                                    dataType: 'json',
                                    success: function (response) {
                                        console.log(response.name);
                                            toastr.success(response.message);

                                    }
                                });
                            });
                        },
                        success: function(file, response){
                            toastr.success(response.message,response.title);
                        }
                    };
            </script>
        </div>
    </div>
</div>
@endsection
