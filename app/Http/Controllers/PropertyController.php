<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;
use App\Outcome;
use App\Contract;
use App\PaymentTerm;
use App\Payment;
use App\Tenant;
use App\Image;
use File;
use App\PropertyDocument;
use Webpatser\Uuid\Uuid;

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
    public function deleteFile($id, $remove_file, $property_id) 
    {   
        File::delete(substr(base64_decode($remove_file), 1));
        PropertyDocument::where('property_document_id',$id)->delete();
        return $this->show($property_id);
    }

    public function deleteImage($id, $remove_file, $property_id) 
    {   
        File::delete(substr(base64_decode($remove_file), 1));
        Image::where('image_id',$id)->delete();
        return $this->show($property_id);
    }

    public function show($id)
    {
        $property=Property::where('property_id',$id)
                    ->where('user_id',Auth::id())
                    ->get()
                    ->first();
        
        if($property==null){
            return redirect()->route('show_property');
        }

        $contracts = Contract::where('property_id',$id)
                    ->with(['tenant'=>function($query){
                        return $query;
                    }])->get();

        $outcome = Outcome::where('user_id',Auth::id())
                    ->where('property_id',$property->property_id)
                    ->get();

        $images = Image::where('property_id',$property->property_id)
                    ->get();
        
        $property_documents = PropertyDocument::where('property_id',$property->property_id)
                    ->get();
                    

        $payments =Payment::with(['paymentTerm'=>function($query) use ($id){
            return $query
            ->with(['contract'=>function($query1) use ($id){
                return $query1->where('property_id',$id)
                ->with(['tenant'=>function($query2) {
                    return $query2;
                }]);
            }]);
        }])->get();
            
        return view('property.show_detail',['property'=>$property,'outcome'=>$outcome,'contracts'=>$contracts, 'payments'=>$payments, 'images'=>$images, 'property_documents'=>$property_documents]);
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

    public function upload($property_id){
        if (Input::hasFile('file')) {

            $file = Input::file('file');
            $newname = (string)Uuid::generate() .".png";
            $file->move('uploads', $newname);
            $path = "/uploads/".$newname;

            Image::create([
                'property_id'=>$property_id,
                'path'=>$path
            ]);
        }
        return redirect()->route('show_detail_property', ['id' => $property_id]);
    }

    public function uploadDocument($property_id){
        if (Input::hasFile('file')) {
            
            $file = Input::file('file');
            $description = Input::get('description');
            if ($description == null) {
                $description = "";
            }
            $newname = (string)Uuid::generate();
            $file->move('uploadDocuments', $newname);
            $path = "/uploadDocuments/".$newname;

            PropertyDocument::create([
                'property_id'=>$property_id,
                'description'=>$description,
                'path'=>$path
            ]);
        }
        return redirect()->route('show_detail_property', ['id' => $property_id]);
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

    function get_file_extension($file_name) {
        return substr(strrchr($file_name,'.'),1);
    }
}
