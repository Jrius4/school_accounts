<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MakePaymentsController extends Controller
{
    public function storePayment(Request $request)
    {
        dump($request->all());
        $payments = new Payment();
        $date = new Carbon();
        $date2 = $date->now();
        $reciept_no = 'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
        .substr(time(),-3).$date->parse($date2)->format('y'));
        $payments->reciept_no = $reciept_no;
        $payments->student_id = $request->student_id;
        $payments->paymentType = $request->paymentType;
        $payments->fullAmount = $request->fullAmount;
        $payments->balance = $request->balance;
        $payments->description = $request->description;
        $payments->paidItems = json_encode($request->paidItems,true);
        $payments->paid_by = $request->paid_by;
        $payments->term_id = $request->term_id;

        if($payments->save()){
            dump($payments->get()->toArray());
            $payments = 'successfully';
        }
        else{
            $payments = 'failed';
        }

        return response()->json(compact('payments'));
    }
}
