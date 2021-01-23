<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolFees;
use App\Models\SchoolFeeInvoice;
use Auth;
use DB;

class SchoolFeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generate_invoice(Request $request){

        if($request->isMethod('GET')){

            $levels = DB::table('levels')->get();
            $sessions = DB::table('sessions')->get();
    
            return view("students.school_fees", compact('levels','sessions'));
        }

        //check if there was an invoice there
        $school_fee_invoice = SchoolFeeInvoice::where(['user_id'=>Auth::user()->id, 'session'=> $request->session,'level'=>$request->level,'term'=>$request->term])->first();
        if($school_fee_invoice == null){

            $invoice_number = Auth::user()->username."-".$request->session."-".$request->level."-".$request->term;
            $school_fees = SchoolFees::where(['session'=> $request->session,'level'=>$request->level,'term'=>$request->term])->first();
           //dd($school_fees);
            if($school_fees == null){
                return back()->with('error','School Fees have not been assigned for this session');
            }

            $school_fee_invoice = SchoolFeeInvoice::create([
                "invoice_number"=> $invoice_number,
                "session" => $school_fees->session,
                "level" => $school_fees->level,
                "term" => $school_fees->term,
                "amount"  => $school_fees->amount,
                "user_id" => Auth::user()->id,
            ]);
           
        }
        
        return view('students.school_fees_invoice',compact('school_fee_invoice'));
        
        
    }

    public function complete_payment(Request $request){

        try {

            $update = SchoolFeeInvoice::where(['user_id'=>Auth::user()->id, 'session'=> $request->session,'level'=>$request->level,'term'=>$request->term])
            ->update(['status'=>'PAID','amount_paid'=>$request->amount_paid]);

            return response()->json(array(
                'code'=> 200,
                'message'=> $request->all(),
            ));

        } catch (Exception $e) {
            
            return response()->json(array(
                'code'=> 500,
                'message'=> $e->getMessage(),
            ));
        }
       
    }

    public function school_fees_recipts(Request $request){

        $school_fees_recipts = SchoolFeeInvoice::where(['user_id'=>Auth::user()->id, 'status'=>'PAID'])->get();
        return view('students.school_fees_lists',compact('school_fees_recipts'));

    }
}
