<?php

namespace App\Http\Controllers;

use App\AccCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountTypeController extends Controller
{
    public function index(Request $request)
    {

        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage')?$request->query('rowsPerPage'):15;
        if($rowsPerPage == -1){
            $rowsPerPage = AccCategory::count();
        }
        $sortRowsBy = 'name';
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
            $sortRowsBy = 'name';
        }
        $accountTypes = AccCategory::with('schoolAccounts')->orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('name','like','%'.$query.'%')->paginate($rowsPerPage);

        return response()->json(compact('accountTypes','sortRowsBy'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:acc_categories'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $accountTypes = [
                'failed'=>true,
                'message'=>$validator->errors()
            ];

            return response()->json(compact('accountTypes'));
        }

        $accountTypes = new AccCategory();

        $accountTypes->name = strtolower($request->name);
        $accountTypes->slug = str_slug($request->name);

        if($accountTypes->save()){
            $accountTypes = [
                'message'=>'saved successfully',
            ];

            return response()->json(compact('accountTypes'));
        }
        else{
            $accountTypes = [
                'message'=>'save failed',
            ];

            return response()->json(compact('accountTypes'));
        }
    }

    public function show($id)
    {
        $accountTypes = new AccCategory();
        if($accountTypes->where('id',$id)->exists()){

           $accountTypes = $accountTypes->with('schoolAccounts')->find($id);

        }
        else{
            $accountTypes = [
                'message'=>'account type not found',
            ];
        }
        return response()->json(compact('accountTypes'));
    }

    public function update(Request $request,$id)
    {

        $accountTypes = new AccCategory();
        if($accountTypes->where('id',$id)->exists())
        {
            $accountType = $accountTypes->find($id);
            $name = null;
            if(isset($request->name)){
                if($accountTypes->where('name',$request->name)->exists() && $accountType->name != $request->name){
                    $inputs = $request->all();
                    $rules = [
                        'name'=>'unique:acc_categories',
                    ];
                    $validator = Validator::make($inputs,$rules);
                    if($validator->fails()){
                        $accountTypes = [
                            'failed'=>true,
                            'message'=>$validator->errors()
                        ];

                        return response()->json(compact('accountTypes'));
                    }
                }
                else{
                    $accountType->name = isset($request->name)?strtolower($request->name):$accountType->name;
                    $accountType->slug = isset($request->name)?str_slug($request->name):$accountType->slug;
                }

            }

            $accountType->save();
            $accountType = [
                'message'=>'account type updated successfully',
            ];

        }
        else{
            $accountType = [
                'message'=>'account type not found',
            ];
        }

        return response()->json(compact('accountType'));

    }


    public function destroy($id)
    {
        $accountTypes = new AccCategory();
        if($accountTypes->where('id',$id)->exists()){

           $accountTypes = $accountTypes->with('schoolAccounts')->find($id);

            foreach ($accountTypes->schoolAccounts as $acc) {
                $acc->update([
                    'acc_category_id'=>6
                ]);
            }
            if($id >6)
            {
                $accountTypes->delete();
                $accountTypes = [
                    'message'=>'account type deleted successfully',
                ];
            }
            else{
                $accountTypes = [
                    'message'=>'account type deletion not allowed!',
                ];
            }





        }
        else{
            $accountTypes = [
                'message'=>'account type not found',
            ];
        }
        return response()->json(compact('accountTypes'));
    }
}
