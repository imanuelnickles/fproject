<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;
use App\Contract;
use App\PaymentTerm;
use App\Tenant;
use App\User;
use App\ContractTemplate;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

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
        if(Auth::id() != $p->user_id){
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
            'notes'=>'required',
            'contract_date'=>'required',
            'amount.*'=> "required",
            'deadline.*'=> "required|date|distinct",
            'notes'=>"required",
        ]);
        
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');
        $property_id = Input::get('property_id');

        $contract = Contract::create([
            'property_id'=>$property_id,
            'tenant_id'=>Input::get('tenant_id'),
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'notes'=>Input::get('notes'),
            'contract_date'=>Input::get('contract_date'),
            'notes'=>Input::get('notes'),
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

        // Also include mechanism for update the property status
        $now = Carbon::now()->toDateString();
        if($start_date <= $now && $end_date >= $now){
            $p = Property::where('property_id',$property_id);
            $p->update([
                'occupied'=>1,
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

        
        $contract = Contract::where('contract_id',$contract_id)
                    ->with(['tenant'=>function($query){
                        return $query;
                    }])->first();
        $payment_term = PaymentTerm::where('contract_id', $contract_id )
                        ->with(['payment'=>function($query3){
                            return $query3->where('deleted_at',null);
                        }])
                        ->get();

        if ($contract->notes == "") {
            $contract->notes = "-";
        }
        return view('contract.show_contract',['property'=>$p,'property_id'=>$property_id, 'contract'=>$contract, 'payment_term'=>$payment_term]);
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

    public function generateContract($id, $contract_id)
    {
        // Flow
        // 1. Check Template Exists
        $ct = ContractTemplate::where('user_id',Auth::id())->get()->first();
        if($ct==null){
            return redirect()->route('add_edit_template_contract');
        }

        // 2. Get Contract Data (for injection)
        $cn = Contract::findOrFail($contract_id);
        $tn =  Tenant::findOrFail($cn->tenant_id);
        $prop = Property::findOrFail($cn->property_id);
        $user = User::findOrfail(Auth::id());
        $pt = PaymentTerm::where('contract_id',$contract_id)->orderBy('contract_id')->get();

        // Get tenant name


        $template_file_name = storage_path($ct->contract_template);
        $folder   = storage_path("temp_contract_temp");
        if (!file_exists($folder))
        {
            mkdir($folder);
        }
        
        $newname = (string)Uuid::generate();
        // For now only .docx template supported (2007-newer)
        $full_path = $folder . '/' . $newname.'.docx';

        // Open template with PHPWord Template Processor
        $template = new \PhpOffice\PhpWord\TemplateProcessor($template_file_name);
        // Replace pre-defined varible in word template
        // Defined as many as you like :)
        /* 
        1. ${user_name} | ${tenant_name}
        2. ${user_gender} | ${tenant_gender} | 
        3. ${user_id_number} | ${tenant_id_number}
        4. ${user_bod} | ${tenant_bod}
        5. ${user_mobile} | ${tenant_mobile} 
        6. ${user_phone} | ${tenant_phone}
        7. ${user_address} | ${tenant_address}
        8. ${contract_start_date} | ${contract_end_date}
        9. ${property_name}
        10. ${property_address}
        11. ${property_area}
        12. ${property_type}
        14. ${property_rent_price}
        15. ${property_down_payment} | ${property_down_payment_deadline}
        16. ${user_bank}
        */
        $variable = [
            // User
            "user_name"=>$user->name,
            //"user_gender"=>"",
            //"user_id_number"=>"user_id_number",
            //"user_bod"=>"",
            //"user_mobile"=>"",
            //"user_phone"=>"",
            //"user_address"=>"",
            //"user_bank"=>"",
            // Tenant
            "tenant_name"=>$tn->title." ".$tn->first_name." ".$tn->last_name,
            "tenant_gender"=>"",
            "tenant_id_number"=>$tn->id_number,
            "tenant_bod"=>$tn->dob,
            "tenant_mobile"=>$tn->mobile,
            "tenant_phone"=>$tn->phone,
            "tenant_address"=>$tn->address,
            // Contract
            "contract_start_date"=>$cn->start_date,
            "contract_end_date"=>$cn->end_date,
            // Property
            "property_name"=>$prop->name,
            "property_address"=>$prop->address,
            "property_area"=>$prop->building_area,
            "property_surface_area"=>$prop->surface_area,
            "property_type"=>$prop->property_type,
            "property_rent_price"=>$prop->rent_price,
            "property_down_payment"=>$pt[0]->amount, //known as first payment
            "property_down_payment_deadline"=>$pt[0]->deadline,
        ];

        // Loop through variable (K/V)
        foreach($variable as $key => $value){
            $template->setValue($key,$value);
        }

        // Inject varible to template.
        $template->saveAs($full_path);

        // Perform download response
        return response()->download($full_path);

    }

    public function showTemplate(){
        $ct = ContractTemplate::where('user_id',Auth::id())->get()->first();
        $is_uploaded = ($ct != null);
        return view('contract/contract_template',['is_uploaded'=>$is_uploaded]);
    }

    public function saveTemplate(Request $request){
        $this->validate($request,[
            'contract_template' => "required",
        ]);

        $folder   = storage_path("contract_template");
        if (!file_exists($folder))
        {
            mkdir($folder);
        }

        $file = Input::file('contract_template');
        $newname = (string)Uuid::generate().".".$file->getClientOriginalExtension();
        $file_dest = 'contract_template/' . $newname;
        $file->move($folder,$newname);

        $exists = ContractTemplate::where('user_id',Auth::id())->get()->first();
        if($exists==null){
            ContractTemplate::create([
                'user_id'=>Auth::id(),
                'contract_template'=>$file_dest,
            ]);
        }else{
            ContractTemplate::find($exists->contract_template_id)->update([
                'contract_template'=>$file_dest,
            ]);
        }
        return back();
    }
}
