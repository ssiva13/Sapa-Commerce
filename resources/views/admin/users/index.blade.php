@extends('admin.layouts.app')

@section('search')
<form action="{{ route('users.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search... {{ $user_type }}s: Name, phone or email">
    <input type="text" name="user_type" style="display: none" value="{{ $user_type }}">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection

@section('styles')
<link id="cus-style" rel="stylesheet" href="{{ asset('/admn/assets/css/style-primary.css') }}">
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
            <h3 class="title">{{ $user_type }}s <span>| List of all {{ $user_type }}s</span></h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->
<!-- Recent Transaction Start -->
<div class="col-12 mb-30">
    <div class="box">
        <div class="box-head">
            @if (isset($message))
                <h4 class="title">{{ $user_type }}s | <small>Search results: {{ $message }}</small> </h4>
            @else
                <h4 class="title">{{ $user_type }}s Details </h4>
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
                            <th><span>Name</span></th>
                            <th><span>Email</span></th>
                            <th><span>Phone</span></th>
                            <th><span>Role</span></th>
                            @if (Auth::user()->type == 'super' || $user_type == 'User')
                            <th><span>Delete</span></th>
                            @endif
                            <th></th>
                        </tr>
                    </thead><!-- Table Head End -->

                    <!-- Table Body Start -->
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                        class="icon"></i></label></td>
                            <td><a href="#">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->Phone }}</td>
                            <td><span class="badge {{ $user->is_admin?  'badge-success': 'badge-info'}}">{{ $user->type }}</span></td>
                            @if (Auth::user()->type == 'super' || $user_type == 'User')
                            <td>
                                <!-- Small modal -->
                                <a data-toggle="modal" data-target=".{{ $user->slug }}"><span class="badge badge-danger">Delete</span></a>
                                
                                <div class="modal fade bs-example-modal-sm {{ $user->slug }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">Remove {{ $user_type }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Confirmation</h4>
                                                <p>Are you sure you want to remove <br> {{ $user->name }}?</p>

                                            </div>
                                            {!! Form::open(['action' => ['UsersController@destroy', $user->slug],
                                            'method' => 'DELETE']) !!}
                                            @csrf
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-xs btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                @csrf
                                                <button class="btn btn-xs btn-danger" type="submit">Remove</button>

                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endif
                            <td><a class="h3" href="{{ route('users.show', ['slug' => $user->slug]) }}"><i class="zmdi zmdi-more"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody><!-- Table Body End -->

                </table>
            </div>
        </div>
    </div>
</div><!-- Recent Transaction End -->
@endsection