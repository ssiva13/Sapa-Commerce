<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;

class InvoiceController extends Controller
{
    public function pending_deliveries(){
        $pending_deliveries = Invoice::where('paid', true)->where('delivered', true);
        return view('pending_deliveries')->with('pending_deliveries', $pending_deliveries);
    }
}
