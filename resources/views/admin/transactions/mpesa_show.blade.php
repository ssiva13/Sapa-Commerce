@extends('admin.layouts.app')

@section('search')
<form action="{{ route('mpesa.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Search... Mpesa Transactions">
    <input type="text" name="param" style="display: none" value="All">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h2><i class="fa fa-google-wallet"></i> Transaction {!! $transaction->completed == true? '<small
                    style="color: green">Successful<i class="fa fa-check text-success"></i></small>': '<small
                    style="color: red"><i class="fa fa-times text-danger"></i>Failed</small> | <small>Feeling like the
                    transaction went through? <a
                        href="/admin/mpesa/query-request?checkoutRequestID=' . $transaction->checkoutRequestID . '">click
                        here</a></small>' !!}</h2>
        </div>

    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Transaction Details</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item" style="overflow:auto">
                            <b>Transaction Date</b> <span
                                class="pull-right">{{ $transaction->transactionDate != null? date('jS, M Y  h:i a', strtotime($transaction->transactionDate)): date('jS, M Y  h:i a', strtotime($transaction->created_at)) }}</span>
                        </li>
                        <li class="list-group-item" style="overflow:auto">
                            <b>User's Name</b>
                            @if ($transaction->user != null)
                            <a class="pull-right"
                                href="{{ route('users.show', ['slug' => $transaction->user->slug]) }}">{{ $transaction->user != null? $transaction->user->name: '__' }}</a>
                            @else
                            <a class="pull-right"
                                href="javascript:void(0)">{{ $transaction->user != null? $transaction->user->name: '__' }}</a>
                            @endif
                        </li>
                        <li class="list-group-item" style="overflow:auto">
                            <b>Phone</b> <span class="pull-right">{{ $transaction->phoneNumber }}</span>
                        </li>
                        <li class="list-group-item" style="overflow:auto">
                            <b>Order</b>
                            @if ($transaction->invoice != null)
                            <a class="pull-right"
                                href="{{ route('orders.show', ['id' => $transaction->invoice->id]) }}">{{ $transaction->invoice != null? $transaction->invoice->title: '__' }}</a>
                            @else
                            <a class="pull-right"
                                href="javascript:void(0)">{{ $transaction->invoice != null? $transaction->invoice->title: '__' }}</a>
                            @endif
                        </li>
                        @if ($transaction->completed == true)
                        <li class="list-group-item" style="overflow:auto">
                            <b>Result Status</b> <a class="pull-right">
                                {{ $transaction->completed == true? 'Successful': $transaction->resultDesc }}
                                {{ $transaction->completed == false? 'Pending...': '' }}</a>
                        </li>
                            @if ($transaction->completed == true)
                                <li class="list-group-item" style="overflow:auto">
                                    <b>Amount</b> <a class="pull-right">Ksh. {{ $transaction->amount }}</a>
                                </li>
                                <li class="list-group-item" style="overflow:auto">
                                    <b>Receipt Number</b> <a class="pull-right">{{ $transaction->mpesaReceiptNumber }}</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                    <br><br>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection