<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportIncomeExpense()
    {
        return view('report.report_income_expense');
		}
		
		public function reportIncomeExpenseView(Request $request)
    {
				$start = $request->get('start');
				$end = $request->get('end');

				$rawQuery = "
				select * from (
					select 
						p.property_id, 
						concat(p.name, ', ', p.address,', ', p.city,', ', p.country) as property,
						o.payment_date as date,
						o.name as description,
						FORMAT(o.amount, 0) as pengeluaran,
					
						'' as pemasukan
					from properties as p
					inner join outcomes as o on o.property_id = p.property_id
					
					where o.status = 1 and p.user_id = ".Auth::id()." and o.payment_date >= '".$start."' and o.payment_date <= '".$end."'
					
					union all
					select 
						p.property_id, 
						concat(p.name, ', ', p.address,', ', p.city,', ', p.country) as property,
						y.payment_date as date,
						concat(t.title,' ', t.first_name,' ', t.last_name, ' - ', y.payment_type) as description,
						'' as pengeluaran,
						FORMAT(y.amount, 0) as pemasukan
					from properties as p 
					inner join contracts as c on c.property_id = p.property_id
					inner join payment_terms as pt on pt.contract_id = c.contract_id
					inner join payments as y on y.payment_term_id = pt.payment_term_id
					left join tenants as t on y.tenant_id = t.tenant_id
					where p.user_id = ".Auth::id()." and y.payment_date >= '".$start."' and y.payment_date <= '".$end."'
					) as a 
					
					order by a.property_id, a.date
				";
				
				$rawTotal = "
					select FORMAT(sum(t.pemasukan),0) as pemasukan, FORMAT(sum(t.pengeluaran),0) as pengeluaran, FORMAT(sum(t.total),0) as total from (
						select sum(p.amount) as pemasukan, 0 as pengeluaran, sum(p.amount) as total from payments as p
						where p.payment_date >= '".$start."' and p.payment_date <= '".$end."'
						union all
						select 0 as pemasukan, sum(o.amount) as pengeluaran, (sum(o.amount) * -1) as total from outcomes o
						where o.payment_date >= '".$start."' and o.payment_date <= '".$end."' and o.status = 1
					) as t
				";
				$report = DB::select($rawQuery);
				$total = DB::select($rawTotal);

        return view('report.report_income_expense_output',['report'=>$report, 'start'=>$start, 'end'=>$end, 'total'=>$total[0]]);
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
