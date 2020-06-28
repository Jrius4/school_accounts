<?php

namespace App\Http\Controllers\Accounts;

use App\AccCategory;
use App\Accounts\SchoolAccount;
use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountantController extends BackendController
{
    public function getLoanInput(Request $request){
        $acc = AccCategory::whereName('Loans')->first()->id;
        $output = null;

       if($acc ==  $request['query']) {
           $output = '
                    <label>Loan Amount</label>
                    <input type="number" class="form-control col-12" placeholder="Enter Loan Gotten" name="amount"/>
                ';
            }
            else{
                $output = '
                    <label>Enter Amount Available</label>
                    <input type="number" class="form-control col-12" placeholder="Amount available for this account" name="amount"/>
                ';
            }
        return $output;
    }
    public function getCreateAccountForm()
    {

        $types = AccCategory::orderBy('name','asc')->get();
        return view('fianance.accountant.create-account',compact('types'));
    }

    public function storeAccountForm(Request $request)
    {
        // dd($request->all());
        $rules = array(
            'account_name'=>'required|unique:school_accounts',
            'type'=>'required'
        );

        $request->validate($rules);

        $account = new SchoolAccount();

        if(isset($request['set_minium_balance']))
        {
            $account->set_minium_balance = $request['set_minium_balance'];
        }

        if(isset($request['amount']))
        {
            $account->amount = $request['amount'];

        }

        $account->account_name = $request['account_name'];
        $account->to_pay = $request['to_pay'];
        $account->acc_category_id = $request['type'];
        $account->account_slug = ($request['account_name']!=null?str_slug($request['account_name']):null);
        if ($account->save()) {
            return redirect()->back()->with(array('message'=>'Account Created Successfully'));
        }
    }

    public function index()
    {
        $accounts = SchoolAccount::with('accCategory')->get();
        return view('fianance.accountant.all-accounts',compact('accounts'));
    }

    public function  delete($id)
    {
        // dd(request()->all());
        $acc = new SchoolAccount();
        if($id == $acc->where('account_name','Main Account')->first()->id || $id == $acc->where('account_name','School Fees')->first()->id){
            return redirect()->route('school_accounts.index')->with(['action-message'=>'out of delete zone']);
        }
        $account = SchoolAccount::findOrFail($id);
        $account->delete();

        return redirect()->route('school_accounts.index')->with(['action-message'=>'Account deleted successfully']);
    }
}
