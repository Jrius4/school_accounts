<?php

namespace App\Http\Controllers;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ExpenseReportController extends Controller
{
    public function indexDetailed(Request $request)
    {
        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage')!=null?$request->query('rowsPerPage'):10;
        if($request->query('rowsPerPage')==-1)$rowsPerPage = Expense::count();
        $sortRowsBy = 'expensetype';
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
            $sortRowsBy = 'expensetype';
        }
        $expenses = Expense::orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('expensetype','like','%'.$query.'%')->orWhere('requested_by','like','%'.$query.'%')->orWhere('token','like','%'.$query.'%')->paginate($rowsPerPage);

        return response()->json(compact('expenses'));
    }

    public function overviewReport(Request $request)
    {
        $date = new Carbon();
        $queryType = $request->query('queryType')!==null?strtolower($request->queryType):'daily';
        $expenses = [];
        if($queryType == 'daily')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount ,
            DATE(created_at) AS expense_day
            FROM expenses
            GROUP BY expense_day ORDER BY expense_day;
            ');
        }
        else if($queryType == 'daily_by_group')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,expensetype ,
            DATE(created_at) AS expense_day
            FROM expenses
            GROUP BY expense_day,expensetype ORDER BY expense_day,expensetype;
            ');
        }

        else if($queryType == 'weekly')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTH(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY year,month_of_the_year,week_of_the_month ORDER BY year,month_of_the_year,week_of_the_month;
            ');
        }
        else if($queryType == 'weekly_by_group')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,expensetype,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTH(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY year,month_of_the_year,week_of_the_month,expensetype ORDER BY year,month_of_the_year,week_of_the_month,expensetype;
            ');
        }

        else if($queryType == 'monthly')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,
            MONTH(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY year,month_of_the_year ORDER BY year,month_of_the_year;
            ');
        }
        else if($queryType == 'monthly_by_group')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,expensetype,
            MONTH(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY year,month_of_the_year,expensetype ORDER BY year,month_of_the_year,expensetype;
            ');
        }

        else if($queryType == 'yearly')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,
            YEAR(created_at) AS year
            FROM expenses
            GROUP BY year ORDER BY year;
            ');
        }
        else if($queryType == 'yearly_by_group')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,expensetype,
            YEAR(created_at) AS year
            FROM expenses
            GROUP BY year,expensetype ORDER BY year,expensetype;
            ');
        }
        else if($queryType == 'groups')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses,
            SUM(expenseTotal) AS total_amount,
            expensetype
            FROM expenses
            GROUP BY expensetype ORDER BY expensetype;
            ');
        }
        else if($queryType == 'all')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount
            FROM expenses;
            ');
        }

        else if ($queryType == 'interval'){
            $start = $request->query('start');
            $end = $request->query('end');

            $startDate = $date->parse($start)->format('Y-m-d');
            $endDate = $date->parse($end)->format('Y-m-d');
            $expenses = DB::select("
            SELECT COUNT(*) AS no_expenses,
            '".$startDate."_".$endDate."' AS p_period,SUM(ex.expenseTotal) AS total_amount
            FROM expenses AS ex WHERE ex.created_at
            BETWEEN DATE('".$startDate."') AND DATE('".$endDate."') GROUP BY p_period;
            ");

        }
        else if($queryType == 'interval_by_group')
        {
            $start = $request->query('start');
            $end = $request->query('end');

            $startDate = $date->parse($start)->format('Y-m-d');
            $endDate = $date->parse($end)->format('Y-m-d');
            $expenses = DB::select("
            SELECT expensetype, COUNT(*) AS no_expenses,
            '".$startDate."_".$endDate."' AS p_period,SUM(ex.expenseTotal) AS total_amount
            FROM expenses AS ex WHERE ex.created_at
            BETWEEN DATE('".$startDate."') AND DATE('".$endDate."') GROUP BY expensetype,p_period;
            ");
        }

        $total = count($expenses);
        $page = $request->query('page') != null?$request->query('page'):1;
        $rowsPerPage = $request->query('rowsPerPage') != null?$request->query('rowsPerPage'):5;
        $offset = ($page * $rowsPerPage) - $rowsPerPage;
        $payments = new LengthAwarePaginator(array_slice($expenses,$offset,$rowsPerPage,false),
        $total,$rowsPerPage,$page,['path'=>$request->url(),
        'query'=>$request->query()
        ]);






        return response()->json(compact('payments','queryType'));
    }
    public function overviewPayments()
    {
        return view('fianance.payments.overview-expenses');
    }

    public function graphExpenses(){
        return view('fianance.graphs.expenses-graph');
    }


}
