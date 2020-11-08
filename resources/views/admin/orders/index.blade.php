@extends('admin.layouts.app')

@section('search')
<form action="{{ route('orders.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search for {{ $param }} Orders... by order number">
    <input type="text" name="param" style="display: none" value="{{ $param }}">
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
            @if (isset($message))
                <h3>{{ $param }} invoices.<small>Search results: {{ $message }}</small></h3>
            @else
                <h3>Orders | <small>List of {{ $param }} orders.</small></h3>
            @endif
        </div>
    </div><!-- Page Heading End -->
</div><!-- Page Headings End -->
<!-- Recent Transaction Start -->
<div class="col-12 mb-30">
    <div class="box">
        <div class="box-head">
            <h4 class="title">invoices Details </h4>
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
                            <th><span>Buyer</span></th>
                            <th><span>Amount</span></th>
                            <th><span>Paid | Delivered</span></th>
                            <th><span>Payment Mode</span></th>
                            <th><span>Date</span></th>
                            <th></th>
                        </tr>
                    </thead><!-- Table Head End -->

                    <!-- Table Body Start -->
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td class="selector"><label class="adomx-checkbox"><input type="checkbox" class="checkboxes" id="{{ $invoice->id }}"> <i
                                        class="icon"></i></label>
                            </td>
                            <td>{{ $invoice->title }}</td>
                            {{-- <td><a href="#">{{ $invoice->title }}</a></td> --}}
                            <td>
                                @if ($invoice->user != null)
                                <a
                                    href="{{ route('users.show', ['slug' => $invoice->user->slug]) }}">{{ $invoice->user != null? $invoice->user->name: '__' }}</a>
                                @else
                                <a
                                    href="javascript:void(0)">{{ $invoice->user != null? $invoice->user->name: '__' }}</a>
                                @endif
                            </td>
                            <td>{{ number_format($invoice->total) }}</td>
                            <td>
                                <span
                                    class="badge @if($invoice->paid == true) badge-success @else badge-danger @endif">@if($invoice->paid == true) Paid @else Not paid @endif</span>
                                    <span class="badge @if($invoice->delivered == true) badge-success @else badge-danger @endif" id="status{{ $invoice->id }}">@if($invoice->delivered == true && $invoice->paid == true) Delivered @elseif($invoice->paid == true) Not Delivered @endif</span>
                            </td>
                            <td>
                                {{ $invoice->payment_method }}
                                @if ($invoice->payment_method == 'Mpesa')
                                    <a href="/admin/{{ $invoice->payment_method }}/show/{{ $invoice->mpesa_id }}"
                                        style="text-decoration:underline" title="View Transaction">
                                        {{ $invoice->mpesa != null && $invoice->mpesa->resultCode === 0? ': ' . $invoice->mpesa->mpesaReceiptNumber: '' }}
                                    </a>
                                @else
                                    {{ $invoice->paypal != null? $invoice->paypal->transaction_id: '' }}
                                @endif
                            </td>
                            <td>
                                {{ date('jS, M Y', strtotime($invoice->created_at)) }}
                            </td>
                            <td>
                                {{-- {{ route('invoices.show', ['invoice' => $invoice->id]) }} --}}
                                <a class="h3" href="{{ route('orders.show', $invoice->id) }}"><i
                                        class="zmdi zmdi-more"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody><!-- Table Body End -->

                </table>
                {{ $invoices->links() }}
                    <form action="{{ route('delivered.unmark') }}" method="post" id="select_form">
                        {{-- {{ route('delivered.mark') }} --}}
                        @csrf
                        <input type="text" name="invoice_ids" id="invoice_ids" required style="display: none">
                        <label for="">With selected, mark as:</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" id="delivered-button">Delivered</button>
                            <button type="submit" class="btn btn-primary" id="not-delivered-button">Not delivered</button>
                        </div>
                        
                    </form>
            </div>
        </div>
    </div>
</div><!-- Recent Transaction End -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#delivered-button').click(function(e) {
        var ids = [];
        e.preventDefault();
        $('.checkboxes').each(function(i, obj) {
            if ($(this).is(':checked')) {
                ids.push($(this).attr('id'));
            }
        });
        if(ids.length == 0){
            alert('You must select an order');
        }
        else{
            var ids = JSON.stringify(ids);
            $.ajax({
                type:'POST',
                url:'{{ route('delivered.mark') }}',
                data:{
                    ids:ids
                },
                success:function(data){
                    toastr.success(data.success, "Success Here!");
                    var ids = JSON.parse(data.ids);
                    ids.forEach(element => {
                        $('#status' + element).removeClass('badge-danger');
                        $('#status' + element).addClass('badge-success');
                        $('#status' + element).text('Delivered');
                    });
                },
                error: function(){
                    toastr.error('Could not save changes.', "Task Failed!");
                }
            });
        }
    });
    $('#not-delivered-button').click(function(e) {
        var ids = [];
        e.preventDefault();
        $('.checkboxes').each(function(i, obj) {
            if ($(this).is(':checked')) {
                ids.push($(this).attr('id'));
            }
        });
        if(ids.length == 0){
            alert('You must select an order');
        }
        else{
            var ids = JSON.stringify(ids);
            $('#invoice_ids').val(ids);
            $.ajax({
                type:'POST',
                url:'{{ route('delivered.unmark') }}',
                data:{
                    ids:ids
                },
                success:function(data, response){
                    toastr.success(data.success, "Success Here!");
                    var ids = JSON.parse(data.ids);
                    ids.forEach(element => {
                        $('#status' + element).removeClass('badge-success');
                        $('#status' + element).addClass('badge-danger');
                        $('#status' + element).text('Not Delivered');
                    });
                },
                error: function(){
                    toastr.error('Could not save changes.', "Task Failed!");
                }
            });
        }
    });
    
    
</script>
@endsection