<?php

namespace App\Http\Controllers;

use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentReportController extends Controller
{
    public function indexDetailed(Request $request)
    {

        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage');
        $sortRowsBy = 'paymentType';
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
            $sortRowsBy = 'paymentType';
        }
        $payments = Payment::with('student','term')->orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('paymentType','like','%'.$query.'%')->orWhere('paid_by','like','%'.$query.'%')->paginate($rowsPerPage);

        return response()->json(compact('payments'));
    }

    public function overviewReport(Request $request)
    {
        $date = new Carbon();
        $queryType = $request->query('queryType')!==null?strtolower($request->queryType):'daily';
        $payments = [];
        if($queryType == 'daily')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount ,
            DATE(created_at) AS paid_day,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM payments
            GROUP BY paid_day, week_of_the_month, month_of_the_year, year;
            ');
        }
        else if($queryType == 'daily_types')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType ,
            DATE(created_at) AS paid_day,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM payments
            GROUP BY paymentType,paid_day, week_of_the_month, month_of_the_year, year;
            ');
        }

        else if($queryType == 'weekly')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM payments
            GROUP BY week_of_the_month, month_of_the_year, year;
            ');
        }
        else if($queryType == 'weekly_types')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType,
            FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM payments
            GROUP BY paymentType, week_of_the_month, month_of_the_year, year;
            ');
        }

        else if($queryType == 'monthly')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM payments
            GROUP BY month_of_the_year, year;
            ');
        }
        else if($queryType == 'monthly_types')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType,
            MONTHNAME(created_at) AS "month_of_the_year", YEAR(created_at) AS year
            FROM payments
            GROUP BY paymentType, month_of_the_year, year;
            ');
        }

        else if($queryType == 'yearly')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,
            YEAR(created_at) AS year
            FROM payments
            GROUP BY year;
            ');
        }
        else if($queryType == 'yearly_types')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType,
            YEAR(created_at) AS year
            FROM payments
            GROUP BY paymentType, year;
            ');
        }
        else if($queryType == 'types')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType
            FROM payments
            GROUP BY paymentType;
            ');
        }
        else if($queryType == 'all')
        {
            $payments = DB::select('
            SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount
            FROM payments;
            ');
        }
        else if($queryType == 'interval')
        {
            $start = $request->query('start')!==null?$request->query('start'):null;
            $end = $request->query('end')!==null?$request->query('end'):null;
            $payments = DB::select('
            SELECT  COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount FROM payments A
            where CAST(A.created_at AS DATE) BETWEEN CAST("'.$date->parse($start)->format('Y-m-d').'" AS DATE) AND CAST("'.$date->parse($end)->format('Y-m-d').'" AS DATE)
            ;');
        }
        else if($queryType == 'interval_types')
        {
            $start = $request->query('start')!==null?$request->query('start'):null;
            $end = $request->query('end')!==null?$request->query('end'):null;
            $payments = DB::select('
            SELECT  COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType FROM payments A
            where CAST(A.created_at AS DATE) BETWEEN CAST("'.$date->parse($start)->format('Y-m-d').'" AS DATE)
            AND CAST("'.$date->parse($end)->format('Y-m-d').'" AS DATE)
            GROUP BY paymentType
            ;');
        }

        else if($queryType == 'income_statement')
        {
            $payments = DB::select('
                SELECT SUM(A.fullAmount) as total_payment_amount,
                SUM(B.expenseTotal) as total_expense_amount,
                (SUM(A.fullAmount) - SUM(B.expenseTotal)) as grand_difference,
                CAST(A.created_at AS DATE) as creation_date
                FROM schools.payments AS A INNER JOIN schools.expenses AS B
                ON CAST(A.created_at AS DATE) = CAST(B.created_at AS DATE)
                GROUP BY CAST(A.created_at AS DATE),CAST(B.created_at AS DATE);
            ');

        }
        else if($queryType == 'income_statement_interval')
        {
            $start = $request->query('start')!==null?$request->query('start'):null;
            $end = $request->query('end')!==null?$request->query('end'):null;
            $payments = DB::select('
                SELECT SUM(A.fullAmount) as total_payment_amount,
                SUM(B.expenseTotal) as total_expense_amount,
                (SUM(A.fullAmount) - SUM(B.expenseTotal)) as grand_difference,
                CAST(A.created_at AS DATE) as creation_date
                FROM schools.payments AS A INNER JOIN schools.expenses AS B
                ON CAST(A.created_at AS DATE) = CAST(B.created_at AS DATE)
                where CAST(A.created_at AS DATE) BETWEEN CAST("'.$date->parse($start)->format('Y-m-d').'" AS DATE)
                AND CAST("'.$date->parse($end)->format('Y-m-d').'" AS DATE)
                GROUP BY CAST(A.created_at AS DATE),CAST(B.created_at AS DATE);
            ');



        }
        $total = count($payments);
        $page = $request->page != null?$request->page:1;
        $perPage = $request->perPage != null?$request->perPage:5;
        $payments = collect($payments)->forPage($page,$perPage);






        return response()->json(compact('payments','perPage','page','total'));
    }
}
