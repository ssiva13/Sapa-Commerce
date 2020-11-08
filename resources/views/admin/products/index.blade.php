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
            <h3 class="title">Products<span>| List of all products</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->
<!-- Recent Transaction Start -->
<div class="col-12 mb-30">
    <div class="box">
        <div class="box-head">
                @if (isset($message))
                    <h4 class="title">Products | <small>Search results: {{ $message }}</small> </h4>
                @else
                    <h4 class="title">Products Details </h4>
                @endif
            
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
                            <th><span>Category</span></th>
                            <th><span>Subcategory</span></th>
                            <th><span>Brand</span></th>
                            <th><span>Price</span></th>
                            <th><span>Top</span></th>
                            <th><span>Delete</span></th>
                            <th></th>
                        </tr>
                    </thead><!-- Table Head End -->

                    <!-- Table Body Start -->
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                        class="icon"></i></label></td>
                            <td><a href="#">{{ $product->title }}</a></td>
                            <td>{{ $product->category->title }}</td>
                            <td>{{ $product->subcategory->title }}</td>
                            <td>{{ $product->brand->title }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <span
                            class="badge @if($product->top == 'on') badge-success @else badge-danger @endif">@if($product->top == 'on') Yes @else No @endif</span>
                            </td>
                            <td>
                                <!-- Small modal -->
                                <a data-toggle="modal" data-target=".mod{{ $product->id }}"><span
                                        class="badge badge-danger">Delete</span></a>

                                <div class="modal fade bs-example-modal-sm mod{{ $product->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Remove product</h4>
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
                            </td>
                            <td>

                            <a class="h3" href="{{ route('products.show', ['product' => $product->id]) }}"><i
                                        class="zmdi zmdi-more"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody><!-- Table Body End -->

                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div><!-- Recent Transaction End -->
@endsection
