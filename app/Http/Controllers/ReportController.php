<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportIncomeExpense()
    {
        return view('report.report_income_expense');
    }
    
    public function reportOverdue()
    {
        return view('report.report_overdue');
    }

    public function reportUpcomingIncome()
    {
        return view('report.report_upcoming_income');
    }

    public function reportOverdueView(Request $request)
    {
        $cutoff = $request->get('cutoff');

        $rawQuery = "
            select 
            c.property_id,
            concat(p.name, ', ', p.address,', ', p.city,', ', p.country) as property,
            concat(t.title, ' ', t.first_name, ' ', t.last_name) as tenant,
            pt.deadline, 
            format(pt.amount,0) as amount, 
            payment_date
            from contracts as c
            inner join properties as p on c.property_id = p.property_id
            inner join payment_terms as pt on c.contract_id = pt.contract_id
            inner join tenants as t on c.tenant_id = t.tenant_id
            where p.user_id = ".Auth::id()." and pt.payment_date is null and pt.deadline < '".$cutoff."' and pt.deadline < '".date('Y-m-d')."'
            order by c.property_id
        ";
        
        $rawTotal = "
            select 
            format(sum(pt.amount),0) as total
            from contracts as c
            inner join properties as p on c.property_id = p.property_id
            inner join payment_terms as pt on c.contract_id = pt.contract_id
            where p.user_id = ".Auth::id()." and pt.payment_date is null and pt.deadline < '".$cutoff."' and pt.deadline < '".date('Y-m-d')."'
        ";
        $report = DB::select($rawQuery);
        $total = DB::select($rawTotal);

        return view('report.report_overdue_output',['report'=>$report, 'cutoff'=>$cutoff, 'total'=>$total[0]]);
    }

    public function reportUpcomingIncomeView(Request $request)
    {
        $cutoff = $request->get('cutoff');

        $rawQuery = "
            select 
            c.property_id,
            concat(p.name, ', ', p.address,', ', p.city,', ', p.country) as property,
            concat(t.title, ' ', t.first_name, ' ', t.last_name) as tenant,
            pt.deadline, 
            format(pt.amount,0) as amount, 
            payment_date
            from contracts as c
            inner join properties as p on c.property_id = p.property_id
            inner join payment_terms as pt on c.contract_id = pt.contract_id
            inner join tenants as t on c.tenant_id = t.tenant_id
            where p.user_id = ".Auth::id()." and pt.payment_date is null and pt.deadline < '".$cutoff."' and pt.deadline >= '".date('Y-m-d')."'
            order by c.property_id
        ";
        
        $rawTotal = "
            select 
            format(sum(pt.amount),0) as total
            from contracts as c
            inner join properties as p on c.property_id = p.property_id
            inner join payment_terms as pt on c.contract_id = pt.contract_id
            where p.user_id = ".Auth::id()." and pt.payment_date is null and pt.deadline < '".$cutoff."' and pt.deadline >= '".date('Y-m-d')."'
        ";
        $report = DB::select($rawQuery);
        $total = DB::select($rawTotal);

        return view('report.report_upcoming_income_output',['report'=>$report, 'cutoff'=>$cutoff, 'total'=>$total[0]]);
    }
	
	public function reportIncomeExpenseView(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $rawQuery = "
        select * from (
            select 
                p.property_id, 
                concat(p.name, ', ', p.address,', ', p.city,', ', p.country) as property,
                o.payment_date as date,
                o.name as description,
                FORMAT(o.amount, 0) as pengeluaran,
            
                '' as pemasukan
            from properties as p
            inner join outcomes as o on o.property_id = p.property_id
            
            where o.status = 1 and p.user_id = ".Auth::id()." and o.payment_date >= '".$start."' and o.payment_date <= '".$end."'
            
            union all
            select 
                p.property_id, 
                concat(p.name, ', ', p.address,', ', p.city,', ', p.country) as property,
                y.payment_date as date,
                concat(t.title,' ', t.first_name,' ', t.last_name, ' - ', y.payment_type) as description,
                '' as pengeluaran,
                FORMAT(y.amount, 0) as pemasukan
            from properties as p 
            inner join contracts as c on c.property_id = p.property_id
            inner join payment_terms as pt on pt.contract_id = c.contract_id
            inner join payments as y on y.payment_term_id = pt.payment_term_id
            left join tenants as t on y.tenant_id = t.tenant_id
            where p.user_id = ".Auth::id()." and y.payment_date >= '".$start."' and y.payment_date <= '".$end."'
            ) as a 
            
            order by a.property_id, a.date
        ";
        
        $rawTotal = "
            select FORMAT(sum(t.pemasukan),0) as pemasukan, FORMAT(sum(t.pengeluaran),0) as pengeluaran, FORMAT(sum(t.total),0) as total from (
                select sum(p.amount) as pemasukan, 0 as pengeluaran, sum(p.amount) as total from payments as p
                where p.user_id = ".Auth::id()." and p.payment_date >= '".$start."' and p.payment_date <= '".$end."'
                union all
                select 0 as pemasukan, sum(o.amount) as pengeluaran, (sum(o.amount) * -1) as total from outcomes o
                where p.user_id = ".Auth::id()." and o.payment_date >= '".$start."' and o.payment_date <= '".$end."' and o.status = 1
            ) as t
        ";
        $report = DB::select($rawQuery);
        $total = DB::select($rawTotal);

        return view('report.report_income_expense_output',['report'=>$report, 'start'=>$start, 'end'=>$end, 'total'=>$total[0]]);
    }
}
