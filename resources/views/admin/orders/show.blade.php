@extends('admin.layouts.app')

@section('search')
<form action="{{ route('orders.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search for All Orders... by order number">
    <input type="text" name="param" style="display: none" value="All">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection

@section('content')
     <!-- Page Headings Start -->
     <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3><i class="fa fa-user"></i>{{ $invoice->user != null? $invoice->user->name:'' }} <span>| Order Details</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <div class="row mbn-30">

        <!--Order Details Head Start-->
        <div class="col-12 mb-30">
            <div class="row mbn-15">
                <div class="col-12 col-md-4 mb-15">
                    <h4 class="text-primary fw-600 m-0">Order {{ $invoice->title }}</h4>
                </div>
                <div class="text-left text-md-center col-12 col-md-4 mb-15">
                    <span>
                        Delivery: {!! $invoice->delivered? '<span class="badge badge-round badge-success" id="delivery_badge">Delivered</span> <a href="/admin/unmark-as-delivered" id="mark_delivery">Mark as not delivered?</a>': '<span class="badge badge-round badge-danger" id="delivery_badge">Not delivered</span> <a href="/admin/mark-as-delivered" id="mark_delivery">Mark as delivered?</a>' !!}
                    </span>
                </div>
                <div class="text-left text-md-right col-12 col-md-4 mb-15">
                    <p>{{ date('l jS, M Y  h:i a', strtotime($invoice->created_at)) }}</p>
                </div>
            </div>
        </div>
        <!--Order Details Head End-->

        <!--Order Details Customer Information Start-->
        <div class="col-12 mb-30">
            <div class="order-details-customer-info row mbn-20">

                <!--Shipping Info Start-->
                <div class="col-lg-6 col-md-6 col-12 mb-20">
                    <h4 class="mb-25">Shipping Info</h4>
                    <ul>
                            <li> <span>Name</span> <span>{{ $invoice->user != null? $invoice->user->name:'' }}</span> </li>
                            <li> <span>Country</span> <span>Kenya</span> </li>
                            <li> <span>Address</span> <span>{{ $invoice->order != null? $invoice->order->address:'__' }}</span> </li>
                            <li> <span>City</span> <span>{{ $invoice->order != null? $invoice->order->city:'__' }}</span> </li>
                            <li> <span>Email</span> <span>{{ $invoice->order != null? $invoice->order->email:'__' }}</span> </li>
                            <li> <span>Phone</span> <span>{{ $invoice->order != null? $invoice->order->phone:'__' }}</span> </li>
                    </ul>
                </div>
                <!--Shipping Info End-->

                <!--Purchase Info Start-->
                <div class="col-lg-6 col-md-6 col-12 mb-20">
                    <h4 class="mb-25">Purchase Info</h4>
                    <ul>
                        <li> <span>Items</span> <span>{{ $invoice->items != null? count($invoice->items):'__' }}</span> </li>
                        <li> <span>Price</span> <span>KES {{ number_format($invoice->total) }}</span> </li>
                        <li> <span>Shipping</span> <span>KES 0.00</span> </li>
                        <li> <span>Total</span> <span>KES {{ number_format($invoice->total) }}</span> </li>
                        <li> <span class="h5 fw-600">Status</span> {!! $invoice->paid? '<span class="h5 fw-600 text-success">Paid</span>': '<span class="h5 fw-600 text-danger">Not paid</span>' !!} </li>
                        <li> <span>Payment</span>
                            @if ($invoice->paypal != null || $invoice->mpesa != null)
                            <span><a href="{{ '/admin/' . $invoice->payment_method . '/show/'. $invoice->payment_id }}"> {!! $invoice->paid? $invoice->payment_method: '__' !!} <i class="fa fa-eye"></i></a></span>
                            @else
                                <span>{!! $invoice->paid? $invoice->payment_method: '__' !!}</span> 
                            @endif
                        </li>
                        
                    </ul>
                </div>
                <!--Purchase Info End-->

            </div>
        </div>
        <!--Order Details Customer Information Start-->

        <!--Order Details List Start-->
        <div class="col-12 mb-30">
            <h4 class="mb-25">Items</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-vertical-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                            {{-- {{ $invoice->mpesa != null && $invoice->mpesa->resultCode === 0? ': ' . $invoice->mpesa->mpesaReceiptNumber: '' }} --}}
                            @if ($invoice->items != null)
                                
                                @foreach ($invoice->items as $item)
                                    @if ($item != null)
                                        @if ($item->product != null)
                                            <tr>
                                                <td><a href="{{ route('products.show', $item->product->id) }}">{{ $item->product->title }}</a></td>
                                                <td>{{ number_format($item->product->price) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->quantity * $item->product->price) }}</td>
                                            </tr>
                                        @else

                                        @endif                 
                                    @else
                                        
                                    @endif
                                
                                @endforeach     
                            @else
                                
                            @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!--Order Details List End-->

    </div>
    <script>
        $( document ).ready(function() {
            window.ids = {{ $invoice->id }};
            window.delivered = {{ $invoice->delivered == true? $invoice->delivered: 'false' }};
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#mark_delivery').click(function(e) {
            var id = [];
            e.preventDefault();
            $('#mark_delivery').text('Please wait...');
            id.push(ids);
            var new_id = JSON.stringify(id);
            $.ajax({
                type:'POST',
                url: $('#mark_delivery').attr('href'),
                data:{
                    ids:new_id,
                },
                success:function(data){
                    toastr.success('Successful', "Success Here!");
                    if (data.delivery) {
                        $('#delivery_badge').removeClass('badge-danger');
                        $('#delivery_badge').addClass('badge-success');
                        $('#delivery_badge').text('Delivered');
                        $('#mark_delivery').text('Mark as not delivered?');
                        $('#mark_delivery').prop('href', '/admin/unmark-as-delivered');
                    }
                    else{
                        $('#delivery_badge').removeClass('badge-success');
                        $('#delivery_badge').addClass('badge-danger');
                        $('#delivery_badge').text('Not delivered');
                        $('#mark_delivery').text('Mark as delivered?');
                        $('#mark_delivery').prop('href', '/admin/mark-as-delivered');
                    }
                    
                },
                error: function(){
                    toastr.error('Could not save changes.', "Task Failed!");
                    if(delivered){
                        $('#mark_delivery').text('Mark as not delivered?');
                    }
                    else{
                        $('#mark_delivery').text('Mark as delivered?');
                    }
                }
            });
        });
    </script>
@endsection