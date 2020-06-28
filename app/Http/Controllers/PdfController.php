<?php

namespace App\Http\Controllers;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function printTestTfile(){

        $data = collect([
            [
                'name'=>'Julia','goals'=>['Cooking','Flying','driving']
            ],
            [
                'name'=>'Kaggwa','goals'=>['Degree','Masters','Healing']
            ],
            [
                'name'=>'James','goals'=>['Cooking','Flying','driving','Cooking','Flying','driving']
            ],
            ]);
            $data->toArray();

        // $data = collect([1,2,3,4,5,6,7,8,12,3,45,5,7]);
        // $data = $data->chunk(3);
        // $data->toArray();
        // $chunk = $data->forPage(1,2);
        // $data = $chunk->all();
        // dd($chunk);
        // dd($data->firstWhere('name','James'));
        // return view('pdf.test-pdf',compact('data'));
        $pdf = \PDF::loadView('pdf.test-pdf',compact('data'));
        return $pdf->setPaper('A4', 'portrait')->download('students.pdf');
        // return $pdf->setPaper('A4', 'landscape')->download('students.pdf');

    }

    public function printInvoice(){
        // return view('pdf.invoice');

        // $pdf = \PDF::loadView('pdf.invoice');
        $data = collect([
            [
                'id'=>1,
                'name'=>'Posho',
                'description'=>'Posho Kids',
                'Unit Cost'=>80000,
                'Quantity'=>1,
                'Price'=>1*80000,
            ],
            [
                'id'=>2,
                'name'=>'Cooking Oil',
                'description'=>'Oil Wekfare',
                'Unit Cost'=>80000,
                'Quantity'=>3,
                'Price'=>3*80000,
            ],
            [
                'id'=>3,
                'name'=>'Fuel',
                'description'=>'Fuel Wekfare',
                'Unit Cost'=>3400,
                'Quantity'=>100,
                'Price'=>100*3400,
            ],
            ]);
            $data->toArray();

        // return $pdf->download('invoice.pdf');
        return view('pdf.invoice',compact('data'));
    }

    public function printExpense(){
        $data = request()->all();
        $uuid = request()->index1;
        $token = request()->index2;
        $invoice = Expense::find(2);
        // $invoice = Expense::where('uuid',$uuid)->where('token',$token)->first();
        // $invoice = Expense::get();
        dump($invoice);
        $date = new Carbon();
        return view('pdf.super',compact('invoice','date'));


        // $pdf = \PDF::loadView('pdf.expense-invoice',compact('invoice','date'));
        // return $pdf->setPaper('A4', 'portrait')->download('output.pdf');
        // return view('pdf.expense-reciept',compact('data'))
    }
}
