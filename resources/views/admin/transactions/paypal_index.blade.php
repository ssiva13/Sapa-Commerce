@extends('admin.layouts.app')

@section('search')
<form action="{{ route('paypal.search') }}" method="post">
    @csrf
    <input type="text" name="my_query" class="form-control" placeholder="Transaction no, name, phone or email">
    <input type="text" name="param" style="display: none" value="{{ $param }}">
    <button><i class="zmdi zmdi-search"></i></button>
</form>
@endsection

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            @if (isset($message))
            <h3>{{ $param }}Paypal Transactions.<small>Search results: {{ $message }}</small></h3>
            @else
            <h3>Transactions | <small>List of {{ $param }} Transactions.</small></h3>
            @endif

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Paypal <small>Transactions</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        @if ($transactions->count() == 0)
                        <p class="text-center">No record available</p>
                        @else
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>ReceiptNumber</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        @if ($transaction->user != null)
                                        <a
                                            href="{{ route('users.show', ['slug' => $transaction->user->slug]) }}">{{ $transaction->user != null? $transaction->user->name: '__' }}</a>
                                        @else
                                        <a
                                            href="javascript:void(0)">{{ $transaction->user != null? $transaction->user->name: '__' }}</a>
                                        @endif

                                    </td>
                                    <td>{{ date('l jS M, h:i a', strtotime($transaction->created_at)) }}
                                    </td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td><a href="{{ route('paypal.show', ['id' => $transaction->id]) }}"><i
                                                class="fa fa-ellipsis-h"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    $('#datatable').DataTable( {
        "order": [[ 1, "desc" ]]
    } );
} );
</script>
@endsection