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

        $total_upcoming_rent = 0;
        $total_overdue_rent = 0;
        $total_upcoming_expenses = 0;
        $total_overdue_expenses = 0;

        $count_upcoming_rent = 0;
        $count_overdue_rent = 0;
        $count_upcoming_expenses = 0;
        $count_overdue_expenses = 0;

        $incomes = [];
        $outcomes = [];
        $months = [];
        $cashflow_total = [];
        $cashflow_flag = 0;
        
        $bulk_filtered_property = [];
        foreach($property as $p){
            array_push($bulk_filtered_property,$p->property_id);
        }

        $filtered_property = Property::findOrFail($bulk_filtered_property);
        
        foreach($filtered_property as $p){

            // Expenses
            $filtered_expenses = $p->expenses;
            foreach($filtered_expenses as $fe){
                if($fe->status == 0){
                    if($fe->payment_date >= (Carbon::now()->toDateString()) ){
                        if($fe->amount!=0){
                            $total_upcoming_expenses+=$fe->amount;
                            $count_upcoming_expenses++;
                        }                        
                    }else if($fe->payment_date < Carbon::now()){
                        if($fe->amount!=0){
                            $total_overdue_expenses+=$fe->amount;
                            $count_overdue_expenses++;
                        }
                    }
                }
            }

            // Rents
            $rents = $this->getFilteredRents($p->property_id);
            // Count upcoming rents
            $total_upcoming_rent+=$rents[0];
            $count_upcoming_rent+=$rents[2];

            // Count overdue rents
            $total_overdue_rent+=$rents[1];
            $count_overdue_rent+=$rents[3];


            // Cashflow
            $cashflow = $this->getFilteredCashflow($p->property_id);
            if($cashflow_flag == 0){
                // Init
                array_push($cashflow_total, $cashflow[0]);
                array_push($cashflow_total, $cashflow[1]);
                array_push($cashflow_total, $cashflow[2]);
                $cashflow_flag++;
            }else{
                for($i=0;$i<2;$i++){
                    for($j=0;$j<6;$j++){
                        $cashflow_total[$i][$j]+=$cashflow[$i][$j];
                    }
                }
            }
        }

        
        
        // Wrapping up to an array
        $dashboardData = [
            "total_upcoming_rent"=>$total_upcoming_rent,
            "total_overdue_rent"=>$total_overdue_rent,
            "total_upcoming_expenses"=>$total_upcoming_expenses,
            "total_overdue_expenses"=>$total_overdue_expenses,
            "count_upcoming_rent"=>$count_upcoming_rent,
            "count_overdue_rent"=>$count_overdue_rent,
            "count_upcoming_expenses"=>$count_upcoming_expenses,
            "count_overdue_expenses"=>$count_overdue_expenses,
            "incomes"=>$cashflow_total==null?[]:$cashflow_total[0],
            "outcomes"=>$cashflow_total==null?[]:$cashflow_total[1],
            "months"=>$cashflow_total==null?[]:$cashflow_total[2]
        ];

        return view('dashboard.dashboard',[
            'property'=>$property,
            'active'=>0,
            'total_property'=>$total_property,
            'occupied'=>$occupied,
            'dashboard'=>$dashboardData
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

        $count_upcoming_rent = 0;
        $count_overdue_rent = 0;
        $count_upcoming_expenses = 0;
        $count_overdue_expenses = 0;

        $property = Property::where('user_id',Auth::id())->get();
        $filtered_property = Property::findOrFail($filter);
        
        // Contracts
        // $filtered_contracts = Property::where('property_id',$filter)
        //             ->with(['contracts'=>function($query){
        //                 // Get active contracts based on date
        //                 return $query
        //                 ->whereDate('start_date','<=',Carbon::now())
        //                 ->whereDate('end_date','>=',Carbon::now())
        //                 ->with(['paymentTerm'=>function($query1){
        //                     //Get next term of payment / remain payment
        //                     return $query1->whereNull('payment_date');
        //                 }]);
        //             }])->get()->first();

        // if(count($filtered_contracts->contracts) != 0){
        //     foreach($filtered_contracts->contracts->first()->paymentTerm as $fc){
        //         if($fc->deadline >= (Carbon::now()->toDateString()) ){
        //             // Upcoming
        //             $total_upcoming_rent+=$fc->amount;
        //         }else{
        //             // Overdue
        //             $total_overdue_rent+=$fc->amount;
        //         }
        //     }
        // }
        $rents = $this->getFilteredRents($filter);
        // Count upcoming rents
        $total_upcoming_rent+=$rents[0];
        $count_upcoming_rent+=$rents[2];

        // Count overdue rents
        $total_overdue_rent+=$rents[1];
        $count_overdue_rent+=$rents[3];

        // Expenses
        $filtered_expenses = $filtered_property->expenses;
        foreach($filtered_expenses as $fe){
            if($fe->status == 0){
                if($fe->payment_date >= (Carbon::now()->toDateString()) ){
                    if($fe->amount!=0){
                        $total_upcoming_expenses+=$fe->amount;
                        $count_upcoming_expenses++;
                    }                        
                }else if($fe->payment_date < Carbon::now()){
                    if($fe->amount!=0){
                        $total_overdue_expenses+=$fe->amount;
                        $count_overdue_expenses++;
                    }
                }
            }
        }
        
        // Cashflow
        // Get data last 6 months
        $nm = Carbon::now();
        $lsm = Carbon::now()->subMonths(5);

        $nowMonths = (integer)$nm->format('m');
        $lastSixMonths = (integer)$lsm->format('m');
        
        $incomes = array();
        $outcomes = array();
        $months = array();
       
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
            array_push($incomes,$temp_total_i);
            array_push($outcomes,$temp_total_o);
            array_push($months,$lsm->format('F'));
            
            $lsm = $lsm->addMonths(1);
            $lastSixMonths++;
        }
        
        // Wrapping up to an array
        $dashboardData = [
            "total_upcoming_rent"=>number_format($total_upcoming_rent,0),
            "total_overdue_rent"=>number_format($total_overdue_rent,0),
            "total_upcoming_expenses"=>number_format($total_upcoming_expenses,0),
            "total_overdue_expenses"=>number_format($total_overdue_expenses,0),
            "count_upcoming_rent"=>$count_upcoming_rent,
            "count_overdue_rent"=>$count_overdue_rent,
            "count_upcoming_expenses"=>$count_upcoming_expenses,
            "count_overdue_expenses"=>$count_overdue_expenses,
            "incomes"=>$incomes,
            "outcomes"=>$outcomes,
            "months"=>$months
        ];

        return view('dashboard.dashboard',[
            'property'=>$property,
            'active'=>$filter,
            'dashboard'=>$dashboardData
        ]);
    }

    public function getFilteredRents($filter){
        $total_upcoming_rent = 0;
        $total_overdue_rent = 0;
        $count_upcoming_rent = 0;
        $count_overdue_rent = 0;

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
                    if($fc->amount !=0){
                        $total_upcoming_rent+=$fc->amount;
                        $count_upcoming_rent++;
                    }
                }else{
                    // Overdue
                    if($fc->amount !=0){
                        $total_overdue_rent+=$fc->amount;
                        $count_overdue_rent++;
                    }
                }
            }
        }
        return [$total_upcoming_rent,$total_overdue_rent,$count_upcoming_rent,$count_overdue_rent];
    }

    public function getFilteredCashflow($filter){
        // Cashflow
        // Get data last 6 months
        $nm = Carbon::now();
        $lsm = Carbon::now()->subMonths(5);

        $nowMonths = (integer)$nm->format('m');
        $lastSixMonths = (integer)$lsm->format('m');
        
        $incomes = array();
        $outcomes = array();
        $months = array();
       
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
            array_push($incomes,$temp_total_i);
            array_push($outcomes,$temp_total_o);
            array_push($months,$lsm->format('F'));
            
            $lsm = $lsm->addMonths(1);
            $lastSixMonths++;
        }

        return [$incomes,$outcomes,$months];
    }

}

