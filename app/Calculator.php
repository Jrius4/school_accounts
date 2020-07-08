<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Calculator {

    public function expense()
    {
        $date = new Carbon();
        $date2 = $date->now();
        $input = [
            'uuid'=>Str::uuid(),
            'token'=>strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
            'AccountSpendFrom'=>"School Fees",
            'expensetype'=>'Salary',
            'expenseItems'=>null,
            'requested_by'=>'Odeka Samuel',
            'overview'=>'Salary expenses paid',
            'expenseTerm'=>1,
            'expenseTotal'=>650000,
            'makeBorrowItems'=>json_encode([
                'credit'=>200000,
                'selectedAccount'=>[
                    'balance'=>"450080000",
                    'id'=>2,
                    "name"=>"Construction Loan"
                ]],true),
                'makeLoanBorrowItems'=>json_encode([
                'credit'=>78800,
               'selectedAccount'=>[
                    'balance'=>"8080000",
                    'id'=>4,
                    "name"=>"Development Fees"
                ]],true),
            'salaryPaymentType'=>'Normal',
            'salaryTerm'=>json_encode(['id'=>1,'name'=>'Term 1'],true),
            'totalBorrow'=>178800,
            'totalBorrowLoan'=>200000,
            'worker'=>json_encode([
                "id"=>13,
                "name"=>"Odeka Samuel",
                "roles"=>json_encode(Role::find([7])->toArray(),true),
                "username"=>"samuel",
                "wage_salary"=>800000
            ],true),
            'user_id'=>8,
        ];

        return $input;
    }
}