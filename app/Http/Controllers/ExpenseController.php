<?php

namespace App\Http\Controllers;

use App\AccCategory;
use App\Accounts\Outflow;
use App\Accounts\OutflowCategory;
use App\Accounts\SchoolAccount;
use App\ExpenseInput;
use App\Http\Controllers\Backend\BackendController;
use App\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends BackendController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchItems()
    {
        $expenses = ExpenseInput::latest()->get();

        $output2 = "";

        $output2.='
        <div class"row container d-flex jusity-content-center col-md-12 card table table-responsive">
        <table class="table table-striped table-head-fixed text-nowrap form-group col-12">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Item</th>
                        <th></th>
                        <th>Quantity</th>
                        <th></th>
                        <th>Units</th>
                        <th></th>
                        <th>Rate</th>
                        <th></th>
                        <th>Amount</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';

                if($expenses->count()>0)
                {
                    $num=0;
                    $total=0;
                    foreach ($expenses as $row)
                    {
                        $num+=1;
                            $output2.='
                            <tr>
                                <td>'.str_slug($num).'<input type="hidden" value="'.str_slug($num).'" name="id" id="'.str_slug($num).'" /></td>
                                <td>'.$row->name.'<input type="hidden" value="'.$row->name.'" name="name-'.str_slug($num).'" id="name-'.str_slug($num).'" /><td/>
                                <td>'.$row->quantity.'<input type="hidden" value="'.$row->quantity.'" name="quantity-'.str_slug($num).'" id="quantity-'.str_slug($num).'" /><td/>
                                <td>'.$row->units.'<input type="hidden" value="'.$row->units.'" name="units-'.str_slug($num).'" id="units-'.str_slug($num).'" /><td/>
                                <td>'.$row->rate.'<input type="hidden" value="'.$row->rate.'" name="rate-'.str_slug($num).'" id="rate-'.str_slug($num).'" /><td/>
                                <td>'.$row->amount.'<input type="hidden" value="'.$row->amount.'" name="amount-'.str_slug($num).'" id="amount-'.str_slug($num).'" /><td/>
                                <td>
                                <form action="'.route('remove-item').'" method="POST">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <input type="hidden" name="id" value="'.$row->id.'">

                                    <button class="btn btn-xs btn-danger" '.($num==1?' type="button" id="removeListItem-1" onclick="removeList('.$row->id.')"':' type="submit" onclick="return confirm(`Are you sure?`);"').'>
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                                </td>
                            </tr>

                            ';
                            $total+=$row->amount;



                    }

                    $output2.='
                                <tr class="bg-dark">
                                    <td>Total:</td>
                                    <td colspan="2">'.$total.'<input type="hidden" value="'.$total.'" name="grand-total" id="grand-total" /></td>
                                </tr>
                            </tbody>
                    </table>
                        ';
                        $output2.='<input type="hidden" name="num_items" value="'.str_slug($num).'" id="num_items-'.str_slug($num).'" />

                    </div>
                        ';
                }


            return $output2;

    }

    public function getForm(Request $request)
    {
        $rules = [
            'query'=>'required',
            'item'=>'required',
            'quantity'=>'required',
            // 'units'=>'required',
            'rate'=>'required',
        ];
        $request->validate($rules);
        $expenses = new ExpenseInput();
        $output = "";
        $output2 = "";

        $expenses->create(array(
            'name'=>$request['item'],
            'quantity'=>$request['quantity'],
            'units'=>$request['units'],
            'rate'=>$request['rate'],
            'amount'=>$request['quantity']*$request['rate'],
        ));

        $output2.='
        <div class"row container d-flex jusity-content-center col-12">
        <table class="table table-striped table-head-fixed text-nowrap form-group col-12" style="width:50% !important">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Item</th>
                        <th></th>
                        <th>Quantity</th>
                        <th></th>
                        <th>Units</th>
                        <th></th>
                        <th>Rate</th>
                        <th></th>
                        <th>Amount</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
                $items = $expenses->latest()->get();
            if($items->count()>0)
            {
                $num=0;
                $total=0;
                foreach ($items as $row)
                {
                    $num+=1;
                    $output2.='
                    <tr>
                        <td>'.str_slug($num).'<input type="hidden" value="'.str_slug($num).'" name="id" id="'.str_slug($num).'" /></td>
                        <td>'.$row->name.'<input type="hidden" value="'.$row->name.'" name="name-'.str_slug($num).'" id="name-'.str_slug($num).'" /><td/>
                        <td>'.$row->quantity.'<input type="hidden" value="'.$row->quantity.'" name="quantity-'.str_slug($num).'" id="quantity-'.str_slug($num).'" /><td/>
                        <td>'.$row->units.'<input type="hidden" value="'.$row->units.'" name="units-'.str_slug($num).'" id="units-'.str_slug($num).'" /><td/>
                        <td>'.$row->rate.'<input type="hidden" value="'.$row->rate.'" name="rate-'.str_slug($num).'" id="rate-'.str_slug($num).'" /><td/>
                        <td>'.$row->amount.'<input type="hidden" value="'.$row->amount.'" name="amount-'.str_slug($num).'" id="amount-'.str_slug($num).'" /><td/>
                        <td>
                        <form action="'.route('remove-item').'" method="POST" style="border:4px red solid;">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="id" value="'.$row->id.'">

                            <button class="btn btn-xs btn-danger" '.($num==1?' type="button" id="removeListItem-1" onclick="removeList('.$row->id.')"':' type="submit" onclick="return confirm(`Are you sure?`);"').'>
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                        </td>
                    </tr>

                    ';
                        $total+=$row->amount;
                }

                $output2.='
                    <tr class="bg-dark">
                        <td>Total:</td>
                        <td colspan="2">'.$total.'<input type="hidden" value="'.$total.'" name="grand-total" id="grand-total" /></td>
                    </tr>
                </tbody>
        </table>
        </div>
        ';
        $output2.='<input type="hidden" name="num_items" value="'.str_slug($num).'" id="num_items-'.str_slug($num).'" />';
            }

            $output.='
                <td>
                    <input type="text" id="item"  name="item" class="item form-control col-12 d-block" placeholder="enter new item"/>
                </td>
                <td>
                    <input type="text" id="quantity" name="quantity" class="quantity form-control col-12 d-block"/>
                </td>
                <td>
                    <input type="text" id="units" name="units" class="units form-control col-12 d-block"/>
                </td>
                <td>
                    <input type="text" id="rate"  name="rate" class="rate form-control col-12 d-block"/>
                </td>
            ';
        return compact('output','output2');
    }



    public function getBorrow(Request $request)
    {

        $res = $request->all();
        $acc = SchoolAccount::findOrFail($res['acc_category']);
        $other_acc = SchoolAccount::where('id','!=',$res['acc_category'])->where('id','!=',1)->get();
        $output = "";
        $expInput = new ExpenseInput();
        $accId = $acc->id;

        if($res['grand_total']>$acc->amount)
        {
            $output.='
                <div class="row container d-flex justify-content-center col-lg-12">
                    <table class="table mx-auto col-12">
                        <thead>
                            <th colspan="2" class="text-center">Account Balance is less</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Account Name</td>
                                <td>'.$acc->account_name.'</td>
                            </tr>
                            <tr>
                                <td>Available</td>
                                <td>'.$acc->amount.'</td>
                            </tr>
                            <tr>
                                <td>Requested</td>
                                <td>'.$res['grand_total'].'</td>
                            </tr>
                            <tr>
                                <td>Remaining</td>
                                <td>'.($acc->amount-$res['grand_total']).'<input type="hidden" id="remain" value="'.($acc->amount-$res['grand_total']).'"/></td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <div class="container row d-flex justify-content-center col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width:100%">

                    <div class="col-md-4 mx-auto">
                        <h5>Other Accounts<h5/>
                        <table class="table table-light table-striped table-hover elevation-2">
                            <thead>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Balance</th>
                            </thead>
                            <tbody>';

                            foreach($other_acc as $row)
                            {

                                $output.="
                                <tr id='".$row->account_slug."' class='rowAction' onclick='tableRowClick(`".$row->account_slug."`,".$row->amount.",".$accId.")'>
                                    <td>".$row->id."</td>
                                    <td>".$row->account_name."</td>
                                    <td>".$row->amount."</td>
                                </tr>
                                ";
                            }

                           $output .= '</tbody>
                        </table>
                    </div>
                    <div id="BorrowAcc" class="row m-0 col-12"  style="width:50%;display:flex;justify-content:center"></div>
                </div>
            ';
        }

        // return $output;
        return response()->json(compact('output','accId'));
    }

    public function getBorrowInput(Request $request)
    {
        $inputs = $request['arrOut'];
        $inputBorrow = $request['arrBorrow'];
        $acc = new SchoolAccount();
        $output = "";
        $expInput = ExpenseInput::get();
        $total=0;
        // return $inputBorrow;
        foreach($expInput as $row){
            $total+=$row->amount;
        }
        $output.='<div class="" style="width:100%">
                        <h5>Borrowing<h5/>
                        <h6>Amount: <small id="coll-amount">';
                        if(isset($inputBorrow))
                        {
                            $output.=(isset($inputBorrow[0])?$inputBorrow[0]['collected']:'');
                        }
                        else{
                            $output.=' 0';
                        }
                        $output.='/=</small></h6>
                        <h6>Balance: <small id="coll-remain">';
                        if(isset($inputBorrow)){
                            $output.=(isset($inputBorrow[0])?$inputBorrow[0]['remain']:'');
                        }
                        else{
                           $output.=(isset($inputs[0]['selected'])?($acc->find($inputs[0]['selected'])->amount-$total):'');
                        }

                        $output.=' /=</small></h6>
                        <table class="table elevation-2 col-sm-12">
                            <thead>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Balance</th>
                            </thead>
                            <tbody>';
                            $i=0;



                            foreach($inputs as $row)
                            {

                                if(isset($row['selected']))
                                {
                                    $selectedAcc = $acc->find($row['selected']);
                                    $output.="
                                    <tr>
                                        <td colspan='4'>
                                            <input type='text' disabled name='remaining' id='remaining' value='".(isset($row['selected'])?($selectedAcc->amount-$total):"noth")."' class='form-control col-12 d-block'/>
                                        </td>
                                    </tr>
                                    ";
                                }

                                if(!isset($row['selected'])){
                                    ++$i;
                                    $output.="

                                    <tr style='background-color:".($i%2?'#dcdcdc':'#efefef')."'>
                                        <td rowspan='2'>".$i."</td>
                                        <td rowspan='2'>".$acc->where('account_slug',$row['name'])->first()->account_name."</td>
                                        <td>Available:</td>
                                        <td>".$row['amount']."</td>
                                    </tr>
                                    <tr style='background-color:".($i%2?'#dcdcdc':'#efefef')."'>
                                        <td>Borrow: </td>
                                        <td>
                                            <div class='d-none' id='inform-".$i."'></div>
                                            <input id='borrow-".$i."' class='form-control  d-block col-12'/>
                                            <a onclick='addBorrow("."`".$row['name']."`".",".$row['amount'].",".$i.")' class='text-light btn btn-sm btn-primary btn-block col-12'><i class='fa fa-plus'></i> Add</a>
                                        </td>
                                    </tr>
                                ";
                                }

                            }

                           $output .= '</tbody>
                        </table>
                    </div>';
        return $output;
    }

    public function deleteItem(Request $request){
        $item = ExpenseInput::findOrFail($request->id);
        $item->delete();

        return redirect()->back()->with(['message'=>'Item removed']);
    }
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
        $terms = Term::get();
        $items = ExpenseInput::latest()->get();
        $cats = SchoolAccount::where('id','!=',1)->latest()->get();
        return view('fianance.expenses.make-expense',compact('terms','cats','items'));
    }

    public function addItem()
    {

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
            'category'=>'required',
            'term'=>'required',
            'requested_by'=>'required',
            'category'=>'required',
        );

        $request->validate($rules);
        dd($request->all());

        if(isset($request['num_items']))
        {
            $outflow = new Outflow();
            $arr = [];
            $arr2 = [];
            $arrMajor=[];
            $amountAll = 0;
            $number_items=$request['num_items'];
            for ($i=1; $i <= $number_items ; $i++) {
                $arr2 = array(
                    "name"=>$request['name-'.$i],
                    "quantity"=>$request['quantity-'.$i],
                    "units"=>$request['units-'.$i],
                    "rate"=>$request['rate-'.$i],
                    "amount"=>$request['amount-'.$i],
                );
                array_push($arr,$arr2);
                $amountAll+=$request['amount-'.$i];

            }
            $str_request = (json_encode($arr,true));
            $arr3 = array(
                'made_by'=>$request['requested_by'],
                'term_id'=>$request['term'],
                'outflow_category_id'=>$request['category'],
                'description'=>$str_request,
                'total'=>$amountAll,
                'message'=>$request['description']
            );

            $outflow->create($arr3);

            DB::table('expense_inputs')->truncate();

            return redirect()->back()->with(['message'=>'Expense Made Successfully']);

        }

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
