<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Role;

class IncomeStatementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new Carbon();
        $date2 = $date->now();
        DB::table('expenses')->insert([
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>'Salary',
                'expenseItems'=>null,
                'requested_by'=>'Eng Kazibwe Julius Jr',
                'overview'=>'Contract payment',
                'expenseTerm'=>2,
                'expenseTotal'=>5000000,
                'makeBorrowItems'=>null,
                'makeLoanBorrowItems'=>null,
                'salaryPaymentType'=>'Normal',
                'salaryTerm'=>json_encode(['id'=>1,'name'=>'Term 1'],true),
                'totalBorrow'=>null,
                'totalBorrowLoan'=>null,
                'worker'=>null,
                'user_id'=>8,
                'created_at'=>$date->parse("2018-07-03 17:27:18"),
                'updated_at'=>$date->parse("2018-07-03 17:27:18")
            ],
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>'Salary',
                'expenseItems'=>null,
                'requested_by'=>'Eng Kazibwe Julius Jr',
                'overview'=>'Contract payment',
                'expenseTerm'=>2,
                'expenseTotal'=>25000000,
                'makeBorrowItems'=>json_encode([
                    [
                        'credit'=>24500000,
                        'selectedAccount'=>[
                            'balance'=>"450080000",
                            'id'=>2,
                            "name"=>"Construction Loan"
                        ]
                    ]],true),
                    'makeLoanBorrowItems'=>json_encode([
                    ['credit'=>500000,
                   'selectedAccount'=>[
                        'balance'=>"8080000",
                        'id'=>4,
                        "name"=>"Development Fees"
                    ]]],true),
                'salaryPaymentType'=>'Normal',
                'salaryTerm'=>json_encode(['id'=>1,'name'=>'Term 1'],true),
                'totalBorrow'=>178800,
                'totalBorrowLoan'=>200000,
                'worker'=>null,
                'user_id'=>8,
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-30 weeks'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-29 weeks')
            ],
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>'Salary',
                'expenseItems'=>null,
                'requested_by'=>'Odeka Samuel',
                'overview'=>'Salary expenses paid',
                'expenseTerm'=>1,
                'expenseTotal'=>650000,
                'makeBorrowItems'=>json_encode([
                    ['credit'=>200000,
                    'selectedAccount'=>[
                        'balance'=>"450080000",
                        'id'=>2,
                        "name"=>"Construction Loan"
                    ]]],true),
                    'makeLoanBorrowItems'=>json_encode([
                    ['credit'=>78800,
                   'selectedAccount'=>[
                        'balance'=>"8080000",
                        'id'=>4,
                        "name"=>"Development Fees"
                    ]]],true),
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
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-45 days'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-8 days')
            ],
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>"Welfare",
                'expenseItems'=>json_encode([
                    ['amount'=>"1080000",
                    'created_at'=>"2020-07-06 17:27:18",
                    'description'=>"Party Meat",
                    'id'=>1,
                    'name'=>"meat",
                    'quantity'=>"90",
                    'rate'=>"12000",
                    'units'=>"kg",
                    'updated_at'=>"2020-07-06 17:27:18"]
                ],true),
                'requested_by'=>'School Chef',
                'overview'=>'Students welfare',
                'expenseTerm'=>1,
                'expenseTotal'=>1080000,
                'makeBorrowItems'=>json_encode([
                    ['credit'=>200000,
                    'selectedAccount'=>[
                        'balance'=>"450080000",
                        'id'=>2,
                        "name"=>"Construction Loan"
                    ]]],true),
                    'makeLoanBorrowItems'=>json_encode([
                    ['credit'=>78800,
                   'selectedAccount'=>[
                        'balance'=>"8080000",
                        'id'=>4,
                        "name"=>"Development Fees"
                    ]]],true),
                'salaryPaymentType'=>null,
                'salaryTerm'=>null,
                'totalBorrow'=>178800,
                'totalBorrowLoan'=>200000,
                'worker'=>null,
                'user_id'=>8,
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-18 days'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-6 days')
            ],
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>"Welfare",
                'expenseItems'=>json_encode([
                    ['amount'=>"1080000",
                    'created_at'=>"2020-07-06 17:27:18",
                    'description'=>"Party Meat",
                    'id'=>1,
                    'name'=>"meat",
                    'quantity'=>"90",
                    'rate'=>"12000",
                    'units'=>"kg",
                    'updated_at'=>"2020-07-06 17:27:18"]
                ],true),
                'requested_by'=>'School Chef',
                'overview'=>'Students welfare',
                'expenseTerm'=>1,
                'expenseTotal'=>300000,
                'makeBorrowItems'=>null,
                'makeLoanBorrowItems'=>null,
                'salaryPaymentType'=>null,
                'salaryTerm'=>null,
                'totalBorrow'=>null,
                'totalBorrowLoan'=>null,
                'worker'=>null,
                'user_id'=>8,
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-3 days'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-3 days')
            ],
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>"Welfare",
                'expenseItems'=>json_encode([
                    [
                        'amount'=>"540000",
                        'created_at'=>"2020-07-06 17:27:18",
                        'description'=>"Posho student welfare",
                        'id'=>1,
                        'name'=>"posho",
                        'quantity'=>"250",
                        'rate'=>"1200",
                        'units'=>"kg",
                        'updated_at'=>"2020-07-06 17:27:18"
                    ],
                    [
                        'amount'=>"4300000",
                        'created_at'=>"2020-07-06 17:27:18",
                        'description'=>"fuel",
                        'id'=>1,
                        'name'=>"ltrs",
                        'quantity'=>"80",
                        'rate'=>"3400",
                        'units'=>"kg",
                        'updated_at'=>"2020-07-06 17:27:18"
                    ],
                ],true),
                'requested_by'=>'Mr.Kigudu',
                'overview'=>'Students welfare',
                'expenseTerm'=>1,
                'expenseTotal'=>2504500,
                'makeBorrowItems'=>null,
                'makeLoanBorrowItems'=>null,
                'salaryPaymentType'=>null,
                'salaryTerm'=>null,
                'totalBorrow'=>null,
                'totalBorrowLoan'=>null,
                'worker'=>null,
                'user_id'=>8,
                'created_at'=>$date->parse("2020-07-18 18:27:18")->modify('-1 days'),
                'updated_at'=>$date->parse("2020-07-18 18:27:18")->modify('-1 days')
            ],
            [
                'uuid'=>Str::uuid(),
                'token'=>'EX'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y')),
                'AccountSpendFrom'=>"School Fees",
                'expensetype'=>'Salary',
                'expenseItems'=>null,
                'requested_by'=>'Magezi Peter',
                'overview'=>'Salary expenses paid',
                'expenseTerm'=>1,
                'expenseTotal'=>456000,
                'makeBorrowItems'=>json_encode([
                    ['credit'=>200000,
                    'selectedAccount'=>[
                        'balance'=>"450080000",
                        'id'=>2,
                        "name"=>"Construction Loan"
                    ]]],true),
                    'makeLoanBorrowItems'=>json_encode([
                    [
                        'credit'=>78800,
                        'selectedAccount'=>[
                            'balance'=>"8080000",
                            'id'=>4,
                            "name"=>"Development Fees"
                    ]
                    ]],true),
                'salaryPaymentType'=>'Normal',
                'salaryTerm'=>json_encode(['id'=>1,'name'=>'Term 1'],true),
                'totalBorrow'=>18000,
                'totalBorrowLoan'=>450000,
                'worker'=>json_encode([
                    "id"=>13,
                    "name"=>"Magezi Peter",
                    "roles"=>json_encode(Role::find([6])->toArray(),true),
                    "username"=>"peter",
                    "wage_salary"=>600000
                ],true),
                'user_id'=>8,
                'created_at'=>$date->parse("2020-07-18 18:27:18")->modify('-1 days'),
                'updated_at'=>$date->parse("2020-07-18 18:27:18")->modify('-1 days')
            ],
        ]);

        $date = new Carbon();
        $date2 = $date->now();
        $token =  strtoupper(substr(time(),0,5).Str::random(3).Str::random(3).substr(time(),-3).$date->parse($date2)->format('y'));
        DB::table('payments')->insert([
            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][2],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'building block c',
                        'balance'=>'200000',
                        'deposited'=>'0',
                    ],
                ]),
                'balance'=>'0',
                'fullAmount'=>'200000',
                'paid_by'=>'Mukasa Tom',
                'term_id'=>1,
                'description'=>'Rent Payment',
                'created_at'=>$date->parse("2016-07-18 17:27:18")->modify('-1 days'),
                'updated_at'=>$date->parse("2016-07-18 17:27:18")->modify('-1 days')
            ],
            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][0],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'school fees',
                        'balance'=>'190000',
                        'deposited'=>'190000',
                    ],
                    [
                        'account_name'=>'sports',
                        'balance'=>'15000',
                        'deposited'=>'15000',
                    ],
                    [
                        'account_name'=>'development fees',
                        'balance'=>'10000',
                        'deposited'=>'20000',
                    ],

                ]),
                'balance'=>'150000',
                'fullAmount'=>'350000',
                'paid_by'=>'Okello John',
                'term_id'=>1,
                'description'=>'Student Payment',
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-15 weeks'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-14 weeks')
            ],
            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][0],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'school fees',
                        'balance'=>'190000',
                        'deposited'=>'190000',
                    ],
                    [
                        'account_name'=>'sports',
                        'balance'=>'15000',
                        'deposited'=>'15000',
                    ],
                    [
                        'account_name'=>'development fees',
                        'balance'=>'10000',
                        'deposited'=>'20000',
                    ],

                ]),
                'balance'=>'150000',
                'fullAmount'=>'350000',
                'paid_by'=>'Okello John',
                'term_id'=>1,
                'description'=>'Student Payment',
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-12 weeks'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-11 weeks')
            ],
            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][1],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'school fees',
                        'balance'=>'190000',
                        'deposited'=>'190000',
                    ],
                ]),
                'balance'=>'250000',
                'fullAmount'=>'150000',
                'paid_by'=>'Mukasa Tom',
                'term_id'=>1,
                'description'=>'Salary Loan Payment',
                'created_at'=>$date->parse("2020-07-06 17:27:18")->modify('-3 days'),
                'updated_at'=>$date->parse("2020-07-06 17:27:18")->modify('-2 days')
            ],

            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][2],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'building block c',
                        'deposited'=>'200000',
                        'balance'=>'0',
                    ],
                ]),
                'balance'=>'0',
                'fullAmount'=>'200000',
                'paid_by'=>'Mukasa Tom',
                'term_id'=>1,
                'description'=>'Rent Payment',
                'created_at'=>$date->parse("2020-07-18 17:27:18")->modify('-1 days'),
                'updated_at'=>$date->parse("2020-07-18 17:27:18")->modify('-1 days')
            ],
            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][2],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'building block c',
                        'deposited'=>'450000',
                        'balance'=>'0',
                    ],
                ]),
                'balance'=>'0',
                'fullAmount'=>'450000',
                'paid_by'=>'Kisuule Tom',
                'term_id'=>1,
                'description'=>'Rent Payment',
                'created_at'=>$date->parse("2020-07-18 17:27:18")->modify('-1 days'),
                'updated_at'=>$date->parse("2020-07-18 17:27:18")->modify('-1 days')
            ],
            [
                'reciept_no'=>'P'.strtoupper(substr(time(),0,5).Str::random(3).Str::random(3)
                .substr(time(),-3).$date->parse($date2)->format('y')),
                'paymentType'=>['student','loan','asset'][1],
                'paidItems'=>json_encode([
                    [
                        'account_name'=>'students',
                        'deposited'=>'190000',
                        'balance'=>'190000',
                    ],
                    [
                        'account_name'=>'sports',
                        'deposited'=>'14000',
                        'balance'=>'16000',
                    ],
                ]),
                'balance'=>'250000',
                'fullAmount'=>'226000',
                'paid_by'=>'Kato Micheal',
                'term_id'=>1,
                'description'=>'school fees payment',
                'created_at'=>$date->parse("2020-07-18 18:27:18")->modify('-1 days'),
                'updated_at'=>$date->parse("2020-07-18 18:27:18")->modify('-1 days')
            ],

        ]);


    }
}
