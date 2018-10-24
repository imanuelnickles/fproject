<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Subscription;
use Carbon\Carbon;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!env('BYPASS_SUBSCRIPTION')){
            $subscription = Subscription::where('user_id',Auth::id())
                            ->where('end_date','<=',date('Y:m:d'))
                            ->first();
            
            if ($subscription == NULL){
                return redirect('/subscription');
            }
        }
        
        return $next($request);
    }
}