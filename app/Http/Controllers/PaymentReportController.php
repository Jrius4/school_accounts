<?php

namespace App\Http\Controllers;

use App\Payment;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PaymentReportController extends Controller
{
    public function indexDetailed(Request $request)
    {
        $query = $request->query('query');
        $rowsPerPage = $request->query('rowsPerPage')!=null?$request->query('rowsPerPage'):10;
        if($request->query('rowsPerPage')==-1)$rowsPerPage = Payment::count();
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
        $payments = Payment::with('student','term')->orderBy($sortRowsBy,($sortDesc?'desc':'asc'))->where('paymentType','like','%'.$query.'%')->orWhere('paid_by','like','%'.$query.'%')->orWhere('reciept_no','like','%'.$query.'%')->paginate($rowsPerPage);

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
                DATE(created_at) AS paid_day
                FROM payments GROUP BY paid_day ORDER BY paid_day;
            ');
        }
        else if($queryType == 'daily_by_group')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType ,
                DATE(created_at) AS paid_day
                FROM payments GROUP BY paid_day,paymentType ORDER BY paid_day,paymentType;
            ');
        }

        else if($queryType == 'weekly')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,
                FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
                MONTHNAME(created_at) AS "month_of_the_year",
                YEAR(created_at) AS year
                FROM payments
                GROUP BY year, month_of_the_year, week_of_the_month ORDER BY year, month_of_the_year, week_of_the_month;
            ');
        }
        else if($queryType == 'weekly_by_group')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType,
                FLOOR((DAY(created_at)-1)/7 + 1) AS week_of_the_month,
                MONTH(created_at) AS month_of_the_year, YEAR(created_at) AS year
                FROM payments
                GROUP BY year, month_of_the_year, week_of_the_month,paymentType ORDER BY year, month_of_the_year, week_of_the_month,paymentType;
            ');
        }

        else if($queryType == 'monthly')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,
                MONTH(created_at) AS month_of_the_year, YEAR(created_at) AS year
                FROM payments
                GROUP BY year,month_of_the_year ORDER BY year,month_of_the_year;
            ');
        }
        else if($queryType == 'monthly_by_group')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount,paymentType,
                MONTH(created_at) AS month_of_the_year,
                YEAR(created_at) AS year
                FROM payments
                GROUP BY year,month_of_the_year,paymentType  ORDER BY year,month_of_the_year,paymentType;
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
        else if($queryType == 'yearly_by_group')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments,
                SUM(fullAmount) AS total_amount,
                paymentType,
                YEAR(created_at) AS year
                FROM payments
                GROUP BY paymentType, year;
            ');
        }
        else if($queryType == 'types')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments,
                SUM(pa.fullAmount) AS total_amount,
                pa.paymentType
                FROM payments AS pa
                GROUP BY pa.paymentType;
            ');
        }
        else if($queryType == 'all')
        {
            $payments = DB::select('
                SELECT COUNT(*) AS no_payments, SUM(fullAmount) AS total_amount
                FROM payments;
            ');
        }
        else if ($queryType == 'interval'){
            $start = $request->query('start');
            $end = $request->query('end');
            $startDate = $date->parse($start)->format('Y-m-d');
            $endDate = $date->parse($end)->format('Y-m-d');
            $payments = DB::select("
            SELECT COUNT(*) AS no_expenses,
            '".$startDate."_".$endDate."' AS p_period,SUM(pa.fullAmount) AS total_amount
            FROM payments AS pa WHERE pa.created_at
            BETWEEN DATE('".$startDate."') AND DATE('".$endDate."') GROUP BY p_period;
            ");

        }
        else if($queryType == 'interval_by_group')
        {
            $start = $request->query('start');
            $end = $request->query('end');
            $startDate = $date->parse($start)->format('Y-m-d');
            $endDate = $date->parse($end)->format('Y-m-d');
            $payments = DB::select("
            SELECT pa.paymentType, COUNT(*) AS no_expenses,
            '".$startDate."_".$endDate."' AS p_period,SUM(pa.fullAmount) AS total_amount
            FROM payments AS pa WHERE pa.created_at
            BETWEEN DATE('".$startDate."') AND DATE('".$endDate."') GROUP BY pa.paymentType,p_period;
            ");
        }







        $queryType = $queryType;
        $total = count($payments);
        $page = $request->query('page') != null?$request->query('page'):1;
        $rowsPerPage = $request->query('rowsPerPage') != null?$request->query('rowsPerPage'):5;
        $offset = ($page * $rowsPerPage) - $rowsPerPage;

        $payments = new LengthAwarePaginator(array_slice($payments,$offset,$rowsPerPage,false),
        $total,$rowsPerPage,$page,['path'=>$request->url(),
        'query'=>$request->query()
        ]);






        return response()->json(compact('payments','rowsPerPage','page','total','queryType'));
    }

    public function overviewPayments()
    {
        return view('fianance.payments.overview-payments');
    }
    public function overview()
    {
        return view('fianance.payments.overview-reports');
    }

    public function listOutcomes(Request $request)
    {
        $period = $request->query('period') != null? $request->query('period'):'daily';
        $page = $request->query('page') != null? $request->query('page'):1;
        $rowsPerPage = $request->query('rowsPerPage') != null? $request->query('rowsPerPage'):15;
        $income = [];
        $date = new Carbon();
        if($period == 'daily')
        {

        $income = DB::select("
            WITH z AS ((SELECT  'inflow' AS ptype, SUM(pa.fullAmount) AS p_amount,
            DATE(pa.created_at) AS p_date FROM payments AS pa
            GROUP BY DATE(pa.created_at))
            UNION ALL
            (SELECT  'outflow' AS ptype,SUM(ex.expenseTotal) AS p_amount, DATE(ex.created_at) AS p_date FROM expenses AS ex
            GROUP BY DATE(ex.created_at)))

            SELECT a.p_date,if(a.p_amount,a.p_amount,0) AS inflow,if(b.p_amount,b.p_amount,0) AS outflow, (if(a.p_amount,a.p_amount,0) - if(b.p_amount,b.p_amount,0)) AS diff FROM
            (SELECT p_date,sum(case when ptype = 'inflow' then p_amount end) AS p_amount FROM z GROUP BY p_date ) a
            JOIN
            (SELECT p_date,sum(case when ptype = 'outflow' then p_amount end) AS p_amount FROM z GROUP BY p_date ) b
            on a.p_date = b.p_date ORDER BY a.p_date,b.p_date;
        ");
        }

        else if($period == 'weekly')
        {
            $income = DB::select("
            WITH z AS ((SELECT  'inflow' AS ptype, SUM(pa.fullAmount) AS p_amount,
            FLOOR((DAY(pa.created_at)-1)/7 + 1) AS p_week,
            MONTHNAME(pa.created_at) AS p_month,YEAR(pa.created_at) AS p_year FROM payments AS pa
            GROUP BY p_year,p_month,p_week)
            UNION ALL
            (SELECT  'outflow' AS ptype,SUM(ex.expenseTotal) AS p_amount,
            FLOOR((DAY(ex.created_at)-1)/7 + 1) AS p_week,
            MONTHNAME(ex.created_at) AS p_month,YEAR(ex.created_at) AS p_year FROM expenses AS ex
            GROUP BY p_year,p_month,p_week))

            SELECT a.p_week, a.p_month,a.p_year,if(a.p_amount,a.p_amount,0) AS inflow,if(b.p_amount,b.p_amount,0) AS outflow,
            (if(a.p_amount,a.p_amount,0) - if(b.p_amount,b.p_amount,0)) AS diff FROM
            (SELECT p_week,p_month,p_year,sum(case when ptype = 'inflow' then p_amount end) AS p_amount FROM z GROUP BY p_year,p_month,p_week) a
            JOIN
            (SELECT p_week,p_month,p_year,sum(case when ptype = 'outflow' then p_amount end) AS p_amount FROM z GROUP BY  p_year,p_month,p_week) b
            ON  a.p_week = b.p_week && a.p_month = b.p_month && a.p_year = b.p_year
            ORDER BY a.p_year,b.p_year,a.p_month,b.p_month,a.p_week,b.p_week;
            ");
        }

        else if($period == 'monthly')
        {
            $income = DB::select("
                WITH z AS ((SELECT  'inflow' AS ptype, SUM(pa.fullAmount) AS p_amount,
                MONTHNAME(pa.created_at) AS p_month,YEAR(pa.created_at) AS p_year FROM payments AS pa
                GROUP BY p_year,p_month)
                UNION ALL
                (SELECT  'outflow' AS ptype,SUM(ex.expenseTotal) AS p_amount,
                MONTHNAME(ex.created_at) AS p_month,YEAR(ex.created_at) AS p_year FROM expenses AS ex
                GROUP BY p_year,p_month))

                SELECT a.p_month,a.p_year,if(a.p_amount,a.p_amount,0) AS inflow,if(b.p_amount,b.p_amount,0) AS outflow,
                (if(a.p_amount,a.p_amount,0) - if(b.p_amount,b.p_amount,0)) AS diff FROM
                (SELECT p_month,p_year,sum(case when ptype = 'inflow' then p_amount end) AS p_amount FROM z GROUP BY p_month,p_year ) a
                JOIN
                (SELECT p_month,p_year,sum(case when ptype = 'outflow' then p_amount end) AS p_amount FROM z GROUP BY p_month,p_year ) b
                on a.p_month = b.p_month && a.p_year = b.p_year ORDER BY a.p_year,b.p_year,a.p_month,b.p_month;

            ");
        }

        else if($period == 'yearly'){
            $income = DB::select("
                WITH z AS ((SELECT  'inflow' AS ptype, SUM(pa.fullAmount) AS p_amount,
                YEAR(pa.created_at) AS p_year FROM payments AS pa
                GROUP BY p_year ORDER BY p_year)
                UNION ALL
                (SELECT  'outflow' AS ptype,SUM(ex.expenseTotal) AS p_amount,
                YEAR(ex.created_at) AS p_year FROM expenses AS ex
                GROUP BY p_year ORDER BY p_year))
                SELECT b.p_year,if(a.p_amount,a.p_amount,0) AS inflow,if(b.p_amount,b.p_amount,0) AS outflow,
                (if(a.p_amount,a.p_amount,0) - if(b.p_amount,b.p_amount,0)) AS diff FROM
                (SELECT p_year,sum(case when ptype = 'inflow' then p_amount end) AS p_amount FROM z GROUP BY p_year ) a
                JOIN
                (SELECT p_year,sum(case when ptype = 'outflow' then p_amount end) AS p_amount FROM z GROUP BY p_year ) b
                on a.p_year = b.p_year ORDER BY a.p_year,b.p_year;
            ");
        }
        else if($period == 'interval') {
            $start = $request->query('start');
            $end = $request->query('end');

            $startDate = $date->parse($start)->format('Y-m-d');
            $endDate = $date->parse($end)->format('Y-m-d');

            $income = DB::select("
                WITH z AS ((SELECT  'inflow' AS ptype,'".$startDate."_".$endDate."' AS p_period, SUM(pa.fullAmount) AS p_amount FROM payments AS pa
                where DATE(pa.created_at) BETWEEN DATE('".$startDate."') AND DATE('".$endDate."') GROUP BY p_period)
                UNION ALL
                (SELECT  'outflow' AS ptype,'".$startDate."_".$endDate."' AS p_period,SUM(ex.expenseTotal) AS p_amount
                FROM expenses AS ex
                where DATE(ex.created_at) BETWEEN DATE('".$startDate."') AND DATE('".$endDate."') GROUP BY p_period))
                SELECT a.p_period,if(a.p_amount,a.p_amount,0) AS inflow,if(b.p_amount,b.p_amount,0) AS outflow,
                (if(a.p_amount,a.p_amount,0) - if(b.p_amount,b.p_amount,0)) AS diff FROM
                (SELECT p_period,sum(case when ptype = 'inflow' then p_amount end) AS p_amount FROM z GROUP BY p_period) a
                JOIN
                (SELECT p_period,sum(case when ptype = 'outflow' then p_amount end) AS p_amount FROM z GROUP BY p_period) b
                on a.p_period = b.p_period;
            ");
            // array_push($income,['start'=>$startDate,'end'=>$endDate]);
        }
        else{
            $income = [['error'=>'wrong input!']];
        }
        $total = count($income);
        $offset = ($page * $rowsPerPage) - $rowsPerPage;
        $income = new LengthAwarePaginator(array_slice($income,$offset,$rowsPerPage,false),
        $total,$rowsPerPage,$page,['path'=>$request->url(),
        'query'=>$request->query()
        ]);

        // $income = collect($income)
        // ->forPage($page,$rowsPerPage);
      return response()->json(compact('income','page','rowsPerPage','total','period'));
    }

    public function graphPayments()
    {
        return view('fianance.graphs.payments-graph');
    }

    public function graphExpenses()
    {
        return view('fianance.graphs.expenses-graph');
    }

    public function graphIncomeStatement()
    {
        return view('fianance.graphs.income-statements-graph');
    }

}
