<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;
use App\Contract;
use App\PaymentTerm;
use App\Tenant;

class ContractController extends Controller
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
    public function create($id)
    {
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

        $tenant = Tenant::where('user_id',Auth::id())->get();

        // Validated show form
        return view('contract.add_contract',['property'=>$p,'property_id'=>$property_id, 'tenant'=>$tenant]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validation = $this->validate($request,[
            'property_id'=>'required',
            'tenant_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'contract_date'=>'required',
            'amount.*'=> "required",
            'deadline.*'=> "required|date|distinct",
        ]);
        
        $contract = Contract::create([
            'property_id'=>Input::get('property_id'),
            'tenant_id'=>Input::get('tenant_id'),
            'start_date'=>Input::get('start_date'),
            'end_date'=>Input::get('end_date'),
            'contract_date'=>Input::get('contract_date'),
        ]);
        
        $amounts = Input::get('amount.*');
        $deadlines = Input::get('deadline.*');
        
        for ($i= 0; $i<count($amounts);$i++) {
            PaymentTerm::create([
                'contract_id'=>$contract->contract_id,
                'amount'=>$amounts[$i],
                'deadline'=>$deadlines[$i],
                'payment_date'=>null
            ]);
        }

        return redirect()->route('show_detail_property', ['id' => Input::get('property_id')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $contract_id)
    {
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
        return view('contract.show_contract',['property'=>$p,'property_id'=>$property_id]);
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
