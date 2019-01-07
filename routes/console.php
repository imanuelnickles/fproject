<?php

use Illuminate\Foundation\Inspiring;

use App\PaymentTerm;
use App\Contract;
use App\Property;
use Carbon\Carbon;

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('SendNotification',function(){
    // payment_date is null 
    // deadline is 1 d before
    // we execute it every 1:00 AM

    // Get the contract_id and then tenant_id
    $subOneDay = Carbon::now()->subDays(1)->toDateString();
    $pt = PaymentTerm::whereDate('deadline',$subOneDay)
            ->whereNull('payment_date')
            ->get();

    foreach($pt as $p){
        // Do send notification
        Log::debug($p->contract->tenant->email);

        Nexmo::message()->send([
            'to'   => $p->contract->tenant->mobile,
            'from' => env('NEXMO_VIRTUAL_NUMBER'),
            'text' => 'Using the facade to send a message.'
        ]);
    }
});

Artisan::command('UpdateDB',function(){
    // 1. Update property status 1 to 0
    $now = Carbon::now()->toDateString();
    $expiredContract = Contract::where('end_date','<',$now)
            ->with(['property'=>function($query){
                return $query->where('occupied',1);
            }])->get();
    foreach($expiredContract as $e){
        if($e->property != null){
            $p = Property::where('property_id',$e->property_id);
            $p->update([
                'occupied'=>0
            ]);
        }
    }

    // 2. Update property status 0 to 1
    $activeContract = Contract::where('start_date','<=',$now)
            ->where('end_date','>=',$now)
            ->with(['property'=>function($query){
                return $query->where('occupied',0);
            }])->get();
    
    foreach($activeContract as $a){
        if($a->property != null){
            $p = Property::where('property_id',$a->property_id);
            $p->update([
                'occupied'=>1
            ]);
        }
    }
});