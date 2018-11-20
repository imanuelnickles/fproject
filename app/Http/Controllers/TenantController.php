<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Tenant;
use Webpatser\Uuid\Uuid;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find all related tenant
        $tenant = Tenant::where('user_id',Auth::id())->get();
        return view('tenant.show_tenant_data_tables',['tenant'=>$tenant]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant.add_tenant');
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
            'title'=>'required',
            'first-name'=>'required|min:3|max:20',
            'last-name'=>'required|min:3|max:20',
            'email'=>'required|email',
            'mobile'=>'required|regex:/(0)[0-9]{10}/',
            'phone'=>'required|regex:/(0)[0-9]{10}/',
            'dob'=>'required',
            'id-number'=>'required|min:16|max:16',
            'id-pic'=>'required',
            'address'=>'required',
            'notes'=>'max:144'
        ]);
        
        $file =  Input::file('id-pic');
        $newname = (string)Uuid::generate().".".$file->getClientOriginalExtension();;
        $file->move('uploads', $newname);
        $path = "/uploads/".$newname;
        
        try{
            Tenant::create([
                'user_id'=>Auth::id(),
                'title'=>Input::get('title'),
                'first_name'=>Input::get('first-name'),
                'last_name'=>Input::get('last-name'),
                'email'=>Input::get('email'),
                'mobile'=>Input::get('mobile'),
                'phone'=>Input::get('phone'),
                'dob'=>Input::get('dob'),
                'id_number'=>Input::get('id-number'),
                'id_picture'=>$path,
                'address'=>Input::get('address'),
                'notes'=>Input::get('notes')
            ]);
        }catch(Exception $e){
            // IMPROVEMENT
            // show error msg to client using session flash
            // instead of using back
            return back();
        }
        
        return redirect()->route('show_tenant');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant=Tenant::where('tenant_id',$id)
                    ->where('user_id',Auth::id())
                    ->get()
                    ->first();
        
        if($tenant==null){
            return redirect()->route('show_tenant');
        }
        return view('tenant.show_detail',['tenant'=>$tenant]);
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
        $this->validate($request,[
            'title'=>'required',
            'first-name'=>'required|min:3|max:20',
            'last-name'=>'required|min:3|max:20',
            'email'=>'required|email',
            'mobile'=>'required|regex:/(0)[0-9]{10}/',
            'phone'=>'required|regex:/(0)[0-9]{10}/',
            'dob'=>'required',
            'id-number'=>'required|min:16|max:16',
            'address'=>'required',
            'notes'=>'max:144'
        ]);

        $t = Tenant::where('tenant_id',$id)
            ->where('user_id',Auth::id());
        
        if($t==null){
            return back();
        }
        
        $file =  Input::file('id-pic');
        $newname = (string)Uuid::generate().".".$file->getClientOriginalExtension();;
        $file->move('uploads', $newname);
        $path = "/uploads/".$newname;

        $t->update([
            'title'=>Input::get('title'),
            'first_name'=>Input::get('first-name'),
            'last_name'=>Input::get('last-name'),
            'email'=>Input::get('email'),
            'mobile'=>Input::get('mobile'),
            'phone'=>Input::get('phone'),
            'dob'=>Input::get('dob'),
            'id_number'=>Input::get('id-number'),
            'id_picture'=>$path,
            'address'=>Input::get('address'),
            'notes'=>Input::get('notes')
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tenant::destroy($id);
        return redirect()->route('show_tenant');
    }
}
