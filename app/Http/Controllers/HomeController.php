<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use App\Property;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('subscription');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
        $property = Property::where('user_id',Auth::id())->get();

        // Occupancy
        $total_property = count($property);
        $occupied = 0;
        foreach($property as $p){
            if($p->occupied == 1){
                $occupied++;
            }
        }
 
        return view('dashboard.dashboard',[
            'property'=>$property,
            'active'=>0,
            'total_property'=>$total_property,
            'occupied'=>$occupied   
        ]);
    }

    public function show(Request $request)
    {
        // Here need to check filter
        // Filter 0 = all
        $filter = Input::get('filter');

        if($filter == 0){
            return $this->index();
        }

        // Data processing
        $total_upcoming_rent = 0;
        $total_overdue_rent = 0;
        $total_upcoming_expenses = 0;
        $total_overdue_expenses = 0;

        $property = Property::where('user_id',Auth::id())->get();
        $filtered_property = Property::findOrFail($filter);
        
        // Contracts
        $filtered_contracts = Property::where('property_id',$filter)
                    ->with(['contracts'=>function($query){
                        // Get active contracts based on date
                        return $query
                        ->whereDate('start_date','<=',Carbon::now())
                        ->whereDate('end_date','>=',Carbon::now())
                        ->with(['paymentTerm'=>function($query1){
                            //Get next term of payment / remain payment
                            return $query1->whereNull('payment_date');
                        }]);
                    }])->get()->first();

        if(count($filtered_contracts->contracts) != 0){
            foreach($filtered_contracts->contracts->first()->paymentTerm as $fc){
                if($fc->deadline >= (Carbon::now()->toDateString()) ){
                    // Upcoming
                    $total_upcoming_rent+=$fc->amount;
                }else{
                    // Overdue
                    $total_overdue_rent+=$fc->amount;
                }
            }
        }

        // Expenses
        $filtered_expenses = $filtered_property->expenses;
        foreach($filtered_expenses as $fe){
            if($fe->status == 0){
                if($fe->payment_date >= (Carbon::now()->toDateString()) ){
                    $total_upcoming_expenses+=$fe->amount;
                }else if($fe->payment_date < Carbon::now()){
                    $total_overdue_expenses+=$fe->amount;
                }
            }
        }
        
        // Cashflow
        // Get data last 6 months
        $nm = Carbon::now();
        $lsm = Carbon::now()->subMonths(5);

        $nowMonths = (integer)$nm->format('m');
        $lastSixMonths = (integer)$lsm->format('m');
        $cashflow = array();
       
        for($i=$lastSixMonths;$i<=$nowMonths;$i++){
            // incomes
            $in = Property::where('property_id',$filter)
            ->with(['contracts'=>function($query) use ($lastSixMonths){
                // Get active contracts based on date
                return $query
                ->with(['paymentTerm'=>function($query1) use ($lastSixMonths){
                    //Get next term of payment / remain payment
                    return $query1->whereMonth('payment_date','=',$lastSixMonths);
                }]);
            }])->get()->first();
            $temp_total_i=0;
            foreach($in->contracts as $ic){
                foreach($ic->paymentTerm as $icp){
                    $temp_total_i+=$icp->amount;
                }
            }

            // expenses
            $ex = Property::where('property_id',$filter)->with(['expenses'=>function($query) use ($nowMonths,$lastSixMonths){
                return $query->whereMonth('payment_date','=',$lastSixMonths);
            }])->get()->first();
            $temp_total_o = 0;
            foreach($ex->expenses as $e){
                $temp_total_o+=$e->amount;
            }

            array_push($cashflow,["m" => $lsm->format('F'), "i" => $temp_total_i,"o"=>$temp_total_o]);
            $lsm = $lsm->addMonths(1);
            $lastSixMonths++;
        }
        
        // Wrapping up to an array
        $dashboardData = [
            "total_upcoming_rent"=>$total_upcoming_rent,
            "total_overdue_rent"=>$total_overdue_rent,
            "total_upcoming_expenses"=>$total_upcoming_expenses,
            "total_overdue_expenses"=>$total_overdue_expenses,
            "cashflow"=>$cashflow
        ];

        return view('dashboard.dashboard',[
            'property'=>$property,
            'active'=>$filter,
            'dashboard'=>$dashboardData
        ]);
    }
}
