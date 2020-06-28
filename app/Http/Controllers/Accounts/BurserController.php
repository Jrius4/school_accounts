<?php

namespace App\Http\Controllers\Accounts;

use App\AccCategory;
use App\Accounts\SchoolAccount;
use App\ClassFee;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Payment;
use App\StudentFee;
use App\Term;

class BurserController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function studentPaymentGet()
    {
        $studentAcctypes = AccCategory::whereName('student')->first()->schoolAccounts()->orderBy('account_name','asc')->get();
        $students = Student::orderBy('name','asc')->get();
        $terms = Term::orderBy('id','asc')->get();
        return view('fianance.burser.student-payments',compact('studentAcctypes','students','terms'));
    }

    public function studentPaymentPost(Request $request)
    {
        // dd($request->all());
        $rules = [
            'student_name'=>'required|nullable',
            'paid_by'=>'required|nullable',
            'term'=>'required|nullable',
        ];
        $request->validate($rules);
        // dd($request->all());
        $student = Student::findOrFail($request['student_name']);
        $payment_array = [];
        $payments = new Payment();
        $payments->student_id = $request['student_name'];
        $payments->term_id = $request['term'];
        $payments->paid_by = $request['paid_by'];
        $acc = AccCategory::whereName('Student')->first()->schoolAccounts()->get();
        $accMain = AccCategory::whereName('Main Account')->first()->schoolAccounts()->get();
        // dd($student);
        foreach ($acc as $row)
        {
            if($request[$row->account_slug]!=null)
            {
                array_push($payment_array,[$row->account_slug=>$request[$row->account_slug]]);
                $amount = $acc->where('account_slug',$row->account_slug)->first()->amount;

                $acc->where('account_slug',$row->account_slug)->first()->update(array('amount'=>($amount+$request[$row->account_slug])));
                $accMain->where('account_name','Main Account')->first()->update(array('amount'=>($amount+$request[$row->account_slug])));
            }

        }

        if(isset($request['balance'])){
            array_push($payment_array,['balance'=>$request['balance']]);
            $amount = $acc->where('account_name','School Fees')->first()->amount;
            $acc->where('account_name','School Fees')->first()->update(array('amount'=>($amount+$request['balance'])));
            $accMain->where('account_name','Main Account')->first()->update(array('amount'=>($amount+$request['balance'])));

        }

        // dd($payment_array);

        $payment_str = json_encode($payment_array,true);
        $payments->fees = $payment_str;
        if($payments->save())
        {
            $to_pay = $student->fees_to_be_paid;

            $fees = StudentFee::where('student_id',$request['student_name'])->where('year',date('Y'))->get();

            if($fees->count()>0)
            {
                // dd('addition payment');
                $makeFees = new StudentFee();

                $test_array = [];
                foreach ($acc as $row)
                {


                    if($request[$row->account_slug]!=null)
                    {
                        // array_push($test_array,[$row->account_slug=>$request[$row->account_slug]]);

                        if($makeFees->where('student_id',$request['student_name'])->where('fees',$row->account_name)->where('term_id',$request['term'])->where('year',date('Y'))->count()>0)
                        {
                            // dd('something');
                            $newFees = $makeFees->where('student_id',$request['student_name'])->where('fees',$row->account_name)->where('term_id',$request['term'])->where('year',date('Y'))->first();
                            // dd($newFees);
                            // $makeFees = $makeFees->where('student_id',$request['student_name'])->where('fees',$request[$row->account_slug])->where('term_id',$request['term'])->where('year',date('Y'))->first();
                            $feez = $newFees->paid;
                            array_push($test_array,$newFees);

                            // array_push($test_array,array(
                            $newFees->update(array(
                                'student_id'=>$request['student_name'],
                                'fees'=>$row->account_name,
                                'to_pay'=>($row->account_slug=='school-fees'?$student->fees_to_be_paid:$row->to_pay),
                                'paid'=>$feez+$request[$row->account_slug],
                                'year'=>date('Y'),
                                'term_id'=>$request['term']
                            ));


                            if($row->account_slug=='school-fees')
                            {
                            $feez = $newFees->paid;
                               $student->update(array(
                                    'amount_paid'=>$feez+$request[$row->account_slug]
                                ));
                            }




                        }
                        else{
                            array_push($test_array,'false');
                        }

                    }

                }
                // dd(json_encode($test_array,true));
            }
            if($fees->count()==0)
            {
                $makeFees = new StudentFee();


                    foreach ($acc as $row)
                    {
                        if($request[$row->account_slug]!=null)
                        {
                            // if($makeFees->where('student_id',$request['student_name'])->where('fees',$request[$row->account_slug])->where('year',date('Y'))->count()==0)
                            // {
                                $makeFees->create(array(
                                    'student_id'=>$request['student_name'],
                                    'fees'=>$row->account_name,
                                    'to_pay'=>($row->account_slug=='school-fees'?$student->fees_to_be_paid:$row->to_pay),
                                    'paid'=>$request[$row->account_slug],
                                    'year'=>date('Y'),
                                    'term_id'=>$request['term']
                                ));
                            // }
                        }

                    }
            }
            return redirect()->back()->with(['message'=>'payment saved']);
        }





    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function allStudentsPayment()
    {
        $studFees = StudentFee::get()->groupBy('student_id');

        return view('fianance.burser.all-student-payments',compact('studFees'));
    }
    public function store(Request $request)
    {
        $rules = array(
            'class'=>'required',
            'fees_amount'=>'required|integer'
        );
        $request->validate($rules);

        $fees = ClassFee::where('schclass_id',$request['class'])->first()->update(array('fees_amount'=>$request['fees_amount']));

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
