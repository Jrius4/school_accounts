<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Outflow;
use App\Accounts\SchoolAccount;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OutflowController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outflows= Outflow::orderBy('created_at','asc')->get();
        return view('manage-outflows.index',compact('outflows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Outflow $outflow)
    {
        return view('manage-outflows.create', compact('outflow'));
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
        if ($account->amount<20000) {
            dd('less account balance');
        } else {
            $acc_balance = $account->amount - $data['amount'];
        }





        $newOutflow = Outflow::create($data);
        $newOutflow->createTags($data["expense_tags"]);
        DB::table('transactions')->insert([
            [
                'source_identifier' => null,
                'destination_identifier' => 'exp_'.$data['destination_identifier'],
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
