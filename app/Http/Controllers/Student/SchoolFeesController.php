<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolFees;
use DB;

class SchoolFeesController extends Controller
{
    public function generate_invoice(Request $request){

        if($request->isMethod('GET')){

            $levels = DB::table('levels')->get();
            $sessions = DB::table('sessions')->get();
    
            return view("students.school_fees", compact('levels','sessions'));
        }

        //pull the fees assigned to the specified selections
        $school_fees = SchoolFees::where(['session'=> $request->session,'level'=>$request->level,'term'=>$request->term])->first();
        //check if this invoice have been generated previously
        
        if($school_fees == null){
            return back()->with('error','School Fees have not been assigned for this session');
        }

        return view('students.school_fees_invoice',compact('school_fees'));
        
    }

    public function generateInvoiceNumber()
    {

        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
        . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $number = substr(str_shuffle($pin), 10);
        return "INV" . $number;

    }
}
