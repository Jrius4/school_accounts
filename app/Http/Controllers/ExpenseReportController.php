<?php

namespace App\Http\Controllers;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseReportController extends Controller
{
    public function indexDetailed(Request $request)
    {
        // dump($request->all());

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
            DATE(created_at) AS expense_day,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY expense_day, week_of_the_month, month_of_the_year, year;
            ');
        }
        else if($queryType == 'daily_types')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,paymentType ,
            DATE(created_at) AS expense_day,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY paymentType,expense_day, week_of_the_month, month_of_the_year, year;
            ');
        }

        else if($queryType == 'weekly')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY week_of_the_month, month_of_the_year, year;
            ');
        }
        else if($queryType == 'weekly_types')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,paymentType,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY paymentType, week_of_the_month, month_of_the_year, year;
            ');
        }

        else if($queryType == 'monthly')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY month_of_the_year, year;
            ');
        }
        else if($queryType == 'monthly_types')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,paymentType,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM expenses
            GROUP BY paymentType, month_of_the_year, year;
            ');
        }

        else if($queryType == 'yearly')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,
            YEAR(created_at) AS year
            FROM expenses
            GROUP BY year;
            ');
        }
        else if($queryType == 'yearly_types')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,paymentType,
            YEAR(created_at) AS year
            FROM expenses
            GROUP BY paymentType, year;
            ');
        }
        else if($queryType == 'types')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,paymentType
            FROM expenses
            GROUP BY paymentType;
            ');
        }
        else if($queryType == 'all')
        {
            $expenses = DB::select('
            SELECT COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount
            FROM expenses;
            ');
        }
        else if($queryType == 'interval')
        {
            $start = $request->query('start')!==null?$request->query('start'):null;
            $end = $request->query('end')!==null?$request->query('end'):null;
            $expenses = DB::select('
            SELECT  COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount FROM expenses A
            where CAST(A.created_at AS DATE) BETWEEN CAST("'.$date->parse($start)->format('Y-m-d').'" AS DATE) AND CAST("'.$date->parse($end)->format('Y-m-d').'" AS DATE)
            ;');
        }
        else if($queryType == 'interval_types')
        {
            $start = $request->query('start')!==null?$request->query('start'):null;
            $end = $request->query('end')!==null?$request->query('end'):null;
            $expenses = DB::select('
            SELECT  COUNT(*) AS no_expenses, SUM(expenseTotal) AS total_amount,paymentType FROM expenses A
            where CAST(A.created_at AS DATE) BETWEEN CAST("'.$date->parse($start)->format('Y-m-d').'" AS DATE)
            AND CAST("'.$date->parse($end)->format('Y-m-d').'" AS DATE)
            GROUP BY paymentType
            ;');
        }

        else if($queryType == 'income_statement_daily')
        {
            $expenses = DB::select('
                SELECT SUM(A.expenseTotal) as total_payment_amount,
                SUM(B.expenseTotal) as total_expense_amount,
                (SUM(A.expenseTotal) - SUM(B.expenseTotal)) as grand_difference,
                DATE(A.created_at) as creation_date
                FROM schools.expenses AS A INNER JOIN schools.expenses AS B
                ON DATE(A.created_at) = DATE(B.created_at)
                GROUP BY creation_date;
            ');

        }
        else if($queryType == 'income_statement_weekly')
        {
            $expenses = DB::select('
            SELECT SUM(A.expenseTotal) as total_payment_amount,
            SUM(B.expenseTotal) as total_expense_amount,
            (SUM(A.expenseTotal) - SUM(B.expenseTotal)) as grand_difference,
            FLOOR((DAY(A.created_at)-1)/7 + 1) AS month_week,
            MONTHNAME(A.created_at) as creation_month,
            YEAR(A.created_at) as creation_year
            FROM schools.expenses AS A INNER JOIN schools.expenses AS B
            ON
            FLOOR((DAY(A.created_at)-1)/7 + 1) = FLOOR((DAY(B.created_at)-1)/7 + 1)
            &&
            MONTHNAME(A.created_at) = MONTHNAME(B.created_at)
            && YEAR(A.created_at) = YEAR(B.created_at)
            GROUP BY month_week,creation_month,creation_year;
            ');

        }
        else if($queryType == 'income_statement_monthly')
        {
            $expenses = DB::select('
            SELECT SUM(A.expenseTotal) as total_payment_amount,
            SUM(B.expenseTotal) as total_expense_amount,
            (SUM(A.expenseTotal) - SUM(B.expenseTotal)) as grand_difference,
            MONTHNAME(A.created_at) as creation_month,
            YEAR(A.created_at) as creation_year
            FROM schools.expenses AS A INNER JOIN schools.expenses AS B
            ON MONTHNAME(A.created_at) = MONTHNAME(B.created_at)
            && YEAR(A.created_at) = YEAR(B.created_at)
            GROUP BY creation_month,creation_year;
            ');

        }
        else if($queryType == 'income_statement_yearly')
        {
            $expenses = DB::select('
            SELECT SUM(A.expenseTotal) as total_payment_amount,
            SUM(B.expenseTotal) as total_expense_amount,
            (SUM(A.expenseTotal) - SUM(B.expenseTotal)) as grand_difference,
            YEAR(A.created_at) as creation_year
            FROM schools.expenses AS A INNER JOIN schools.expenses AS B
            ON YEAR(A.created_at) = YEAR(B.created_at)
            GROUP BY creation_year;
            ');

        }
        else if($queryType == 'income_statement_interval')
        {
            $start = $request->query('start')!==null?$request->query('start'):null;
            $end = $request->query('end')!==null?$request->query('end'):null;
            $expenses = DB::select('
                SELECT SUM(A.expenseTotal) as total_payment_amount,
                SUM(B.expenseTotal) as total_expense_amount,
                (SUM(A.expenseTotal) - SUM(B.expenseTotal)) as grand_difference,
                CAST(A.created_at AS DATE) as creation_date
                FROM schools.expenses AS A INNER JOIN schools.expenses AS B
                ON CAST(A.created_at AS DATE) = CAST(B.created_at AS DATE)
                where CAST(A.created_at AS DATE) BETWEEN CAST("'.$date->parse($start)->format('Y-m-d').'" AS DATE)
                AND CAST("'.$date->parse($end)->format('Y-m-d').'" AS DATE)
                GROUP BY CAST(A.created_at AS DATE),CAST(B.created_at AS DATE);
            ');
        }

        $total = count($expenses);
        $page = $request->page != null?$request->page:1;
        $perPage = $request->perPage != null?$request->perPage:5;
        $expenses = collect($expenses)->forPage($page,$perPage);






        return response()->json(compact('expenses','perPage','page','total'));
    }


}
