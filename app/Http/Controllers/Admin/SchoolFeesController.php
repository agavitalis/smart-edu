<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolFees;
use DB;

class SchoolFeesController extends Controller
{
    public function set_fees(Request $request){

        if ($request->isMethod('GET')) {

            $levels = DB::table('levels')->get();
            $sessions = DB::table('sessions')->get();
            $fees = DB::table('school_fees')->get();
            return view("admin.school_fees.set_fees", compact('levels','sessions','fees'));

        }else if ($request->isMethod('POST')) {
           //check if you have set fees for this term, session and level

            $check_fees = SchoolFees::where(['session'=> $request->session, 'level'=>$request->level, 'term'=>$request->term])->first();
            if($check_fees == null){
                SchoolFees::create(['amount'=>$request->amount, 'session'=> $request->session, 'level'=>$request->level, 'term'=>$request->term]);
                return back()->with('success', 'SchoolFees Successfully registered');
            }else{
                return back()->with('error', 'Duplicate School Fees');
            }

        }

    }

    public function delete_fees(Request $request){

        if ($request->isMethod('POST')) {
           
            SchoolFees::where(['id'=>$request->id])->delete();
            return back()->with('success', 'SchoolFees Successfully Deleted');

        }

    }
}
