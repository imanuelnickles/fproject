<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
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
        $auth = Auth::user();

        // Role 2 means it's admin
        if($auth->role==2){
            return $next($request);
        }else{
            // Redirect to home if not eligible
            return redirect('/home');
        }
        
    }
}
