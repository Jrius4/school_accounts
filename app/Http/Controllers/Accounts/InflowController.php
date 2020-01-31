<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Inflow;
use App\Accounts\SchoolAccount;
use App\Accounts\Transaction;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InflowController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inflows = Inflow::orderBy('created_at','asc')->get();
        return view('manage-inflows.index',compact('inflows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inflow $inflow)
    {
        return view('manage-inflows.create', compact('inflow'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $account = SchoolAccount::findOrFail(1);
        $acc_balance = $account->amount + $data['amount'];

        Inflow::create($data);
        DB::table('transactions')->insert([
            [
                'source_identifier' => 'std_'.$data['source_identifier'],
                'destination_identifier' => null,
                'amount' => $data['amount'],
                'created_at'=>now(),
                'updated_at'=>now(),

            ]

        ]);
        DB::update('update school_accounts set amount = :acc_bal where id =1',['acc_bal'=>$acc_balance]);

        return redirect('/dashboard');
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
