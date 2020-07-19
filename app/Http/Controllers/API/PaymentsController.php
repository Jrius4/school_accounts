<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function makePayment()
    {
        return view('fianance.payments.make-payments');
    }
    public function viewPayments()
    {
        return view('fianance.payments.view-payments');
    }

    public function viewExpenses()
    {
        return view('fianance.payments.view-expenses');
    }
}
