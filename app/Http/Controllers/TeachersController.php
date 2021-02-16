<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Result;
use App\Models\User;
use Auth;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ResultUploadExcelExport;
use App\Imports\ResultImport;

class TeachersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function teacherdashboard()
    {
        //gem me the list of admin, students and teachers
        $myclasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->count();
        $mysubjects = DB::table('assignsubjects')->where('teacher_name', Auth::user()->name)->count();
        $myresults = DB::table('results')->where('subject_teacher', Auth::user()->name)->count();
        // $subjects=DB::table('subjects')->count();
        //dd($students);
        return view('teachers.dashboard', compact('myclasses', 'mysubjects', 'myresults'));
    }

    public function teacherprofile()
    {
        return view('teachers.profile');
    }

    public function editprofile(Request $update)
    {

        if ($update->isMethod('POST')) {
            if ($update->action == 'basic') {
                //since we are updating, we done insta
                $user = User::find(Auth::user()->id);
                $user->phone = $update->phone;
                $user->gender = $update->gender;

                $user->save();
                return back()->with('success', 'Profile successfully updated');

            } elseif ($update->action == 'background') {
                //since we are updating, we done insta
                $user = User::find(Auth::user()->id);
                $user->country = $update->country;
                $user->address = $update->address;
                $user->lga = $update->lga;
                $user->state = $update->state;

                $user->save();
                return back()->with('success', 'Profile successfully updated');

            } elseif ($update->action == 'final') {

                $user = User::find(Auth::user()->id);
                $user->skills = $update->skills;
                $user->intrest = $update->intrest;
                $user->quotes = $update->quotes;

                $user->postsheld = $update->postsheld;
                $user->dateofbirth = $update->dateofbirth;

                $user->save();
                return back()->with('success', 'Profile successfully updated');
            } else {
                return back()->with('error', 'We dont know what you are talking about');
            }

        } elseif ($update->isMethod('GET')) {
            return view('teachers.editprofile');
        }
    }

    public function mysubjects()
    {
        $mysubjects = DB::table('assignsubjects')->where('teacher_name', Auth::user()->name)->get();
        return view('teachers.mysubjects', compact('mysubjects'));
    }

    public function mysubjectsresult(Request $request)
    {
        if ($request->isMethod('GET')) {
            $klasses = DB::table('klasses')->get();
            $levels = DB::table('levels')->get();
            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('subjects')->get();
            $results = DB::table('results')->where('subject_teacher', Auth::user()->name)->limit(50)->get();
            return view('teachers.mysubjectresult', compact('klasses', 'levels', 'sessions', 'terms', 'results', 'subjects'));
        } elseif ($request->isMethod('POST')) {
            //now selecting results based on selection
            $results = DB::table('results')->where([
                'class' => $request->klass, 'teacher_username' => Auth::user()->username, 'term' => $request->term, 'level' => $request->level,
                'session' => $request->session, 'subject' => $request->subject])->get();
            //dd($request);
            $klasses = DB::table('klasses')->get();
            $levels = DB::table('levels')->get();
            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('subjects')->get();

            return view('teachers.mysubjectresult', compact('klasses', 'levels', 'sessions', 'terms', 'results', 'subjects'));

        }
    }

    public function deletesubresult(Request $request)
    {
        if ($request->isMethod('GET')) {
            $check = DB::table('assignsubjects')->where('teacher_name', Auth::user()->name)->count();
            //that is if he doesnt have any class assigned
            if ($check < 1) {
                return back()->with('error', 'You have no subjects assigned to you');
            }
            $klasses = DB::table('klasses')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('assignsubjects')->where('teacher_name', Auth::user()->name)->get();
            $results = DB::table('results')->where(['subject_teacher' => Auth::user()->name, 'approved' => 0])->limit(50)->get();
            return view('teachers.deletesubresult', compact('klasses', 'sessions', 'terms', 'results', 'subjects'));
        } elseif ($request->isMethod('POST')) {
            //now selecting results based on selection
            $getall = DB::table('results')->where([
                'class' => $request->klass, 'teacher_username' => Auth::user()->username, 'term' => $request->term,
                'session' => $request->session, 'subject' => $request->subject]);
            $count = $getall->count();
            if ($count < 1) {
                return back()->with('error', 'No results found');
            }

            $results = $getall->get();
            //dd($results);

            foreach ($results as $key => $result) {

                $deleting = result::find($result->id);
                $deleting->delete();

            }

            return back()->with('success', 'You have successfully deleted this results');

        }
    }

    public function myclasses(Request $request)
    {
        if ($request->isMethod('GET')) {
            $check = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->count();
            //that is if he doesnt have any class assigned
            if ($check < 1) {
                return back()->with('error', 'You have no classes assigned to you');
            }
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $first = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->first();

            $users = DB::table('users')->where('class', $first->name)->get();
            $terms = DB::table('terms')->get();
            return view('teachers.myclasses', compact('klasses', 'users', 'terms'));
        } elseif ($request->isMethod('POST')) {
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            //$first=DB::table('assignclasses')->where('teacher_name',Auth::user()->name)->first();
            $terms = DB::table('terms')->get();
            $users = DB::table('users')->where([
                'class' => $request->klass, 'term' => $request->term])->get();

            return view('teachers.myclasses', compact('klasses', 'users', 'terms'));
        }
    }

    public function myclassresult(Request $request)
    {
        if ($request->isMethod('GET')) {
            //check if I was assigned a class
            $check = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->count();
            //that is if he doesnt have any class assigned
            if ($check < 1) {
                return back()->with('error', 'You have no classes assigned to you');
            }
            //get my first assigned class
            $first = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->first();
            //show him all first, then he chooses
            $results = DB::table('results')->where('class', $first->name)->get();

            //select sessions
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $levels = DB::table('levels')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('subjects')->get();

            return view('teachers.myclassresult', compact('results', 'klasses', 'levels', 'sessions', 'terms', 'subjects'));
        } elseif ($request->isMethod('POST')) {
            //dd($request);
            //select result based on his specifications
            $results = DB::table('results')->where([
                'class' => $request->klass, 'teacher_username' => Auth::user()->username, 'term' => $request->term,
                'session' => $request->session, 'subject' => $request->subject])->get();
            // dd($results);

            //select sessions
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $levels = DB::table('levels')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('subjects')->get();

            return view('teachers.myclassresult', compact('results', 'klasses', 'levels', 'sessions', 'terms', 'subjects'));

        }
    }

    public function generalclasslist(Request $request)
    {
        if ($request->isMethod('GET')) {
            $klasses = DB::table('klasses')->get();
            $first = DB::table('klasses')->first();

            $users = DB::table('users')->where('class', $first->name)->get();
            return view('teachers.generalclasslist', compact('klasses', 'users'));
        } elseif ($request->isMethod('POST')) {
            $klasses = DB::table('klasses')->get();
            //$first=DB::table('assignclasses')->where('teacher_name',Auth::user()->name)->first();
            $users = DB::table('users')->where([
                'class' => $request->klass])->get();

            return view('teachers.generalclasslist', compact('klasses', 'users'));
        }
    }

    //download result sheet
    public function resultsheet(Request $request, $type)
    {
        return Excel::download(new ResultUploadExcelExport, 'result_sheet_sample.xlsx');
    }

    // /here I read the excelfile
    public function uploadresults(Request $request)
    {
        if ($request->isMethod('GET')) {

            //select shbjects where he is the coordinator and all the classes
            $subjects = DB::table('assignsubjects')->where(['teacher_name' => Auth::user()->name, 'is_coordinator' => 1])->get();

            $klasses = DB::table('klasses')->get();
            $terms = DB::table('terms')->get();
            $sessions = DB::table('sessions')->get();

            return view('teachers.uploadresults', compact('subjects', 'klasses', 'terms', 'sessions'));
        }

        if ($request->isMethod('POST')) {

            if ($request->hasFile('import_file')) {

                $data = (new ResultImport)->toCollection(request()->file('import_file'));

                //check if its any an empty sheet
                if (!$data->count()) {
                    return back()->with('error', 'you cannot opload an empty s heet');
                } elseif ($data->count()) {

                    //check if he actually uploaded his course and class
                    foreach ($data[0] as $student) {

                        if (($student['class'] != $request->klass || $student['subject'] != $request->subject)
                         || ($student['term'] != $request->term || $student['session'] != $request->session)) {
                            return back()->with("error", "Cross Check Your File, your inputs doesn't match your selections");
                        }
    
                    }

                    //check if that result have been in the database before
                    foreach ($data[0] as $student) {
                   
                        $check = DB::table('results')
                            ->where(['username' => $student['regno'], 'session' => $student['session'], 'subject' => $student['subject'], 'term' => $student['term'] ])->count();

                        if ($check > 0) {
                            return back()->with("error", "Some of these records, already exist in the database");

                        }
                    }

                    //now upload the result is clean
                   
                    foreach ($data[0] as $student) {
                        //  dd($upload->name);
                        $result = new Result();

                        $result->name = $student['name'];
                        $result->username = $student['regno'];

                        $result->class = $student['class'];
                        $result->term = $student['term'];
                        $result->level = $student['level'];
                        $result->session = $student['session'];

                        $result->subject = $student['subject'];

                        $result->continous_accessment = $student['continous_accessment'];
                        $result->test = $student['test'];
                        $result->exam = $student['exam'];
                        $result->total = $student['continous_accessment'] + $student['test'] + $student['exam'];

                        if ($result->total >= 70) {
                            $result->grade = "A";
                        } elseif ($result->total <= 69 && $result->total >= 60) {
                            $result->grade = "B";
                        } elseif ($result->total <= 59 && $result->total >= 50) {
                            $result->grade = "C";
                        } elseif ($result->total <= 49 || $result->total >= 45) {
                            $result->grade = "D";
                        } elseif ($result->total <= 45 || $result->total >= 40) {
                            $result->grade = "E";
                        } elseif ($result->total <= 39 || $result->total >= 0) {
                            $result->grade = "F";
                        }

                        $result->subject_teacher = $upload->subject_teacher;
                        $result->teacher_username = $upload->teacher_username;
                        $result->uploaded_by = Auth::user()->name;

                        $result->save();

                    }

                    //select all that I just uploaded
                    $subjectgrade = DB::table('results')->where([
                        'class' => $request->klass, 'term' => $request->term,
                        'session' => $request->session, 'subject' => $request->subject])->orderBy('total', 'DESC')->get();

                    $counter = 1;
                    $last_total = null;
                    $sameposition = 0;

                    foreach ($subjectgrade as $position) {
                        if ($last_total == $position->total) {
                            $counter = $counter - 1;
                            $position = Result::find($position->id);
                            $position->subject_position = $counter;
                            $position->update();
                            $counter++;
                            $sameposition++;
                            //save the last total
                            $last_total = $position->total;
                        } else {
                            $position = Result::find($position->id);
                            $position->subject_position = $counter + $sameposition;
                            $position->update();
                            $counter = $counter + 1 + $sameposition;

                            //save the last total
                            $last_total = $position->total;
                            //reset sameposition to zero
                            $sameposition = 0;

                        }

                    }

                    return back()->with('success', 'Insert Record successfully.');

                }
            } else {
                return back()->with('error', 'Please Check your file, Something is wrong there.');
            }
        }
    }

    public function classposition(Request $request)
    {
        if ($request->isMethod('GET')) {
            //check if I was assigned a class
            $check = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->count();
            //that is if he doesnt have any class assigned
            if ($check < 1) {
                return back()->with('error', 'You have no classes assigned to you');
            }
            //select the teacher class
            $klass = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->first();
            //select the teacher classes
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            //get the current term
            $term = DB::table('terms')->where('current', 1)->first();
            //get the current session
            $session = DB::table('sessions')->where('current', 1)->first();

            //get me all the term and session incase arecalculation is needed
            $terms = DB::table('terms')->get();
            $sessions = DB::table('sessions')->get();
            //select all that my students result
            $results = DB::table('results')->where(['class' => $klass->name, 'term' => $term->name,
                'session' => $session->name, 'approved' => 1, 'class_position' => 0])->get();

            return view('teachers.classposition', compact('klasses', 'results', 'users', 'sessions', 'terms'));
        } elseif ($request->isMethod('POST')) {
            if ($request->action == 'show') {
                $results = DB::table('results')->where(['class' => $request->klass, 'term' => $request->term,
                    'session' => $request->session, 'approved' => 1, 'class_position' => 0])->get();

                if ($results->count() == 0) {
                    return back()->with('error', 'you have already calculated position for this results');
                }

                //select the teacher classes
                $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();

                //get me all the term and session incase arecalculation is needed
                $terms = DB::table('terms')->get();
                $sessions = DB::table('sessions')->get();
                //select all that my students result

                return view('teachers.classposition', compact('klasses', 'results', 'users', 'sessions', 'terms'));

            } elseif ($request->action == 'position') {
                $klass = $request->klass;
                $term = $request->term;
                $session = $request->session;

                $results = DB::table('results')->where(['class' => $klass, 'term' => $term,
                    'session' => $session, 'approved' => 1, 'class_position' => 0]);

                if ($results->count() == 0) {
                    return back()->with('error', 'you have already calculated position for these results');
                }

                //time to calculate the result and the positions by selecting all the students in my class
                $students = DB::table('users')->where(['class' => $klass, 'term' => $term,
                    'session' => $session])->get();

                if ($students->count() < 1) {
                    return back()->with('error', 'We cant find any student in your class');
                }

                //dd($students);
                foreach ($students as $student) {

                    //get me the total score, calculate the average,and sum

                    $selection = DB::table('results')->where(['class' => $request->klass, 'term' => $request->term,
                        'session' => $request->session, 'approved' => 1, 'class_position' => 0, 'username' => $student->username]);

                    $getall = $selection->get();
                    $total_subjects = $selection->count();
                    // dd($total_subjects);
                    $sum_total = $selection->pluck('total')->sum();
                    $average = $selection->pluck('total')->avg();

                    $position = new Position();

                    // dd($position->name);

                    $position->name = $student->name;
                    $position->username = $student->username;
                    $position->class = $student->class;
                    $position->term = $student->term;
                    $position->level = $student->level;
                    $position->session = $student->session;

                    $position->total_no_of_subjects = $total_subjects;
                    $position->total_score = $sum_total;
                    $position->average = $average;

                    $position->save();

                }

                //now select this results and calculate scores
                //select all that I just uploaded
                $classposition = DB::table('positions')->where([
                    'class' => $klass, 'term' => $term,
                    'session' => $session])->orderBy('average', 'DESC')->get();

                $counter = 1;
                $last_total = null;
                $sameposition = 0;
                foreach ($classposition as $position) {
                    if ($last_total == $position->total_score) {
                        $counter = $counter - 1;
                        $position = Position::find($position->id);
                        $position->position = $counter;
                        $position->update();
                        $counter++;
                        $sameposition++;
                        //save the last total
                        $last_total = $position->total_score;
                    } else {
                        $position = Position::find($position->id);
                        $position->position = $counter + $sameposition;
                        $position->update();
                        $counter = $counter + 1 + $sameposition;

                        //save the last total
                        $last_total = $position->total_score;
                        //reset sameposition to zero
                        $sameposition = 0;

                    }

                    //I dont comment my codes because, if they are hard to write, they should be hard to read
                }

                //now update that result in the result table, to avoid confusion
                $updated = DB::table('results')->where(['class' => $klass, 'term' => $term,
                    'session' => $session, 'approved' => 1, 'class_position' => 0])->update(['class_position' => 1]);

                return back()->with('success', 'Positions successfully Calculated ');

            } else {
                return back()->with('error', 'we dont know what you are talking about');

            }

        }
    }

    //show position calculated
    public function showposition(Request $request)
    {
        if ($request->isMethod('GET')) {
            //check if I was assigned a class
            $check = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->count();
            //that is if he doesnt have any class assigned
            if ($check < 1) {
                return back()->with('error', 'You have no classes assigned to you');
            }
            //get my first assigned class
            $first = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->first();

            //get my current session
            $session = DB::table('sessions')->where('current', 1)->first();
            //get my current term
            $term = DB::table('terms')->where('current', 1)->first();

            //show him all the current positions first , then he chooses
            $results = DB::table('positions')->where(['class' => $first->name, 'term' => $term->name, 'session' => $session->name])->get();

            //select sessions
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $levels = DB::table('levels')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('subjects')->get();

            return view('teachers.showposition', compact('results', 'klasses', 'levels', 'sessions', 'terms', 'subjects'));
        } elseif ($request->isMethod('POST')) {
            //dd($request);
            //select result based on his specifications
            $results = DB::table('positions')->where([
                'class' => $request->klass, 'term' => $request->term,
                'session' => $request->session])->orderBy('average', 'ASC')->get();
            // dd($results);

            //select sessions
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $levels = DB::table('levels')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();
            $subjects = DB::table('subjects')->get();

            return view('teachers.showposition', compact('results', 'klasses', 'levels', 'sessions', 'terms', 'subjects'));

        }
    }

    public function viewcomment(Request $request)
    {
        if ($request->isMethod('GET')) {
            //check if I was assigned a class
            $check = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->count();
            //that is if he doesnt have any class assigned
            if ($check < 1) {
                return back()->with('error', 'You have no classes assigned to you');
            }
            //get my first assigned class
            $first = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->first();
            //dd($first);
            //get my current session
            $session = DB::table('sessions')->where('current', 1)->first();

            //get my current term
            $term = DB::table('terms')->where('current', 1)->first();

            //get the first student in his assigned class
            $student = DB::table('users')->where(['class' => $first->name, 'term' => $term->name, 'session' => $session->name])->first();
            $check = DB::table('users')->where(['class' => $first->name, 'term' => $term->name, 'session' => $session->name])->count();

            //get the guys result

            if ($check < 1) {

                return back()->with('error', 'seems you dont have a student with his results ready');
            }

            $results = DB::table('results')->where(['username' => $student->username, 'class' => $student->class, 'term' => $student->term, 'session' => $student->session])->get();

            $result = DB::table('results')->where(['username' => $student->username, 'class' => $student->class, 'term' => $student->term, 'session' => $student->session])->first();

            //select sessions
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $levels = DB::table('levels')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();

            return view('teachers.viewcomment', compact('results', 'klasses', 'levels', 'sessions', 'student', 'result', 'terms'));
        } elseif ($request->isMethod('POST')) {

            //select result based on his specifications
            $results = DB::table('results')->where([
                'class' => $request->klass, 'term' => $request->term,
                'session' => $request->session, 'username' => $request->username])->get();

            if ($results->count() < 1) {

                return back()->with('error', 'this students result was not found');
            }
            $result = DB::table('results')->where([
                'class' => $request->klass, 'term' => $request->term,
                'session' => $request->session, 'username' => $request->username])->first();

            //select sessions
            $klasses = DB::table('assignclasses')->where('teacher_name', Auth::user()->name)->get();
            $levels = DB::table('levels')->get();

            $sessions = DB::table('sessions')->get();
            $terms = DB::table('terms')->get();

            return view('teachers.viewcomment', compact('results', 'klasses', 'levels', 'sessions', 'result', 'terms', 'subjects'));

        }
    }

