<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property = Property::where('user_id',Auth::id())->get();
        return view('property.show_property',['property'=>$property]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property.add_property');
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
            'name'=>'required',
            'address'=>'required',
            'total_floor'=>'required|numeric',
            'total_bedrooms'=>'required|numeric',
            'tax'=>'required|numeric',
            'purchase_date'=>'required',
            'valuation'=>'required|numeric',
            'purchase_price'=>'required|numeric',
            'rent_price'=>'required|numeric',
        ]);
        
        Property::create([
            'user_id'=>Auth::id(),
            'name'=>Input::get('name'),
            'address'=>Input::get('address'),
            'country'=>Input::get('country'),
            'city'=>Input::get('city'),
            'post_code'=>Input::get('post_code'),
            'property_type'=>Input::get('property_type'),
            'total_floor'=>Input::get('total_floor'),
            'total_bedrooms'=>Input::get('total_bedrooms'),
            'building_area'=>Input::get('building_area'),
            'surface_area'=>Input::get('surface_area'),
            'purchase_date'=>Input::get('purchase_date'),
            'purchase_price'=>Input::get('purchase_price'),
            'tax'=>Input::get('tax'),
            'valuation'=>Input::get('valuation'),
            'rent_price'=>Input::get('rent_price'),
            'occupied'=>Input::get('occupied'),
            'notes'=>Input::get('notes')
        ]);
        return redirect()->route('show_property');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property=Property::findOrFail($id);
        return view('property.show_detail',['property'=>$property]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property=Property::findOrFail($id);
        return view('property.edit_property',['property'=>$property]);
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
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'total_floor'=>'required|numeric',
            'total_bedrooms'=>'required|numeric',
            'tax'=>'required|numeric',
            'purchase_date'=>'required',
            'valuation'=>'required|numeric',
            'purchase_price'=>'required|numeric',
            'rent_price'=>'required|numeric',
        ]);

        Property::where('property_id',$id)->update([
            'name'=>Input::get('name'),
            'address'=>Input::get('address'),
            'country'=>Input::get('country'),
            'city'=>Input::get('city'),
            'post_code'=>Input::get('post_code'),
            'property_type'=>Input::get('property_type'),
            'total_floor'=>Input::get('total_floor'),
            'total_bedrooms'=>Input::get('total_bedrooms'),
            'building_area'=>Input::get('building_area'),
            'surface_area'=>Input::get('surface_area'),
            'purchase_date'=>Input::get('purchase_date'),
            'purchase_price'=>Input::get('purchase_price'),
            'tax'=>Input::get('tax'),
            'valuation'=>Input::get('valuation'),
            'rent_price'=>Input::get('rent_price'),
            'occupied'=>Input::get('occupied'),
            'notes'=>Input::get('notes')
        ]);
        return redirect()->route('show_detail_property', ['id' => $id]);
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
