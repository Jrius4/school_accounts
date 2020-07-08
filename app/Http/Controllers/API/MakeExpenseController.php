<?php

namespace App\Http\Controllers\API;

use App\Accounts\SchoolAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExpenseInput;
use App\Expense;
use App\Http\Resources\AccountResource;
use App\Http\Resources\ExpenseInputCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

class MakeExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exp = new ExpenseInput();
        $expenseItems = $exp->get();
        $totalItems = $exp->expenseTotal();

        return response()->json(compact('expenseItems','totalItems'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name'=>'required',
            'quantity'=>'required',
            'units'=>'required',
            'rate'=>'required',
        );
        $exp = new ExpenseInput();

        $validate = Validator::make($request->all(),$rules);
        if($validate->fails())
        {
            return response()->json(['errors'=>$validate->messages()],403);
        }
        $data = $request->all();
        $exp->create(array(
            'name'=>$data['name'],
            'quantity'=>$data['quantity'],
            'units'=>$data['units'],
            'rate'=>$data['rate'],
            'description'=>$data['description'],
            'amount'=>$data['quantity']*$data['rate'],
        ));
        $expenseItems = $exp->get()->last();
        $totalItems = $exp->expenseTotal();

        return response()->json(compact('expenseItems','totalItems'),$status=201);


        // return new ExpenseInputCollection($expenses->get()->last(),$totalItems);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenseInput = ExpenseInput::findOrFail($id);
        return new ExpenseInputCollection($expenseInput);
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
        $rules = array(
            'name'=>'required',
            'quantity'=>'required',
            'units'=>'required',
            'rate'=>'required',
        );
        $expenses = ExpenseInput::findOrFail($id);

        $validate = Validator::make($request->all(),$rules);
        if($validate->fails())
        {
            return response()->json(['errors'=>$validate->messages()],403);
        }
        $data = $request->all();
        $expenses->update(array(
            'name'=>$data['name'],
            'quantity'=>$data['quantity'],
            'units'=>$data['units'],
            'rate'=>$data['rate'],
            'amount'=>$data['quantity']*$data['rate'],
        ));
        $exp = new ExpenseInput();
        $totalItems = $exp->expenseTotal();
        $expenseItems = $expenses;

        return response()->json(compact('expenseItems','totalItems'),$status=201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expenseInput = ExpenseInput::findOrFail($id);
        $expenseInput->delete();
        $message = "deleted item successfully";
        $exp = new ExpenseInput();
        $totalItems = $exp->expenseTotal();

        return response()->json(compact('message','totalItems'),202);
    }

    public function storeExpense(Request $request){
        DB::table('expense_inputs')->truncate();
        // DB::table('expenses')->insert([
        //     [
        //         'borrowDetails'=>json_encode($request['borrowDetails'],true),
        //         'expenseItems'=>json_encode($request['expenseItems'],true),
        //         'makeBorrowItems'=>json_encode($request['makeBorrowItems'],true),
        //         'expenseInfo'=>json_encode($request['expenseInfo'],true),
        //         'expenseTotal'=>$request['expenseTotal'],
        //         'user_id'=>auth()->user()->id,
        //         'created_at'=>date('Y-m-d H:i:s'),
        //         'updated_at'=>date('Y-m-d H:i:s'),
        //     ]
        // ]);
        // return $request->all();
        $expense = $request->all();
        $date = new Carbon();
        $date2 = $date->now();
        $token =  strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y'));
        $expenseData = new Expense();
            $uuid = Str::uuid();
            $expenseData->uuid = $uuid;
            $expenseData->token= $token;
            $expenseData->expensetype = $request->ExpenseType;
            $expenseData->overview = $request->overview;
            $expenseData->requested_by = $request->requested_by;
            $expenseData->expenseTerm = json_encode($request->expenseTerm,true);
            $expenseData->expenseTotal = $request->expenseTotal;
            $expenseData->makeBorrowItems = json_encode($request->makeBorrowItems,true);
            $expenseData->makeLoanBorrowItems = json_encode($request->makeLoanBorrowItems,true);
            $expenseData->salaryPaymentType = $request->salaryPaymentType;
            $expenseData->salaryTerm = json_encode($request->salaryTerm,true);
            $expenseData->totalBorrow = json_encode($request->totalBorrow,true);
            $expenseData->totalBorrowLoan = json_encode($request->totalBorrowLoan,true);
            $expenseData->worker = json_encode($request->worker,true);
            $expenseData->expenseItems = json_encode($request->expenseItems,true);
            $expenseData->user_id=auth()->user()->id;


            $exp = null;
            if($expenseData->save())
            {
                $exp = $expenseData->get();
            }
            else{
                $exp = 'failed';
            }

        dump($exp);
        $data = $exp->where('uuid',$uuid)->where('token',$token)->first();

        return response()->json(['expense'=>$data]);
    }

    public function fetchAccounts(Request $request){
        // if(isset($request->term) || isset($request->account)){
            // return $request->all();
        // }
        if(isset($request->accBorrow) && $request->accBorrow == 'true' && $request->account!==''){
            if(Auth::user()->hasRole('burser') || Auth::user()->hasRole('accountant') ){
                $accounts = SchoolAccount::where('id','>',1)->where('acc_category_id','!=',2)->where('account_name','!=',$request->account)->get();

                return AccountResource::collection($accounts);
            }
        }
        else if(isset($request->accBorrow) && $request->accBorrow == 'false' ){
            if(Auth::user()->hasRole('burser') || Auth::user()->hasRole('accountant') ){
                $accounts = SchoolAccount::where('id','>',1)->where('acc_category_id','!=',2)->get();

                return AccountResource::collection($accounts);
            }
        }

        else{
            return response()->json('authorizes',401);
        }

    }

    public function fetchLoanAccounts(){
        if(Auth::user()->hasRole('burser') || Auth::user()->hasRole('accountant') ){
            $accounts = SchoolAccount::where('acc_category_id',2)->get();

            return AccountResource::collection($accounts);
        }
        else{
            return response()->json('authorizes',401);
        }
    }
}
