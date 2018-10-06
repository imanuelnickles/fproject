<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Property;
use App\Outcome;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // TODO : add flash message if failure (returning back)
        if($id=="" || $id == "0"){
            return redirect()->route('show_property');
        }
        
        // need to check if property_id is belongs to auth user_id.
        // also add fault tolerant for casting property_id
        $property_id = 0;
        try{
            $property_id = (integer)$id;
        }catch(Exception $e){
            return redirect()->route('show_property');   
        }
        
        $p = Property::findOrFail($property_id);
        if(Auth::id() !== $p->user_id){
            return redirect()->route('show_property');
        }

        // Validated show form
        return view('property.expenses.add_expenses',['property'=>$p,'property_id'=>$property_id]);
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
    public function store($id,Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'amount'=>'required|numeric',
            'payment_date'=>'required',
            'status'=>'required|numeric',
        ]);
        
        $property_id = 0;
        try{
            $property_id = (integer)$id;
        }catch(Exception $e){
            return redirect()->back();
        }

        if($property_id <=0){
            return redirect()->back();
        }

        Outcome::create([
            'property_id'=>$property_id,
            'user_id'=>Auth::id(),
            'name'=>Input::get('name'),
            'payment_date'=>Input::get('payment_date'),
            'amount'=>Input::get('amount'),
            'status'=>Input::get('status')
        ]);

        /* returning back to property details 
        using session to tell JS to open tab*/
        return redirect()
        ->route('show_detail_property',['id'=>$id])
        ->with('open_tab','pengeluaran');
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
    public function edit($property_id,$expenses_id)
    {
        $p = Property::where('user_id',Auth::id())
                    ->where('property_id',$property_id)
                    ->get()->first();

        $o = Outcome::where('user_id',Auth::id())
                    ->where('property_id',$property_id)
                    ->where('outcome_id',$expenses_id)
                    ->get()->first();

        return view('property.expenses.edit_expenses',['property'=>$p,'outcome'=>$o]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$expenses_id)
    {
        $this->validate($request,[
            'name'=>'required',
            'amount'=>'required|numeric',
            'payment_date'=>'required',
            'status'=>'required|numeric',
        ]);

        Outcome::where('outcome_id',$expenses_id)
                ->where('user_id',Auth::id())
                ->where('property_id',$id)->update([
                    'name'=>Input::get('name'),
                    'payment_date'=>Input::get('payment_date'),
                    'amount'=>Input::get('amount'),
                    'status'=>Input::get('status')
                ]);
        /* returning back to property details 
        using session to tell JS to open tab*/
        return redirect()
        ->route('show_detail_property',['id'=>$id])
        ->with('open_tab','pengeluaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$expenses_id)
    {
        Outcome::destroy($expenses_id);
        /* returning back to property details 
        using session to tell JS to open tab*/
        return redirect()
        ->route('show_detail_property',['id'=>$id])
        ->with('open_tab','pengeluaran');
    }
}
