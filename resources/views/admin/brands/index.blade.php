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

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <!-- Page Heading Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3 class="title">brand<span>| List of all brands</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->
<!-- Recent Transaction Start -->
<div class="col-12 mb-30">
    <div class="box">
        <div class="box-head">
            <h4 class="title">brands Details </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-vertical-middle table-selectable">
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
                    <!-- Table Head Start -->
                    <thead>
                        <tr>
                            <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                        class="icon"></i></label></th>
                            <th><span>Title</span></th>
                            <th><span>Brand Image</span></th>
                            <th><span>Status</span></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead><!-- Table Head End -->

                    <!-- Table Body Start -->
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                        class="icon"></i></label></td>
                            <td><a href="#">{{ $brand->title }}</a></td>
                            <td>
                                <img src="{{url('/zoom/brands')}}/{{$brand->photo}}" alt="{{$brand->title}}" width="120"
                                    height="70">
                            </td>
                            <td>
                                <span
                                    class="badge @if($brand->active == 'active') badge-success @else badge-danger @endif">
                                    @if($brand->active
                                    == 'active') Active @else Inactive @endif</span>

                            </td>
                            <td>
                                <!-- Small modal -->
                                <a data-toggle="modal" data-target=".mod2{{ $brand->id }}"><span
                                        class="badge badge-primary"><i class="fa fa-edit"></i> Edit</span></a>

                                <div class="modal fade bs-example-modal-sm mod2{{ $brand->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Edit Brand</h4>
                                                {!! Form::open(['action' => ['BrandController@update', $brand->id],
                                                'files' => true, 'method' => 'PUT']) !!}
                                                @csrf
                                                <div class="row mbn-20">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                                                        <div class="row">
                                                            <div class="col-12 mb-15">
                                                                <label for="formLayoutTitle">Brand Title</label>
                                                                <input type="text" name="title" id="formLayoutTitle"
                                                                    class="form-control" value="{{$brand->title}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                                                        <div class="row">
                                                            <div class="col-12 mb-15">
                                                                <label for="formLayoutTitle">Brand Image Active?</label>
                                                                @if (($brand->active)!="")
                                                                <input type="checkbox" name="active-brand" checked><i
                                                                    class="icon"></i>Marked as active brand
                                                                @else
                                                                <input type="checkbox" name="active-brand"><i
                                                                    class="icon"></i>Mark as active brand
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                                                        <div class="row">
                                                            <div class="col-12 mb-15">
                                                                <label for="brand_photo">Brand Image</label>
                                                                <div id="brand_photo">
                                                                    <input type="file" name="photo" accept="image/*"
                                                                        value="{{$brand->photo}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-xs btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-xs btn-primary" type="submit">update
                                                    brand</button>
                                                </form>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <!-- Small modal -->
                                <a data-toggle="modal" data-target=".mod{{ $brand->id }}"><span
                                        class="badge badge-danger">Delete</span></a>

                                <div class="modal fade bs-example-modal-sm mod{{ $brand->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Confirmation</h4>
                                                <p>Are you sure you want to remove brand?</p>

                                            </div>
                                            {!! Form::open(['action' => ['BrandController@destroy', $brand->id],
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
                            </td>

                        </tr>
                        @endforeach
                    </tbody><!-- Table Body End -->

                </table>
            </div>
        </div>
    </div>
</div><!-- Recent Transaction End -->
@endsection