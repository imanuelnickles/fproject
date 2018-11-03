<?php

use Illuminate\Foundation\Inspiring;

use App\PaymentTerm;
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

        //TODO : integrate with twilio system
        // Your Account SID and Auth Token from twilio.com/console
        // $sid = '';
        // $token = '';
        // $client = new Client($sid, $token);
        
        // // Use the client to do fun stuff like send text messages!
        // $res = $client->messages->create(
        //     // the number you'd like to send the message to
        //     '+6281294568070',
        //     array(
        //         // A Twilio phone number you purchased at twilio.com/console
        //         'from' => '+15017250604',
        //         // the body of the text message you'd like to send
        //         'body' => 'Hey Jenny! Good luck on the bar exam!'
        //     )
        // );
    }
});
