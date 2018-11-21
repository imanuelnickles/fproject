<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Subscription;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /* User admin modules */
    public function user(){
        // Find all related tenant
        $user = User::all();
        return view('admin.user',['user'=>$user]);
    }

    public function userDetail($id){
        // Find user that match to `id`
        $user =  User::findOrFail($id);
        $expired  = Subscription::where('user_id',$id)
                    ->where('end_date','<=',date('Y:m:d'))
                    ->first();
        $is_sub_expired = $expired != null ? true : false;
        return view('admin.user_detail',['user'=>$user,'is_sub_expired'=>$is_sub_expired]);
    }

    public function userUpdate(Request $request,$id){
        //
        $user =  User::findOrFail($id);
        $expired_date = Input::get('subscription');
        if($user->subscription->end_date == $expired_date){
            return back();
        }
        $subscription = Subscription::where('user_id',$user->id)->get()->first();
        $subscription->end_date = $expired_date;
        $subscription->save();
        return back();
    }

    public function userBan($id){
        //
        $user = User::where('id',$id)->get()->first();
        if(Auth::id()==$user->id){
            return back();
        }

        if($user->blocked_on == null){
            // Ban Action
            $user->blocked_on = Carbon::now();
        }else{
            // Unban Action
            $user->blocked_on = null;
        }
        $user->save();
        return back();
    }
}
