<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;
use App\Contract;
use App\PaymentTerm;
use App\Payment;
use App\Tenant;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $payment_term_id)
    {
        if($id=="" || $id == "0" || $payment_term_id=="" || $payment_term_id == "0"){
            return redirect()->route('show_property');
        }
        
        // need to check if property_id is belongs to auth user_id.
        // also add fault tolerant for casting property_id
        $property_id = 0;
        try{
            $property_id = (integer)$id;
            $payment_term_id = (integer)$payment_term_id;
        }catch(Exception $e){
            return redirect()->route('show_property');   
        }
        
        $p = Property::findOrFail($property_id);
        if(Auth::id() !== $p->user_id){
            return redirect()->route('show_property');
        }

        $payment_term = PaymentTerm::where('payment_term_id', $payment_term_id)
        ->with(['contract'=>function($query){
            return $query
            ->with(['tenant'=>function($query2){
              return $query2;
            }]);
        }])->get()->first();

        // Validated show form
        return view('payment.add_payment',['property'=>$p, 'payment_term'=>$payment_term]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $this->validate($request,[
        'notes'=>'required',
        'payment_date'=> "required|date",
      ]);

      Payment::create([
        'tenant_id'=>Input::get('tenant_id'),
        'payment_term_id'=>Input::get('payment_term_id'),
        'payment_type'=>Input::get('payment_type'),
        'amount'=>Input::get('amount'),
        'payment_date'=>Input::get('payment_date'),
        'notes'=>Input::get('notes')
      ]);

      $t = PaymentTerm::where('payment_term_id',Input::get('payment_term_id'));

      $t->update([
        'payment_date'=>Input::get('payment_date')
      ]);
      return redirect()->route('show_detail_property', ['id' => Input::get('property_id')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $payment_term_id, $payment_id)
    {
      if($id=="" || $id == "0" || $payment_term_id=="" || $payment_term_id == "0"|| $payment_id=="" || $payment_id == "0"){
        return redirect()->route('show_property');
      }
      
      // need to check if property_id is belongs to auth user_id.
      // also add fault tolerant for casting property_id
      $property_id = 0;
      try{
          $property_id = (integer)$id;
          $payment_term_id = (integer)$payment_term_id;
      }catch(Exception $e){
          return redirect()->route('show_property');   
      }
      
      $p = Property::findOrFail($property_id);
      if(Auth::id() !== $p->user_id){
          return redirect()->route('show_property');
      }

      $payment_term = PaymentTerm::where('payment_term_id', $payment_term_id)
        ->with(['contract'=>function($query){
            return $query
            ->with(['tenant'=>function($query2){
              return $query2;
            }]);
        }])->get()->first();

      $payment = Payment::where('payment_id', $payment_id)->first();
      return view('payment.show_payment',['property'=>$p, 'payment'=>$payment, 'payment_term'=>$payment_term]);
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
}
