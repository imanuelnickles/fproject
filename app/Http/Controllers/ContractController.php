<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Property;
use App\Contract;
use App\PaymentTerm;
use App\Tenant;
use App\ContractTemplate;
use Carbon\Carbon;

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
        // 2. Get Contract Data (for injection)
        // 3. Generate UUID (for generated file) if not exists in DB
        // 4. Update Contract (contract_template)

        // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        // $section = $phpWord->addSection();
        // $name = "Imanuel";
        
        // $c = ContractTemplate::all();
        // $description = $c[0]->format;
        // $description = str_replace('$name',$name,$description);

        // $section->addText($description);

        // $version = 'Word2007';
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, $version);

        // try {
        //     $objWriter->save(storage_path('helloWorld.docx'));
        // } catch (Exception $e) {
        // }


        // return response()->download(storage_path('helloWorld.docx'));
        $this->replacePlaceholder();
        dd("Sabar");
    }

    public function replacePlaceholder(){
        $template_file_name = storage_path('helloWorld.docx');
 
        $rand_no = rand(111111, 999999);
        $fileName = "results_" . $rand_no . ".docx";
        
        $folder   = storage_path("results_");
        $full_path = $folder . '/' . $fileName;
        
       
            if (!file_exists($folder))
            {
                mkdir($folder);
            }       

            //Copy the Template file to the Result Directory
            //copy($template_file_name, $full_path);
        //     // dd("stop");
        //     // add calss Zip Archive
        //     // $zip_val = new ZipArchive;
        //     $zip_val = new \PhpOffice\PhpWord\Shared\ZipArchive();
        //     //Docx file is nothing but a zip file. Open this Zip File
        //     if($zip_val->open($full_path) == true)
        //     {
        //         // In the Open XML Wordprocessing format content is stored.
        //         // In the document.xml file located in the word directory.
                
        //         $key_file_name = 'word/document.docx';
        //         $message = $zip_val->getFromName($key_file_name);                
                            
        //         $timestamp = date('d-M-Y H:i:s');
                
        //         // this data Replace the placeholders with actual values
        //         $message = str_replace("client_full_name",      "onlinecode org",       $message);
        //         $message = str_replace("client_email_address",  "ingo@onlinecode.org",  $message);
        //         $message = str_replace("date_today",            $timestamp,             $message);      
        //         $message = str_replace("client_website",        "<a clas>", $message);      
        //         $message = str_replace("client_mobile_number",  "+1999999999",          $message);
                
        //         //Replace the content with the new content created above.
        //         $zip_val->addFromString($key_file_name, $message);
        //         $return =$zip_val->close();
        //         if ($return==TRUE){
        //             echo "Success!";
        //         }
        //     }
        // }
        // catch (Exception $exc) 
        // {
        //     $error_message =  "Error creating the Word Document";
        //     var_dump($exc);
        // }
        $template = new \PhpOffice\PhpWord\TemplateProcessor($template_file_name);
        $template->setValue("client_full_name","nakon");
        $template->saveAs($full_path); 


}
}
