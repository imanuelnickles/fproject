<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;
use App\Contract;
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
}
