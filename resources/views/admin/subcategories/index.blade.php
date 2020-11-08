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
            <h3 class="title">subcategory<span>| List of all subcategories</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->
<!-- Recent Transaction Start -->
<div class="col-12 mb-30">
    <div class="box">
        <div class="box-head">
            <h4 class="title">subcategories Details </h4>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-vertical-middle table-selectable">

                    <!-- Table Head Start -->
                    <thead>
                        <tr>
                            <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                        class="icon"></i></label></th>
                            <th><span>Title</span></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead><!-- Table Head End -->

                    <!-- Table Body Start -->
                    <tbody>
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
                        @foreach($subcategories as $subCategory)
                        <tr>
                            <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                        class="icon"></i></label></td>
                            <td><a href="#">{{ $subCategory->title }}</a></td>
                            <td>
                                <!-- Small modal -->
                                <a data-toggle="modal" data-target=".mod{{ $subCategory->id }}"><span
                                        class="badge badge-danger">Delete</span></a>

                                <div class="modal modal-center fade bs-example-modal-sm mod{{ $subCategory->id }}"
                                    tabindex="" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>sure you want to delete?</h4>
                                            </div>
                                            <form action="{{url('/admin/subcategories', [$subCategory->id])}}" method="POST"
                                                enctype="multipart/form-data">
                                                @method('DELETE')
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
                            <td>
                                <!-- Small modal -->
                                <a data-toggle="modal" data-target=".mod2{{ $subCategory->id }}"><span
                                        class="badge badge-primary"><i class="fa fa-edit"></i> Edit</span></a>

                                <div class="modal fade bs-example-modal-sm mod2{{ $subCategory->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Edit Subcategory</h4>
                                                {!! Form::open(['action' => ['SubCategoryController@update',
                                                $subCategory->id],
                                                'method' => 'PUT']) !!}
                                                @csrf
                                                <div class="row mbn-20">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-20">
                                                        <div class="row">
                                                            <div class="col-12 mb-15">
                                                                <label for="formLayoutTitle">Subcategory Title</label>
                                                                <input type="text" name="title" id="formLayoutTitle"
                                                                    class="form-control"
                                                                    value="{{$subCategory->title}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-xs btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-xs btn-primary" type="submit">Update
                                                    Subcategory</button>
                                                </form>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                        </tr>
                        @endforeach
                    </tbody><!-- Table Body End -->

                </table>
            </div>
        </div>
    </div>
</div><!-- Recent Transaction End -->
@endsection