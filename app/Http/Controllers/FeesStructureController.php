<?php

namespace App\Http\Controllers;

use App\Accounts\SchoolAccount;
use App\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeesStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($account_id)
    {


        $accounts = new SchoolAccount();
        $structures = new FeeStructure();
        if($accounts->where('id',$account_id)->exists())
        {
            $structures = $structures->where('school_account_id',$account_id)->paginate(10);

            return response()->json(compact('structures'));
        }
        else{
            $structures = [
                'message'=>'account not found',
            ];
            return response()->json(compact('structures'));
        }


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
    public function store(Request $request,$account_id)
    {


        $accounts = new SchoolAccount();
        $structures = new FeeStructure();
        if($accounts->where('id',$account_id)->exists())
        {
            $inputs = $request->all();
            $rules = [
                'structure_name'=>'required',
                'amount'=>'required',
            ];
            $validator = Validator::make($inputs,$rules);
            if($validator->fails()){
                $structures = [
                    'failed'=>true,
                    'message'=>$validator->errors()
                ];

                return response()->json(compact('structures'));
            }
            $structures->create(array(
                'structure_name'=>strtolower($request->structure_name),
                'amount'=>$request->amount,
                'school_account_id'=>$account_id,
            ));
            $structures = [
                'message'=>'saved successfully',
            ];

            return response()->json(compact('structures'));
        }
        else{
            $structures = [
                'message'=>'account not found',
            ];
            return response()->json(compact('structures'));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($account_id,$id)
    {
        $accounts = new SchoolAccount();
        $structures = new FeeStructure();
        if($accounts->where('id',$account_id)->exists())
        {
            if($structures->where('id',$id)->exists())
            {
                $structures = $structures->with('schoolAccount')->find($id);
            }
            else{
                $structures = [
                    'message'=>'structure not found',
                ];
            }

            return response()->json(compact('structures'));
        }
        else{
            $structures = [
                'message'=>'account not found',
            ];
            return response()->json(compact('structures'));
        }
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
    public function update(Request $request,$account_id, $id)
    {
        $accounts = new SchoolAccount();
        $structures = new FeeStructure();
        if($accounts->where('id',$account_id)->exists())
        {
            if($structures->where('id',$id)->exists())
            {
                $structures = $structures->find($id);

                $structures->structure_name = isset($request->structure_name)?strtolower($request->structure_name):$structures->structure_name;
                $structures->amount = isset($request->amount)?$request->amount:$structures->amount;
                $structures->school_account_id = isset($request->school_account_id)?$request->school_account_id:$structures->school_account_id;
                $structures->save();

                $structures = [
                    'message'=>'saved successfully',
                ];
                return response()->json(compact('structures'));
            }
            else{
                $structures = [
                    'message'=>'structure not found',
                ];
            }

            return response()->json(compact('structures'));
        }
        else{
            $structures = [
                'message'=>'account not found',
            ];
            return response()->json(compact('structures'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($account_id,$id)
    {
        $accounts = new SchoolAccount();
        $structures = new FeeStructure();
        if($accounts->where('id',$account_id)->exists())
        {
            if($structures->where('id',$id)->exists())
            {
                $structures = $structures->find($id);
                $structures->delete();

                $structures = [
                    'message'=>'deleted successfully',
                ];
                return response()->json(compact('structures'));
            }
            else{
                $structures = [
                    'message'=>'structure not found',
                ];
            }

            return response()->json(compact('structures'));
        }
        else{
            $structures = [
                'message'=>'account not found',
            ];
            return response()->json(compact('structures'));
        }
    }
}
