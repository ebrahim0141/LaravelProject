<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class SalaryController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Add salary are here---------------
    public function AddAdvancedSalary()
    {
      return view('advanced_salary');
    }

   //All Salary Are Here-----------------
    public function AllSalary()
    {
      $salary=DB::table('advance_salaries')
             ->join('employees','advance_salaries.emp_id','employees.id')
             ->select('advance_salaries.*','employees.name','employees.salary','employees.photo')
             ->orderBy('id','DESC')
             ->get();
    	return view('all_advanced_salary', compact('salary'));
    }

  //Insert Advanced salary here---------
    public function InsertAdvanced(Request $request)
    {
    	$month=$request->month;
    	$emp_id=$request->emp_id;
   	
   		$advanced=DB::table('advance_salaries')
   		          ->where('month',$month)
   		          ->where('emp_id',$emp_id)
   		          ->first();

   		if ($advanced === NULL) {
   		    $data=array();
	    	$data['emp_id']=$request->emp_id;
	    	$data['month']=$request->month;
	    	$data['advanced_salary']=$request->advanced_salary;
	    	$data['year']=$request->year;

    	 $advanced=DB::table('advance_salaries')->insert($data);
    	  if ($advanced) {
                 $notification=array(
                 'messege'=>'Successfully Advanced Paid ',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->back()->with($notification);
             }      
   		    }else{
   		    	$notification=array(
                 'messege'=>'Oopss !! Allready advanced Paid in this month! ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back()->with($notification);
   		    }          	
    }

  //Pay salary are here-------------
    public function PaySalary()
    {

        $employee=DB::table('employees')->get();
        return view('pay_salary', compact('employee')); 

    }

    
}
