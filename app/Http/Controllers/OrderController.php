<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;

class OrderController extends Controller
{
    public function search(Request $request)
    {
        $message = $request->my_query;
        $param = $request->param;
        if($param == 'All'){
            $invoices = Invoice::search($request->my_query, null, true)->paginate(100)->setPath ( '' );
            $pagination = $invoices->appends($request->all());
            return view('admin.orders.index')->with('invoices', $invoices)
                                                    ->with('message', $message)
                                                    ->with('param', 'All')
                                                    ->withQuery($request->all());
        }
        if($param == 'Paid'){
            $invoices = Invoice::where('paid', true)->search($request->my_query, null, true)->paginate(100)->setPath ( '' );
            $pagination = $invoices->appends($request->all());
            return view('admin.orders.index')->with('invoices', $invoices)
                                                    ->with('message', $message)
                                                    ->with('param', 'Paid')
                                                    ->withQuery($request->all());
        }
        if($param == 'Pending'){
            $invoices = Invoice::where('paid', true)->where('delivered', null)->orWhere('delivered', false)->search($request->my_query, null, true)->paginate(100)->setPath ( '' );
            $pagination = $invoices->appends($request->all());
            return view('admin.orders.index')->with('invoices', $invoices)
                                                    ->with('message', $message)
                                                    ->with('param', 'Pending')
                                                    ->withQuery($request->all());
        }
    }

    public function index(){
        $invoices = Invoice::orderBy('updated_at', 'DESC')->paginate(100);
        return view('admin.orders.index')->with('invoices', $invoices)->with('param', 'All');
    }    
    public function paid_orders(){
        $invoices = Invoice::orderBy('updated_at', 'DESC')->where('paid', true)->paginate(100);
        return view('admin.orders.index')->with('invoices', $invoices)->with('param', 'Paid');
    }   
    public function pending_deliveries(){
        $invoices = Invoice::orderBy('updated_at', 'DESC')->where('paid', true)->where('delivered', null)->orWhere('delivered', false)->paginate(100);
        return view('admin.orders.index')->with('invoices', $invoices)->with('param', 'Pending');
    }   
    public function show(Invoice $invoice){
        // dd(substr($invoice->items->first()->product->image, 0, strpos($invoice->items->first()->product->image, ',')));
        return view('admin.orders.show')->with('invoice', $invoice);
    } 
    public function mark_delivered(Request $request){
        $ids = json_decode( $request->ids, true);
        foreach ($ids as $id) {
            $invoice = Invoice::find($id);
            $invoice->delivered = true;
            $invoice->save();
        }
        return response()->json(['success'=>'Updated successfully.', 'status'=>'Updated successfully.', 'ids' => $request->ids, 'delivery' => true]);
        return redirect()->back()->with('success', 'Successfully updated');
    } 
    public function unmark_delivered(Request $request){
        $ids = json_decode( $request->ids, true);
        foreach ($ids as $id) {
            $invoice = Invoice::find($id);
            $invoice->delivered = false;
            $invoice->save();
        }
        return response()->json(['success'=>'Updated successfully.', 'status'=>'Updated successfully.', 'ids' => $request->ids, 'delivery' => false]);
        return redirect()->back()->with('success', 'Successfully updated');
    } 
}
