<?php

namespace App\Http\Controllers;

use App\Accounts\SchoolAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function accountView(){
        return view("fianance.accounts.accounts_index");
    }
    public function index(Request $request)
    {
        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage')!==null?$request->query('rowsPerPage'):5;
        $rowsPerPage = $request->query('rowsPerPage')==-1?SchoolAccount::count():$request->query('rowsPerPage');
        $sortRowsBy = 'account_name';
        $sortDesc = false;
        if(isset($request['sortDesc']) && $request['sortDesc'] !== '' ){
            $sortDesc = $request['sortDesc'] == 'true'?true:false;
        }
        else{
            $sortDesc = false;
        }
        if(isset($request['sortRowsBy']) && $request['sortRowsBy']!==''){
            $sortRowsBy = $request['sortRowsBy'];
        }
        else{
            $sortRowsBy = 'account_name';
        }
        $accounts = SchoolAccount::with('feeStructures','accCategory')->orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('account_name','like','%'.$query.'%')->orWhere('amount','like','%'.$query.'%')->paginate($rowsPerPage);

        return response()->json(compact('accounts'));
    }

    public function store(Request $request)
    {
        $rules = [
            'account_name'=>'required|unique:school_accounts'
        ];

        $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                $accounts = [
                    'failed'=>true,
                    'message'=>$validator->errors()
                ];

                return response()->json(compact('accounts'));
            }

        $accounts = new SchoolAccount();
        $accounts->account_name = strtolower($request->account_name);
        $accounts->account_slug = str_slug($request->account_name);
        $accounts->acc_category_id = $request->acc_category_id;
        $accounts->amount = $request->amount;
        $accounts->set_minium_balance = $request->set_minium_balance;

        if($accounts->save()){
            $accounts = [
                'message'=>'saved successfully',
            ];
            return response()->json(compact('accounts'));
        }
    }

    public function show($id)
    {
        $accounts = new SchoolAccount();
        if($accounts->where('id',$id)->exists())
        {
            $accounts = $accounts->find($id);

        }
        else{
            $accounts = [
                'message'=>'account not found',
            ];
        }

        return response()->json(compact('accounts'));
    }

    public function update(Request $request,$id)
    {
        $accounts = new SchoolAccount();
        if($accounts->where('id',$id)->exists())
        {
            $account = $accounts->find($id);
            $account_name = null;
            if(isset($request->account_name)){
                if($accounts->where('account_name',$request->account_name)->exists() && $account->account_name != $request->account_name){
                    $inputs = $request->all();
                    $rules = [
                        'account_name'=>'unique:school_accounts',
                    ];
                    $validator = Validator::make($inputs,$rules);
                    if($validator->fails()){
                        $accounts = [
                            'failed'=>true,
                            'message'=>$validator->errors()
                        ];

                        return response()->json(compact('accounts'));
                    }
                }
                else{
                    $account->account_name = isset($request->account_name)?$request->account_name:$account->account_name;
                    $account->account_slug = isset($request->account_name)?str_slug($request->account_name):$account->account_slug;
                }

            }

            $account->acc_category_id = isset($request->acc_category_id)?$request->acc_category_id:$account->acc_category_id;
            $account->amount = isset($request->amount)?$request->amount:$account->amount;
            $account->set_minium_balance = isset($request->set_minium_balance)?$request->set_minium_balance:$account->set_minium_balance;
            $account->save();
            $account = [
                'message'=>'account updated successfully',
            ];

        }
        else{
            $account = [
                'message'=>'account not found',
            ];
        }

        return response()->json(compact('account'));
    }

    public function destroy($id)
    {
        $accounts = new SchoolAccount();
        if($accounts->where('id',$id)->exists())
        {
            $accounts = $accounts->find($id);
            if($id >7)
            {
                $accounts->delete();
                $accounts = [
                    'message'=>'account deleted successfully',
                ];
            }
            else{
                $accounts = [
                    'message'=>'account deletion not allowed!',
                ];
            }

        }
        else{
            $accounts = [
                'message'=>'account not found',
            ];
        }

        return response()->json(compact('accounts'));
    }

}
