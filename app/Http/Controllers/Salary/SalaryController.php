<?php

namespace App\Http\Controllers\Salary;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendController;
use App\User;

class SalaryController extends BackendController
{
    public function employeeSalary(){
        return view('head-teacher.Salary-index');
    }
    public function getEmployees(Request $request)
    {
        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage');
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
        $employees = User::with('roles')->select(['id','username','name','wage_salary','wage_paid','wage_upfront','wage_loan','wage_balance','image'])->orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('name','like','%'.$query.'%')->orWhere('username','like','%'.$query.'%')->paginate($rowsPerPage);

        return response()->json($employees);
    }
    public function saveEmployee(Request $request){

        $setSalary = $request['setSalary'];
        $worker_id = $request['worker_id'];
        $worker_salary = $request['worker_salary'];
        $user = null;

        if($setSalary){
            if(isset($worker_id)){
                $user = User::with('roles')->find($worker_id);
                $user->update([
                    'wage_salary'=>$worker_salary,
                ]);

                $user = $user;

            }
        }
        return compact('user');
    }
}
