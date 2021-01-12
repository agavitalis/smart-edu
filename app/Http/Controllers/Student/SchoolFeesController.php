<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SchoolFeesController extends Controller
{
    public function generate_invoice(){


        $levels = DB::table('levels')->get();
        $sessions = DB::table('sessions')->get();

        return view("students.school_fees", compact('levels','sessions'));
    }
}