// protected function annualresult(){

//             $first=DB::table('results')->where(['class' =>$request->klass,
    //             'session' =>$request->session,'term'=>1,'approved'=>1,'class_position'=>1,'annual_cal'=>0]);
    //             //getall
    //             $getall = $first->get();

//             if($results->count() == 0){
    //                 return back()->with('error', 'you have already calculated position for these results');
    //             }

//             //time to calculate the result and the positions by selecting all the students in my class
    //              $students=DB::table('users')->where(['class' =>$klass,'term' =>$term,
    //             'session' =>$session])->get();

//            //dd($students);
    //             foreach($students as $student )
    //             {

//                 //get me the total score, calculate the average,and sum

//                 $total_score=DB::table('results')->where(['class' =>$request->klass,'term' =>$request->term,
    //                 'session' =>$request->session,'approved'=>1,'class_position'=>0])->get();

//                 $total_subjects = $total_score->count();
    //                 $sum_total=$total_score->sum();
    //                 $average = $total_score->avg();

//                 $position = new Position();

//                 // dd($position->name);

//                 $position->name = $student->name;
    //                 $position->username = $student->username;
    //                 $position->class = $student->class;
    //                 $position->term = $student->term;
    //                 $position->level = $student->level;
    //                 $position->session = $student->session;

//                 $position->total_no_of_subjects= $total_subjects;
    //                 $position->total_score = $sum_total;
    //                 $position->average = $average;

//                 $position->save();

// }

}
