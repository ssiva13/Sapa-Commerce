<?php

namespace App\Http\Controllers;

use App\Mpesa;
use Exception;
use Auth;
use Session;
use App\User;
use App\Invoice;
use App\Cart;
use App\Item;
use App\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;

class MpesaController extends Controller
{
    public function transactions()
    {
        $transactions = Mpesa::orderBy('created_at', 'DESC')->where('responseCode', '==', 0)->paginate(200);
        return view('admin.transactions.index')->with('transactions', $transactions)->with('param', 'All');
    }
    public function completed()
    {
        $transactions = Mpesa::orderBy('created_at', 'DESC')->where('resultCode', '==', 0)->paginate(200);
        return view('admin.transactions.index')->with('transactions', $transactions)->with('param', 'Completed');
    }
    public function cancelled()
    {
        $transactions = Mpesa::orderBy('created_at', 'DESC')->where('resultCode', '!=', 0)->paginate(200);
        return view('admin.transactions.index')->with('transactions', $transactions)->with('param', 'Cancelled');
    }
    public function show_transaction(Mpesa $mpesa)
    {
        return view('admin.transactions.mpesa_show')->with('transaction', $mpesa);
    }
    public function search(Request $request)
    {
        $message = $request->my_query;
        $param = $request->param;
        if($param == 'All'){
            $transactions = Mpesa::where('responseCode', '===', 0)->search($request->my_query, null, true)->paginate(200)->setPath ( '' );
            $pagination = $transactions->appends($request->all());
            return view('admin.transactions.index')->with('transactions', $transactions)
                                                    ->with('message', $message)
                                                    ->with('param', 'All')
                                                    ->withQuery($request->all());
        }
        if($param == 'Completed'){
            $transactions = Mpesa::where('resultCode', '===', 0)->search($request->my_query, null, true)->paginate(200)->setPath ( '' );
            $pagination = $transactions->appends($request->all());
            return view('admin.transactions.index')->with('transactions', $transactions)
                                                    ->with('message', $message)
                                                    ->with('param', $param)
                                                    ->withQuery($request->all());
        }
        if($param == 'Cancelled'){
            $transactions = Mpesa::where('resultCode', '!=', 0)->search($request->my_query, null, true)->paginate(200)->setPath ( '' );
            $pagination = $transactions->appends($request->all());
            return view('admin.transactions.index')->with('transactions', $transactions)
                                                    ->with('message', $message)
                                                    ->with('param', $param)
                                                    ->withQuery($request->all());
        }
    }
    public function get_access_token()
    {
        // Get Access Token Start


        $token_url=\Config::get('mpesa.token_url');
        $consumer_key=\Config::get('mpesa.consumer_key');
        $consumer_secret=\Config::get('mpesa.consumer_secret');
        $client = new Client();
        $request = $client->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
            'auth' => [
                $consumer_key,
                $consumer_secret
            ]
        ]);
        $body = $request->getBody()->getContents();

        // Rewind the stream
        // $body->rewind();
        $access_token = json_decode($body, true)['access_token'];
        return $access_token;
        // End Access Token
    }

    public function make_payment(Request $request)
    {
        $this->validate($request,[
            'phone' =>'required | min:9',
        ]);
        $order_id = $request->order_id;

        if(!$order_id || \Auth::user()->id != Order::find($order_id)->user->id)
            return redirect('/checkout')->with('info', 'Fill the checkout form.');
        if(!check_cart()){
            return redirect('/')->with('error', 'Sorry, your cart is empty.');
        }
        $cart = $this->getCheckoutData($order_id);
        $access_token = $this->get_access_token();
        $client = new Client();
        $time = date('YmdHis');
        $shortcode = \Config::get('mpesa.shortcode');
        $passkey = \Config::get('mpesa.passkey');
        $password = base64_encode($shortcode . $passkey . $time);
        $phoneNumber = intval($request->phone);
        $phoneNumber = '254' . $phoneNumber;
        $phoneNumber = $phoneNumber;//99315478
        $amount = 1;//$cart['total'];
        if($amount >= 70000){
            return redirect()->back()->with('error', 'Transaction failed, MAXIMUM amount supported by Mpesa is KES 69,999.')->with('order_id', $order_id);
        }
        $accountReference = 'Techblaze. ' . $cart['invoice_description'];
        $stkpush_url = \Config::get('mpesa.stkpush_url');

        $headers = [
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
            // 'Host: sandbox.safaricom.co.ke'
        ];
        $data = [
            "BusinessShortCode" => $shortcode,
            "Password" => $password,
            "Timestamp" => $time,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA" => $phoneNumber,
            "PartyB" => $shortcode,
            "PhoneNumber" => $phoneNumber,
            "CallBackURL" => route('handle_result_api'),
            "QueueTimeOutURL" => route('queue_timeout_api'),
            // "CallBackURL" => "https://2502dbd3.ngrok.io/api/handle-result",
            // "QueueTimeOutURL" => "https://2502dbd3.ngrok.io/api/handle-result",
            "AccountReference" => $accountReference,
            "TransactionDesc" => "Testing Sandbox"
        ];
        try {
            $request = $client->request('POST', $stkpush_url, [
                'headers' => $headers,
                'json' => $data,
            ]);
            $response = $request->getBody()->getContents();
            $response = json_decode($response, true);

            $result = Mpesa::create([
                'user_id' => Auth::user()->id,
                'merchantRequestID' => $response['MerchantRequestID'],
                'checkoutRequestID' => $response['CheckoutRequestID'],
                'responseCode' => $response['ResponseCode'],
                'responseDescription' => $response['ResponseDescription'],
                'customerMessage' => $response['CustomerMessage'],
                'phoneNumber' => $phoneNumber,
                'amount' => $amount,
                'cart_id' => $cart['cart_id'],
            ]);
            return redirect('/shop')->with('success', $result->customerMessage);
            // dd($result->customerMessage);
        }
        catch (Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Transaction failed, please try again.')->with('order_id', $order_id);
        }

    }

    public function query_request(Request $request){
        $access_token = $this->get_access_token();
        $client = new Client();
        $time = date('YmdHis');
        $shortcode = \Config::get('mpesa.shortcode');
        $passkey = \Config::get('mpesa.passkey');
        $password = base64_encode($shortcode . $passkey . $time);
        $checkoutRequestID = $request->checkoutRequestID;
        $query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        $headers = [
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
            // 'Host: sandbox.safaricom.co.ke'
        ];
        $data = [
            "BusinessShortCode" => $shortcode,
            "Password" => $password,
            "Timestamp" => $time,
            "CheckoutRequestID" => $checkoutRequestID,
        ];
        try {
            $request = $client->request('POST', $query_url, [
                'headers' => $headers,
                'json' => $data,
            ]);
            $response = $request->getBody()->getContents();
            $data = json_decode($response, true);
            if($data['ResponseCode'] === '0'){
                $result = Mpesa::where('checkoutRequestID', $data['CheckoutRequestID'])->first();
                if($result == null)
                    // dd('No existing record for this transaction.');
                    return redirect()->back()->with('error', 'No existing record for this transaction.');
                if($result->active == true){
                    $result->active = false;
                    $result->resultCode = $data['ResultCode'];
                    $result->resultDesc = $data['ResultDesc'];
                    $cart = json_decode(Cart::find($result->cart_id)->content,true);
                    if($data['ResultCode'] == 0){
                        $result->completed = true;
                        if($result->save()){
                            $payment_id = $result->id;
                            $status = 'Completed';
                            $invoice = $this->createInvoice($cart, $status, $payment_id);
                            $result->invoice_id = $invoice->id;
                            $result->save();
                            // dd('Database Updated Successfully');
                            return redirect()->back()->with('success', "Transaction was successful. Order has been processed.");
                        }
                        // dd('failed to save');
                        return redirect()->back()->with('error', "An arror occured. " . $data['ResultDesc']);
                    }
                    // dd($data['ResultDesc']);
                    $invoice = $this->createInvoice($cart, 'Failed', $result->id);
                    if($invoice){
                        $result->invoice_id = $invoice->id;
                        $result->save();
                    }
                    return redirect()->back()->with('error', "The transaction had failed due to: " . $data['ResultDesc']);
                }
                else{
                    // dd('Transaction had been successfully recorded recorded earlier.');
                    return redirect()->back()->with('data', $data)->with('info', 'Transaction had been successfully recorded earlier.');
                }

            }
            return redirect()->back()->with('error', "The transaction had failed due to: " . $data['responseDescription']);
            // dd($data['responseDescription']);
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', 'Transaction failed, please try again.');
            // dd('Request failed, please try again.');
        }
    }

    public function handle_result(Request $request)
    {
        $data = $request->all();
        $data = $data['Body']['stkCallback'];
        $result = Mpesa::where('checkoutRequestID', $data['CheckoutRequestID'])->where('active', true)->first();
        $result->active = false;
        $result->result = json_encode($data);

        // $result->merchantRequestID = $data['MerchantRequestID'];
        // $result->checkoutRequestID = $data['CheckoutRequestID'];
        $result->resultCode = $data['ResultCode'];
        $result->resultDesc = $data['ResultDesc'];
        $result->save();
        $cart = json_decode(Cart::find($result->cart_id)->content,true);
        if($result->resultCode == 0){
            $items = $data['CallbackMetadata']['Item'];
            foreach($items as $item){
                if($item['Name'] == 'Amount' && array_key_exists('Value', $item))
                    $result->amount = $item['Value'];
                elseif($item['Name'] == 'MpesaReceiptNumber' && array_key_exists('Value', $item))
                    $result->mpesaReceiptNumber = $item['Value'];
                elseif($item['Name'] == 'Balance' && array_key_exists('Value', $item))
                    $result->balance = $item['Value'];
                elseif($item['Name'] == 'TransactionDate' && array_key_exists('Value', $item))
                    $result->transactionDate = date('Y-m-d H:i:s', strtotime($item['Value']));
                // elseif($item['Name'] == 'PhoneNumber' && array_key_exists('Value', $item))
                //     $result->phoneNumber = $item['Value'];//substr($item['Value'], 0, strpos($item['Value'], '.'));
            }
            $result->completed = true;
            if($result->save()){
                $payment_id = $result->id;
                $status = 'Completed';
                $this->createInvoice($cart, $status, $payment_id);
                return response('created', 201);
            }
        }
        $this->createInvoice($cart, 'Failed', $result->id);
        return response('Failed', 401);

    }

    public function queue_timeout(Request $request){
        Mpesa::create([
            'user_id' => 1,
            'plan_id' => 1,
            'checkoutRequestID' => 0,
            'result' => json_encode($request->all()),
        ]);

    }

    public function receive_reversal(Request $request)
    {
        Mpesa::create([
            'user_id' => 1,
            'plan_id' => 1,
            'checkoutRequestID' => 0,
            'result' => json_encode($request->all()),
        ]);
        return response('Ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mpesa  $mpesa
     * @return \Illuminate\Http\Response
     */
    protected function getCheckoutData($order_id)
    {
        $cart_instance = Cart::create();
        $cart = Session::get('cart');
        $data = [];
        $data['items'] = $cart['items'];
        $new_data = [];
        if($cart) {
            foreach($data['items'] as $item){
                $row = ['name' => $item['title'], 'price' => $item['price'], 'qty' => $item['quantity'], 'id' => $item['id']];
                $new_data[] = $row;
            }
            $data['items'] = $new_data;
            $data['invoice_id'] = 'TB/' . date('Y') . '/Mpesa'.'_'.$order_id;
            $data['invoice_description'] = $data['invoice_id'];//"Order #$order_id Invoice";
            $data['total'] = $cart['product_parameters']['total_amount'];
            $data['order_id'] = $order_id;
            $data['user_id'] = Auth::user()->id;
            $data['cart_id'] = $cart_instance->id;

            $cart_instance->content = json_encode($data);
            $cart_instance->save();
            return $data;
        }
        return redirect('/')->with('error', 'Sorry, your cart is empty.');

    }


    protected function createInvoice($cart, $status, $payment_id = null)
    {
        if(Invoice::where('mpesa_id', $payment_id)->count() > 0){
            return false;
        }
        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->total = $cart['total'];
        $invoice->order_id = $cart['order_id'];
        $invoice->user_id = $cart['user_id'];
        $invoice->payment_method = 'Mpesa';
        if (strtoupper($status) == strtoupper('Completed') || strtoupper($status) == strtoupper('Processed')) {
            $invoice->paid = true;
        } else {
            $invoice->paid = false;
        }
        $invoice->payment_id = $payment_id;
        $invoice->mpesa_id = $payment_id;
        $invoice->save();
        if (strtoupper($status) == strtoupper('Completed') || strtoupper($status) == strtoupper('Processed')) {
            try {
                $user = User::find($cart['user_id']);
                $order = Order::find($cart['order_id']);
                $data = [
                    'order_id' => $invoice->id, 
                    'amount' => $cart['total'], 
                    'order_number' => $cart['invoice_description'],
                    'time' => now()->format('l jS, M Y  h:i a'),
                    'name' => $user->name, 
                    'email' => $order->email, 
                    'email_to' => 'info@techblaze.co.ke', 
                    'phone' => $order->phone, 
                ];

                \Mail::send( 'mailings.order', $data, function( $message ) use ($data)
                {
                    $message->to( $data['email_to'] )->from( 'no-reply@techblaze.co.ke')->subject( 'Order Notification: ' . $data['order_number']);
                });
            } 
            catch (\Exception $e) {
                // dd($e->getMessage());
            }
        }
        collect($cart['items'])->each(function ($product) use ($invoice) {
            $item = new Item();
            $item->invoice_id = $invoice->id;
            $item->product_id = $product['id'];
            $item->price = $product['price'];
            $item->quantity = $product['qty'];
            $item->title = $product['name'];

            $item->save();
        });

        return $invoice;
    }

}
