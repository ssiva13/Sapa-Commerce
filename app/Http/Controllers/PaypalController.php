<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Cart;
use App\IPNStatus;
use App\Item;
use App\User;
use App\Order;
use App\Paypal;
use Session;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Auth;

class PaypalController extends Controller
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function show_transaction(Paypal $paypal)
    {
        return view('admin.transactions.paypal_show')->with('transaction', $paypal);
    }
    public function completed()
    {
        $transactions = Paypal::orderBy('created_at', 'DESC')->where('completed', true)->paginate(200);
        return view('admin.transactions.paypal_index')->with('transactions', $transactions)->with('param', 'Completed');
    }
    public function search(Request $request)
    {
        $message = $request->my_query;
        $param = $request->param;
        $transactions = Paypal::where('completed', true)->search($request->my_query, null, true)->paginate(200)->setPath ( '' );
        $pagination = $transactions->appends($request->all());
        return view('admin.transactions.paypal_index')->with('transactions', $transactions)
                                                ->with('message', $message)
                                                ->with('param', $param)
                                                ->withQuery($request->all());
    }
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getExpressCheckout($order_id)
    {
        if(!$order_id || \Auth::user()->id != Order::find($order_id)->user->id)
            return redirect('/checkout')->with('info', 'Fill the checkout form.');
        if(!check_cart()){
            return redirect('/')->with('error', 'Sorry, your cart is empty.');
        }
        $cart = $this->getCheckoutData($order_id);
        try {
            $response = $this->provider->setExpressCheckout($cart, false);
            if($response['paypal_link'] == null)
                throw new \Exception("Error Processing Request", 1);
            Paypal::create([
                'token' => $response['TOKEN'],
            ]);
            return redirect($response['paypal_link']);
        }
        catch (\Exception $e) {
            // dd($e->getMessage());
            $invoice = $this->createInvoice($cart, 'Invalid', null, $order_id);
            return redirect('/')->with('error', 'Error processing PayPal payment for Order ' . $invoice->id . '!');
        }
    }

    /**
     * Process payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getExpressCheckoutSuccess($cart_id, Request $request)
    {
        try {
            $token = $request->get('token');
            $PayerID = $request->get('PayerID');

            $cart = Cart::find($cart_id);
            $cart = json_decode($cart->content, true);

            $payment = Paypal::where('token', $token)->first();
            if(!$payment){
                return redirect('/pay-now/'.$cart['order_id'])->with('error', 'This transaction could not be initiated. Try again.');
            }
            if(!$payment->active){
                return redirect('/pay-now/'.$cart['order_id'])->with('info', 'This transaction had already been completed. Thank you.');
            }
            // Verify Express Checkout Token
            $response = $this->provider->getExpressCheckoutDetails($token);
            if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
                // Perform transaction on PayPal
                $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);

                $payment->transaction_id = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];
                $payment->content = json_encode($payment_status);
                $payment_id = $payment->id;

                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                $invoice = $this->createInvoice($cart, $status, $payment_id, $cart['order_id']);
                if ($invoice->paid) {
                    $payment->active = false;
                    $payment->completed = true;
                    $payment->user_id = $cart['user_id'];
                    $payment->amount = $cart['total'];
                    $payment->invoice_id = $invoice->id;
                    $payment->save();
                    return redirect('/')->with('success', 'Order ' . $invoice->id . ' has been paid successfully!');
                } 
                else {
                    return redirect('/')->with('error', 'Error processing PayPal payment for Order ' . $invoice->id);
                }

            }
            return redirect('/')->with('error', $response['ACK']);
        }
        catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect('/')->with('error', 'An error occured');
        }

    }

    /**
     * Parse PayPal IPN.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function notify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $post = [
            'cmd' => '_notify-validate',
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string) $this->provider->verifyIPN($post);

        $ipn = new IPNStatus();
        $ipn->payload = json_encode($post);
        $ipn->status = $response;
        $ipn->save();
    }

    /**
     * Set cart data for processing payment on PayPal.
     *
     * @param bool $recurring
     *
     * @return array
     */
    protected function getCheckoutData($order_id)
    {
        if(!check_cart())
            return redirect('/')->with('error', 'Your cart is empty.');
        if(!$order_id)
            return redirect('/checkout')->with('info', 'Fill the checkout form.');
        $cart_instance = Cart::create();
        $cart = Session::get('cart');
        $data = [];
        $data['items'] = $cart['items'];
        $new_data = [];
        if($cart){
            foreach($data['items'] as $item){
                $row = ['name' => $item['title'], 'price' => $item['price'], 'qty' => $item['quantity'], 'id' => $item['id']];
                $new_data[] = $row;
            }
            $data['items'] = $new_data;
            $order_id = $order_id;
            $data['return_url'] = url('/paypal/ec-checkout-success/' . $cart_instance->id);
            // $data['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
            $data['invoice_id'] = 'TB/' . date('Y/m/d/h:i:s') . '/Pp'.'_'.$order_id;
            $data['invoice_description'] = "Order #$order_id Invoice";
            $data['cancel_url'] = url('/');
            $data['total'] = $cart['product_parameters']['total_amount'];
            $data['order_id'] = $order_id;
            $data['user_id'] = Auth::user()->id;

            $cart_instance->content = json_encode($data);
            $cart_instance->save();
            return $data;
        }
        return redirect('/')->with('error', 'Sorry, your cart is empty.');

    }

    /**
     * Create invoice.
     *
     * @param array  $cart
     * @param string $status
     *
     * @return \App\Invoice
     */
    protected function createInvoice($cart, $status, $payment_id = null, $order_id)
    {
        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->total = $cart['total'];
        $invoice->order_id = $cart['order_id'];
        $invoice->user_id = $cart['user_id'];
        $invoice->payment_method = 'Paypal';
        if (strtoupper($status) == strtoupper('Completed') || strtoupper($status) == strtoupper('Processed')) {
            $invoice->paid = true;
            $invoice->payment_id = $payment_id;
            $invoice->paypal_id = $payment_id;
        } else {
            $invoice->paid = false;
        }
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
            $item->quantity = $product['qty'];
            $item->price = $product['price'];
            $item->title = $product['name'];

            $item->save();
        });

        return $invoice;
    }
}
