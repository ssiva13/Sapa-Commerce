<h4>A new order has been made please view details below: </h4><br>
<h5>Order Number:</h5> {{ $order_number }} <br>
<h5>Customer Name:</h5> {{ $name }} <br>
<h5>Email:</h5> {{ $email }} <br>
<h5>Phone:</h5> {{ $phone }} <br>
<h5>Amount:</h5> KES {{ number_format($amount) }} <br>
<h5>Time:</h5> {{ $time }} <br><br>

View full details <a href="{{ route('orders.show', $order_id) }}">here</a>
<hr style="color: black"><br><br>
If you’re having trouble clicking the link above, copy and paste the URL below into your web browser: {{ route('orders.show', $order_id) }}