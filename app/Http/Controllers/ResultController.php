<?php

namespace App\Http\Controllers;

use App\Exmset;
use App\Http\Controllers\Backend\BackendController;
use App\Mark;
use App\Models\Student;
use App\Result;
use App\Schclass;
use App\Subject;
use App\Term;
use App\Exam;
use App\User;
use App\Calculator;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResultController extends BackendController
{
    public function __construct()
    {
        // $this->middleware('auth',['excerpt'=>['vertResults','resultGrade']]);
        // $this->middleware('check-permissions');
    }
    public function getBot($term, $set)
    {
        $values = array('term' => request()->term, 'set' => request()->set);
        $schclasses = Auth::user()->schclasses()->get();


        return view('manage-results.create-results', compact('values', 'schclasses'));
    }
    public function enterResults()
    {
        $schclasses = Auth::user()->schclasses()->get();
        return view('manage-results.enter-results', compact('schclasses'));
    }
    public function teacherClasses(Request $request)
    {
        $q = $request->query('q');
        $classes = Auth::user()->schclasses()->get();
        return $classes;
    }
    public function teacherSubjects(Request $request)
    {
        $q = $request->query('q');
        $level = $request->query('level');
        $subjects = Auth::user()->subjects()->with('papersIn')->where('level', 'like', '%' . $level . '%')->where('name', 'like', '%' . $q . '%')->get();
        return $subjects;
    }
    public function teacherStudents(Request $request)
    {
        $students = new Student();
        $q = $request->query('q');
        $level = $request->query('level');
        $class_id = $request->query('class_id');
        $students = $students->with('schstream', 'schclass', 'subjects', 'combination')->where('schclass_id', $class_id)->where('name', 'like', '%' . $q . '%')->orWhere('roll_number', 'like', '%' . $q . '%')->get();
        return $students;
    }

    public function EnterResultsNew(Request $request)
    {
        // return $request->all();
        $student_id = $request['student_id'];
        $level = $request['level'];
        $class_id = $request['class_id'];
        $setID = $request['setID'];
        $termID = $request['termID'];
        $subject_id = $request['subject_id'];
        $papers = $request['papers'];

        $cal = new Calculator();
        $cal->set_inputs($papers, $level, $termID, $setID);
        $processed = $cal->get_inputs($papers);
        $botpapers = null;
        $motpapers = null;
        $eotpapers = null;
        $alevelsubpapers = null;
        $alevelgrade = null;
        $alevelpoints = null;
        $Aresults = null;
        $year = date('Y');
        $exams = new Exam();
        $students = new Student();
        $subjects = new Subject();
        $student = null;
        $subject = null;
        if ($students->where('id', $student_id)->exists()) {
            $student = $students->find($student_id);
        }
        if ($subjects->where('id', $subject_id)->exists()) {
            $subject = $subjects->with('papers')->find($subject_id);
        }
        if($level == "Advanced Level")
        {
           if($setID == "1") $botpapers = $processed['botpapers'];
           if($setID == "2") $motpapers = $processed['motpapers'];
           if($setID == "3") $eotpapers = $processed['eotpapers'];
           $alevelsubpapers = $processed['subpapers'];
           $alevelgrade = $processed['grade'];
           $alevelpoints = $processed['point'];
        
        if($exams->where('year',$year)->where('term_id',$termID)->where('subject_id',$subject_id)->where('student_id',$student_id)->count()>0){
            $exam = $exams->where('year',$year)->where('term_id',$termID)->where('subject_id',$subject_id)->where('student_id',$student_id)->first();

            $exam->term_id = $termID;
            $exam->indexno = $student !== null ? $student->roll_number:$exam->indexno;
            $exam->student_name = $student !== null ? $student->name:$exam->student_name;
            $exam->subject_name = $subject !== null ? $subject->name.' / '.$subject->level:$exam->subject_name;
            $exam->student_id = $student_id;
            $exam->subject_id = $subject_id;
            $exam->schclass_id = $class_id;
            $exam->user_id = auth()->user()->id;
            $exam->year = $year;
            $exam->papers = null;
            $exam->b_o_t = $botpapers !== null ?json_encode(['papers'=>$alevelsubpapers,'grade'=>$alevelgrade,'points'=>$alevelpoints,'computed'=>$botpapers],true):$exam->b_o_t;
            $exam->m_o_t = $motpapers !== null ? json_encode(['papers'=>$alevelsubpapers,'grade'=>$alevelgrade,'points'=>$alevelpoints,'computed'=>$motpapers],true):$exam->m_o_t;
            $exam->e_o_t = $eotpapers !== null ? json_encode(['papers'=>$alevelsubpapers,'grade'=>$alevelgrade,'points'=>$alevelpoints,'computed'=>$eotpapers],true):$exam->e_o_t;

            $exam->save();

            return response()->json(['message'=>'edited successfully']);
        }
        elseif($exams->where('year',$year)->where('term_id',$termID)->where('subject_id',$subject_id)->where('student_id',$student_id)->count() == 0){
                $exams->term_id = $termID;
                $exams->indexno = $student !== null ? $student->roll_number:null;
                $exams->student_name = $student !== null ? $student->name:null;
                $exams->subject_name = $subject !== null ? $subject->name.' / '.$subject->level:null;
                $exams->student_id = $student_id;
                $exams->subject_id = $subject_id;
                $exams->schclass_id = $class_id;
                $exams->year = $year;
                $exams->user_id = auth()->user()->id;
                $exams->papers = null;
                $exams->b_o_t = $botpapers !== null ?json_encode(['papers'=>$alevelsubpapers,'grade'=>$alevelgrade,'points'=>$alevelpoints,'computed'=>$botpapers],true):null;
                $exams->m_o_t = $motpapers !== null ? json_encode(['papers'=>$alevelsubpapers,'grade'=>$alevelgrade,'points'=>$alevelpoints,'computed'=>$motpapers],true):null;
                $exams->e_o_t = $eotpapers !== null ? json_encode(['papers'=>$alevelsubpapers,'grade'=>$alevelgrade,'points'=>$alevelpoints,'computed'=>$eotpapers],true):null;

                $exams->save();

                return response()->json(['message'=>'saved successfully']);
        }
         
        
        }


        elseif($level == "Ordinary Level")
        {
           if($setID == "1") $botpapers = $processed['botpapers'];
           if($setID == "2") $motpapers = $processed['motpapers'];
           if($setID == "3") $eotpapers = $processed['eotpapers'];
           $olevelsubpapers = $processed['subpapers'];
           $olevelgrade = $processed['oAgg'];
           $olevelpoints = $processed['oSubpoints'];
        
        if($exams->where('year',$year)->where('term_id',$termID)->where('subject_id',$subject_id)->where('student_id',$student_id)->count()>0){
            $exam = $exams->where('year',$year)->where('term_id',$termID)->where('subject_id',$subject_id)->where('student_id',$student_id)->first();

            $exam->term_id = $termID;
            $exam->indexno = $student !== null ? $student->roll_number:$exam->indexno;
            $exam->student_name = $student !== null ? $student->name:$exam->student_name;
            $exam->subject_name = $subject !== null ? $subject->name.' / '.$subject->level:$exam->subject_name;
            $exam->student_id = $student_id;
            $exam->subject_id = $subject_id;
            $exam->schclass_id = $class_id;
            $exam->user_id = auth()->user()->id;
            $exam->year = $year;
            $exam->papers = null;
            $exam->b_o_t = $botpapers !== null ?json_encode(['papers'=>$olevelsubpapers,'grade'=>$olevelgrade,'points'=>$olevelpoints,'computed'=>$botpapers],true):$exam->b_o_t;
            $exam->m_o_t = $motpapers !== null ? json_encode(['papers'=>$olevelsubpapers,'grade'=>$olevelgrade,'points'=>$olevelpoints,'computed'=>$motpapers],true):$exam->m_o_t;
            $exam->e_o_t = $eotpapers !== null ? json_encode(['papers'=>$olevelsubpapers,'grade'=>$olevelgrade,'points'=>$olevelpoints,'computed'=>$eotpapers],true):$exam->e_o_t;

            $exam->save();

            return response()->json(['message'=>'edited successfully']);
        }
        elseif($exams->where('year',$year)->where('term_id',$termID)->where('subject_id',$subject_id)->where('student_id',$student_id)->count() == 0){
                $exams->term_id = $termID;
                $exams->indexno = $student !== null ? $student->roll_number:null;
                $exams->student_name = $student !== null ? $student->name:null;
                $exams->subject_name = $subject !== null ? $subject->name.' / '.$subject->level:null;
                $exams->subject_id = $subject_id;
                $exams->schclass_id = $class_id;
                $exams->year = $year;
                $exams->user_id = auth()->user()->id;
                $exams->papers = null;
                $exams->b_o_t = $botpapers !== null ?json_encode(['papers'=>$olevelsubpapers,'grade'=>$olevelgrade,'points'=>$olevelpoints,'computed'=>$botpapers],true):null;
                $exams->m_o_t = $motpapers !== null ? json_encode(['papers'=>$olevelsubpapers,'grade'=>$olevelgrade,'points'=>$olevelpoints,'computed'=>$motpapers],true):null;
                $exams->e_o_t = $eotpapers !== null ? json_encode(['papers'=>$olevelsubpapers,'grade'=>$olevelgrade,'points'=>$olevelpoints,'computed'=>$eotpapers],true):null;

                $exams->save();

                return response()->json(['message'=>'saved successfully']);
        }
         
        
        }
        

        

        

       

        return response()->json(compact('year','termID','setID', 'subject', 'student', 'papers', 'processed','Aresults'));
    }

    public function GetEveryStudentResults(){

        $exams = new Exam();

        $exams = $exams->with('student')->latest()->get();

        return response()->json(compact('exams'));

    }

    public function fetchPapers(Request $request)
    {
        if ($request['action'] != null) {
            // $subject = new Subject();
            $subject = Auth::user()->subjects();
            $schclass = new Schclass();
            $student = new Student();
            $output = null;
            if ($request['action'] == 'schclass') {
                $result = $subject->where('level', $schclass->find($request['query'])->level)->orderBy('name')->get();
                $output .= '<option value="">Select Subject</option>';
                if ($result->count() > 0) {
                    foreach ($result as $row) {
                        $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                } else {
                    $output .= '<option value="">Your have No Subject</option>';
                }
            }
            if ($request['action'] == 'subject') {
                $result = $student->where('schclass_id', $schclass->find($request['class_id'])->id)->orderBy('name')->get();
                $output .= '<option value="">Select Student</option>';
                foreach ($result as $row) {
                    $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '|' . $row['roll_number'] . '</option>';
                }
            }
            if ($request['action'] == 'student') {
            }
            if ($request['action'] == 'has_papers') {
                if ($request['subject_id'] != null) {
                    if ($request['query']) {

                        if ($subject->with('papersIn')->find($request['subject_id'])->papersIn()->count() > 0) {
                            $result = $subject->with('papersIn')->find($request['subject_id'])->papersIn()->get();
                            foreach ($result as $row) {

                                $output .=
                                    '
                                    <div class="form-group col-md-8">
                                        <label>' . $row['paper_abbrev'] . '</label>

                                                    <input  type="number" name="' . $row['paper_abbrev'] . '" class="marks form-control col-12 d-block" id="' . $row['paper_abbrev'] . '"/>
                                          </div>
                                    ';
                            }
                        } else {
                            $output .=
                                '
                            <div class="form-group col-md-8">
                            <label>No Paper Assigned Yet</label>
                            </div>
                            ' . '
                            <div class="form-group col-md-8">
                            <label>Subject Marks</label>

                                        <input name="paper_mark" type="number" class="marks form-control col-12 d-block" id="paper_mark"/>
                               </div>
                        ';
                        }
                    } else {
                        $output .=
                            '
                    <div class="form-group col-md-8">
                        <label>Subject Marks</label>

                                    <input name="paper_mark" type="number" class="marks form-control col-12 d-block" id="paper_mark"/>

                        </div>
                    ';
                    }
                } else {
                    $output .= "<label>No Subject Selected, Please fill the fields before</label>";
                }
                // $output.=
                // '
                //     <label>Subject Marks</label>
                //     <div class="">
                //         <div class="chosen-select-single mg-b-20">
                //                 <input name="paper_mark" ty class="action form-control" id="paper_mark"/>
                //         </div>
                //     </div>
                // ';
            }
            return $output;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = new Result();
        $subjects = new Subject();
        $students = new Student();
        $result_list = Result::orderBy('student_id')->get()->groupBy(function ($item) {
            return $item->student_id;
        });

        return view('manage-results.report-test', compact('results', 'subjects', 'result_list', 'students'));
    }

    public function storeStudentMarks(Request $request)
    {
        $rule = array(
            'teacher_id' => 'required',
            'subject' => 'required',
            'student' => 'required',
            'term' => 'required',
            'set' => 'required',
            'schclass' => 'required',
            'has_paper' => 'nullable',
            'P1' => 'nullable|integer',
            'P2' => 'nullable|integer',
            'P3' => 'nullable|integer',
            'paper_mark' => 'nullable|integer',
        );

        $term = '';
        $set = '';
        $grade = '';

        $grade_point = '';
        $paper_all_marks = [];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        if ($request['P1'] != null || $request['paper_mark'] != null) {
            if ($request['term'] == 'term-1') {
                $term = 1;
            }
            if ($request['term'] == 'term-2') {
                $term = 2;
            }
            if ($request['term'] == 'term-3') {
                $term = 3;
            }
            if ($request['set'] == 'b-o-t') {
                $set = 1;
            }
            if ($request['set'] == 'm-o-t') {
                $set = 2;
            }
            if ($request['set'] == 'e-o-t') {
                $set = 3;
            }

            $result = new Result();
            $result->year = date('Y');
            $marks = new Mark();
            $subject = new Subject();
            $student = new Student();
            $date = new Carbon();






            if ($request['paper_mark'] != null) {
                if ($subject->find($request['subject'])->level == 'Advanced Level') {
                    if ($request['paper_mark'] <= 39.9) {
                        $grade = 'F';
                        $grade_point = 0;
                    }
                    if ($request['paper_mark'] > 39.9 && $request['paper_mark'] <= 44.9) {
                        $grade = '0';
                        $grade_point = 0;
                    }
                    if ($request['paper_mark'] > 44.9 && $request['paper_mark'] <= 49.9) {
                        $grade = 'E';
                        $grade_point = 1;
                    }
                    if ($request['paper_mark'] > 49.9 && $request['paper_mark'] <= 54.9) {
                        $grade = 'D-';
                        $grade_point = 2;
                    }
                    if ($request['paper_mark'] > 54.9 && $request['paper_mark'] <= 59.9) {
                        $grade = 'D+';
                        $grade_point = 2.5;
                    }
                    if ($request['paper_mark'] > 59.9 && $request['paper_mark'] <= 64.9) {
                        $grade = 'C-';
                        $grade_point = 3;
                    }
                    if ($request['paper_mark'] > 64.9 && $request['paper_mark'] <= 69.9) {
                        $grade = 'C+';
                        $grade_point = 3.5;
                    }
                    if ($request['paper_mark'] > 69.9 && $request['paper_mark'] <= 74.9) {
                        $grade = 'B-';
                        $grade_point = 4;
                    }
                    if ($request['paper_mark'] > 79.9 && $request['paper_mark'] <= 84.9) {
                        $grade = 'B+';
                        $grade_point = 4.5;
                    }
                    if ($request['paper_mark'] > 84.9 && $request['paper_mark'] <= 89.9) {
                        $grade = 'A';
                        $grade_point = 5;
                    }
                    if ($request['paper_mark'] > 89.9 && $request['paper_mark'] <= 100) {
                        $grade = 'A+';
                        $grade_point = 5.5;
                    }
                }
                if ($subject->find($request['subject'])->level == 'Ordinary Level') {
                    if ($request['paper_mark'] <= 39.9) {
                        $grade = 'F';
                        $grade_point = 0;
                    }
                    if ($request['paper_mark'] > 39.9 && $request['paper_mark'] <= 44.9) {
                        $grade = '0';
                        $grade_point = 0;
                    }
                    if ($request['paper_mark'] > 44.9 && $request['paper_mark'] <= 49.9) {
                        $grade = 'E';
                        $grade_point = 1;
                    }
                    if ($request['paper_mark'] > 49.9 && $request['paper_mark'] <= 54.9) {
                        $grade = 'D-';
                        $grade_point = 2;
                    }
                    if ($request['paper_mark'] > 54.9 && $request['paper_mark'] <= 59.9) {
                        $grade = 'D+';
                        $grade_point = 2.5;
                    }
                    if ($request['paper_mark'] > 59.9 && $request['paper_mark'] <= 64.9) {
                        $grade = 'C-';
                        $grade_point = 3;
                    }
                    if ($request['paper_mark'] > 64.9 && $request['paper_mark'] <= 69.9) {
                        $grade = 'C+';
                        $grade_point = 3.5;
                    }
                    if ($request['paper_mark'] > 69.9 && $request['paper_mark'] <= 74.9) {
                        $grade = 'B-';
                        $grade_point = 4;
                    }
                    if ($request['paper_mark'] > 79.9 && $request['paper_mark'] <= 84.9) {
                        $grade = 'B+';
                        $grade_point = 4.5;
                    }
                    if ($request['paper_mark'] > 84.9 && $request['paper_mark'] <= 89.9) {
                        $grade = 'A';
                        $grade_point = 5;
                    }
                    if ($request['paper_mark'] > 89.9 && $request['paper_mark'] <= 100) {
                        $grade = 'A+';
                        $grade_point = 5.5;
                    }
                }






                if ($result->where('created_at', 'LIKE', '%' . date('Y') . '%')->where('term_id', $term)->where('exmset_id', $set)->where('student_id', request()->student)->where('subject_id', request()->subject)->count() > 0) {
                    $result->where('created_at', 'LIKE', '%' . date('Y') . '%')->where('term_id', $term)->where('exmset_id', $set)->where('student_id', request()->student)->where('subject_id', request()->subject)->first()->update(
                        array(
                            'mark' => request()->paper_mark,
                            'calculate_mark' => $request['paper_mark'] * (Exmset::find($set)->set_percentage / 100),
                            'grade' => $grade,
                        )
                    );
                } elseif ($result->where('created_at', 'LIKE', '%' . date('Y') . '%')->where('term_id', $term)->where('exmset_id', $set)->where('student_id', request()->student)->where('subject_id', request()->subject)->count() == 0) {

                    Result::create(array(
                        'user_id' => $request['teacher_id'],
                        'student_id' => $request['student'],
                        'schclass_id' => $request['schclass'],
                        'subject_id' => $request['subject'],
                        'paper_id' => null,
                        'term_id' => $term,
                        'exmset_id' => $set,
                        'mark' => $request['paper_mark'],
                        'calculate_mark' => $request['paper_mark'] * (Exmset::find($set)->set_percentage / 100),
                        'grade' => $grade,
                        'comments' => null,
                        'year' => date('Y')
                    ));
                }
                // $marks->save();
                Mark::create(array(
                    'student_id' => $request['student'],
                    'subject_id' => $request['subject'],
                    'grade' => $grade,
                    'final_mark' => $request['paper_mark'],
                    'teacher_comment' => null,
                    'points' => $grade_point
                ));

                return response()->json(['success' => 'Saved Successfully']);
            }

            if ($request['P1'] != null) {
                // return response()->json(['data'=>$request->all()]);

                foreach ($subject->with('papersIn')->find($request['subject'])->papersIn()->get() as $sub) {
                    if ($subject->find($request['subject'])->level == 'Advanced Level') {
                        if ($request[$sub['paper_abbrev']] <= 39.9) {
                            $grade = 'F';
                            $grade_point = 0;
                        }
                        if ($request[$sub['paper_abbrev']] > 39.9 && $request[$sub['paper_abbrev']] <= 44.9) {
                            $grade = '0';
                            $grade_point = 0;
                        }
                        if ($request[$sub['paper_abbrev']] > 44.9 && $request[$sub['paper_abbrev']] <= 49.9) {
                            $grade = 'E';
                            $grade_point = 1;
                        }
                        if ($request[$sub['paper_abbrev']] > 49.9 && $request[$sub['paper_abbrev']] <= 54.9) {
                            $grade = 'D-';
                            $grade_point = 2;
                        }
                        if ($request[$sub['paper_abbrev']] > 54.9 && $request[$sub['paper_abbrev']] <= 59.9) {
                            $grade = 'D+';
                            $grade_point = 2.5;
                        }
                        if ($request[$sub['paper_abbrev']] > 59.9 && $request[$sub['paper_abbrev']] <= 64.9) {
                            $grade = 'C-';
                            $grade_point = 3;
                        }
                        if ($request[$sub['paper_abbrev']] > 64.9 && $request[$sub['paper_abbrev']] <= 69.9) {
                            $grade = 'C+';
                            $grade_point = 3.5;
                        }
                        if ($request[$sub['paper_abbrev']] > 69.9 && $request[$sub['paper_abbrev']] <= 74.9) {
                            $grade = 'B-';
                            $grade_point = 4;
                        }
                        if ($request[$sub['paper_abbrev']] > 79.9 && $request[$sub['paper_abbrev']] <= 84.9) {
                            $grade = 'B+';
                            $grade_point = 4.5;
                        }
                        if ($request[$sub['paper_abbrev']] > 84.9 && $request[$sub['paper_abbrev']] <= 89.9) {
                            $grade = 'A';
                            $grade_point = 5;
                        }
                        if ($request[$sub['paper_abbrev']] > 89.9 && $request[$sub['paper_abbrev']] <= 100) {
                            $grade = 'A+';
                            $grade_point = 5.5;
                        }
                    }

                    if ($subject->find($request['subject'])->level == 'Ordinary Level') {
                        if ($request[$sub['paper_abbrev']] <= 39.9) {
                            $grade = 'F';
                            $grade_point = 0;
                        }
                        if ($request[$sub['paper_abbrev']] > 39.9 && $request[$sub['paper_abbrev']] <= 44.9) {
                            $grade = '0';
                            $grade_point = 0;
                        }
                        if ($request[$sub['paper_abbrev']] > 44.9 && $request[$sub['paper_abbrev']] <= 49.9) {
                            $grade = 'E';
                            $grade_point = 1;
                        }
                        if ($request[$sub['paper_abbrev']] > 49.9 && $request[$sub['paper_abbrev']] <= 54.9) {
                            $grade = 'D-';
                            $grade_point = 2;
                        }
                        if ($request[$sub['paper_abbrev']] > 54.9 && $request[$sub['paper_abbrev']] <= 59.9) {
                            $grade = 'D+';
                            $grade_point = 2.5;
                        }
                        if ($request[$sub['paper_abbrev']] > 59.9 && $request[$sub['paper_abbrev']] <= 64.9) {
                            $grade = 'C-';
                            $grade_point = 3;
                        }
                        if ($request[$sub['paper_abbrev']] > 64.9 && $request[$sub['paper_abbrev']] <= 69.9) {
                            $grade = 'C+';
                            $grade_point = 3.5;
                        }
                        if ($request[$sub['paper_abbrev']] > 69.9 && $request[$sub['paper_abbrev']] <= 74.9) {
                            $grade = 'B-';
                            $grade_point = 4;
                        }
                        if ($request[$sub['paper_abbrev']] > 79.9 && $request[$sub['paper_abbrev']] <= 84.9) {
                            $grade = 'B+';
                            $grade_point = 4.5;
                        }
                        if ($request[$sub['paper_abbrev']] > 84.9 && $request[$sub['paper_abbrev']] <= 89.9) {
                            $grade = 'A';
                            $grade_point = 5;
                        }
                        if ($request[$sub['paper_abbrev']] > 89.9 && $request[$sub['paper_abbrev']] <= 100) {
                            $grade = 'A+';
                            $grade_point = 5.5;
                        }
                    }



                    if ($result->where('created_at', 'LIKE', '%' . date('Y') . '%')->where('term_id', $term)->where('exmset_id', $set)->where('student_id', request()->student)->where('subject_id', request()->subject)->where('paper_id', $sub['id'])->count() > 0) {


                        $result->where('created_at', 'LIKE', '%' . date('Y') . '%')->where('term_id', $term)->where('exmset_id', $set)->where('student_id', request()->student)->where('subject_id', request()->subject)->where('paper_id', $sub['id'])->first()->update(
                            array(
                                'mark' => $request[$sub['paper_abbrev']],
                                'calculate_mark' => $request[$sub['paper_abbrev']] * (Exmset::find($set)->set_percentage / 100),
                                'grade' => $grade,
                            )
                        );
                    } elseif ($result->where('created_at', 'LIKE', '%' . date('Y') . '%')->where('term_id', $term)->where('exmset_id', $set)->where('student_id', request()->student)->where('subject_id', request()->subject)->where('paper_id', $sub['id'])->count() == 0) {

                        Result::create(array(
                            'user_id' => $request['teacher_id'],
                            'student_id' => $request['student'],
                            'schclass_id' => $request['schclass'],
                            'subject_id' => $request['subject'],
                            'paper_id' => $sub['id'],
                            'term_id' => $term,
                            'exmset_id' => $set,
                            'mark' => $request[$sub['paper_abbrev']],
                            'calculate_mark' => $request[$sub['paper_abbrev']] * (Exmset::find($set)->set_percentage / 100),
                            'grade' => $grade,
                            'comments' => null,
                            'year' => date('Y')
                        ));
                    }


                    $paper_all_marks = array_merge($paper_all_marks, [$request[$sub['paper_abbrev']]]);
                }


                $paper_all_marks_final_mark = array_sum($paper_all_marks) / count($paper_all_marks);


                if ($subject->find($request['subject'])->level == 'Advanced Level') {

                    if ($paper_all_marks_final_mark <= 39.9) {
                        $grade = 'F';
                        $grade_point = 0;
                    }
                    if ($paper_all_marks_final_mark > 39.9 &&  $paper_all_marks_final_mark <= 44.9) {
                        $grade = '0';
                        $grade_point = 0;
                    }
                    if ($paper_all_marks_final_mark > 44.9 &&  $paper_all_marks_final_mark <= 49.9) {
                        $grade = 'E';
                        $grade_point = 1;
                    }
                    if ($paper_all_marks_final_mark > 49.9 &&  $paper_all_marks_final_mark <= 54.9) {
                        $grade = 'D-';
                        $grade_point = 2;
                    }
                    if ($paper_all_marks_final_mark > 54.9 &&  $paper_all_marks_final_mark <= 59.9) {
                        $grade = 'D+';
                        $grade_point = 2.5;
                    }
                    if ($paper_all_marks_final_mark > 59.9 &&  $paper_all_marks_final_mark <= 64.9) {
                        $grade = 'C-';
                        $grade_point = 3;
                    }
                    if ($paper_all_marks_final_mark > 64.9 &&  $paper_all_marks_final_mark <= 69.9) {
                        $grade = 'C+';
                        $grade_point = 3.5;
                    }
                    if ($paper_all_marks_final_mark > 69.9 &&  $paper_all_marks_final_mark <= 74.9) {
                        $grade = 'B-';
                        $grade_point = 4;
                    }
                    if ($paper_all_marks_final_mark > 79.9 &&  $paper_all_marks_final_mark <= 84.9) {
                        $grade = 'B+';
                        $grade_point = 4.5;
                    }
                    if ($paper_all_marks_final_mark > 84.9 &&  $paper_all_marks_final_mark <= 89.9) {
                        $grade = 'A';
                        $grade_point = 5;
                    }
                    if ($paper_all_marks_final_mark > 89.9 &&  $paper_all_marks_final_mark <= 100) {
                        $grade = 'A+';
                        $grade_point = 5.5;
                    }
                }
                if ($subject->find($request['subject'])->level == 'Ordinary Level') {

                    if ($paper_all_marks_final_mark <= 39.9) {
                        $grade = 'F';
                        $grade_point = 0;
                    }
                    if ($paper_all_marks_final_mark > 39.9 &&  $paper_all_marks_final_mark <= 44.9) {
                        $grade = '0';
                        $grade_point = 0;
                    }
                    if ($paper_all_marks_final_mark > 44.9 &&  $paper_all_marks_final_mark <= 49.9) {
                        $grade = 'E';
                        $grade_point = 1;
                    }
                    if ($paper_all_marks_final_mark > 49.9 &&  $paper_all_marks_final_mark <= 54.9) {
                        $grade = 'D-';
                        $grade_point = 2;
                    }
                    if ($paper_all_marks_final_mark > 54.9 &&  $paper_all_marks_final_mark <= 59.9) {
                        $grade = 'D+';
                        $grade_point = 2.5;
                    }
                    if ($paper_all_marks_final_mark > 59.9 &&  $paper_all_marks_final_mark <= 64.9) {
                        $grade = 'C-';
                        $grade_point = 3;
                    }
                    if ($paper_all_marks_final_mark > 64.9 &&  $paper_all_marks_final_mark <= 69.9) {
                        $grade = 'C+';
                        $grade_point = 3.5;
                    }
                    if ($paper_all_marks_final_mark > 69.9 &&  $paper_all_marks_final_mark <= 74.9) {
                        $grade = 'B-';
                        $grade_point = 4;
                    }
                    if ($paper_all_marks_final_mark > 79.9 &&  $paper_all_marks_final_mark <= 84.9) {
                        $grade = 'B+';
                        $grade_point = 4.5;
                    }
                    if ($paper_all_marks_final_mark > 84.9 &&  $paper_all_marks_final_mark <= 89.9) {
                        $grade = 'A';
                        $grade_point = 5;
                    }
                    if ($paper_all_marks_final_mark > 89.9 &&  $paper_all_marks_final_mark <= 100) {
                        $grade = 'A+';
                        $grade_point = 5.5;
                    }
                }



                Mark::create(array(
                    'student_id' => $request['student'],
                    'subject_id' => $request['subject'],
                    'grade' => $grade,
                    'final_mark' => $paper_all_marks_final_mark,
                    'teacher_comment' => null,
                    'points' => $grade_point
                ));





                return response()->json(['success' => 'Saved Successfully']);
            }




            return response()->json(['data' => $request->all(), 'term' => $term, 'set' => $set]);
        } else {
            return response()->json(['errors' => 'Please Full Marks Field']);
        }
    }

    public function getManageMarks()
    {
        $users = new User();

        $id = Auth::user()->id;
        $term = Term::orderBy('id', 'asc')->get();
        $sets = Exmset::orderBy('id', 'asc')->get();
        $results = Result::orderBy('student_id', 'asc')->get();
        $students = Student::orderBy('id', 'asc')->get();
        $subjects = Auth::user()->subjects()->get();
        $subjs = Subject::get();
        $schclasses = Auth::user()->schclasses()->get();

        return view('manage-results.manage-marks', compact('subjs', 'subjects', 'schclasses', 'sets', 'term', 'results', 'students'));
    }
    public function fetchManageMarks(Request $request)
    {

        if ($request['action'] != null) {
            $output = '';
            $subjects = Auth::user()->subjects();
            $students = new Student();
            $result = new Result();
            $users = Auth::user();
            $id = Auth::user()->id;
            if ($request['action'] == 'schclass') {
                $results = $subjects->where('level', Schclass::find($request['query'])->level)->get();

                $output .= '<option value="">Select Subject</option>';
                foreach ($results as $row) {
                    $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            }
            if ($request['action'] == 'term' && $request['class_id'] != null) {
                $results = $result->where('schclass_id', $request['class_id'])->get()->groupBy('student_id');

                if ($results->count() > 0) {
                    $output .= '
                    <table id="RoleTable" class="table table-bordered">
                    <thead>
                        <th colspan="2">Subject</th>

                        <th>Bot <br> out of ' . Exmset::find(1)->set_percentage . '</th>
                        <th>Mot<br> out of ' . Exmset::find(2)->set_percentage . '</th>
                        <th>Eot <br>out of ' . Exmset::find(3)->set_percentage . '</th>
                        <th>Total Marks<br> of' . '100' . '</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </thead>
                    <tbody>
                    ';
                    foreach ($results as $stud_id => $resul) {
                        global $paper_total1, $paper_total2, $paper_total3;
                        $output .= '<tr><td colspan="9">' . $students->find($stud_id)->name . '</td></tr>';
                        foreach ($resul->where('term_id', request()->term_id)->groupBy('subject_id') as $sub_id => $res) {


                            if ($res->where('subject_id', request()->subject_id)->count() > 0) {

                                // subject with three papers
                                if ($res->where('subject_id', request()->subject_id)->first()->subject->papersIn()->count() == 3 && $res->first()->paper_id != null) {
                                    $output .= '
                                        <tr>
                                        <tr>
                                        <td rowspan="3">' . $res->where('subject_id', request()->subject_id)->first()->subject->name . '</td>
                                        <td>';
                                    if ($res->count() > 0) {
                                        $output .= $res->first()->paper->paper_abbrev;
                                    } elseif ($res->count() == 0) {
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        <td>';

                                    if ($res->where('exmset_id', 1)->count() > 0) {
                                        $bot_mark = round(($res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                        $output .= $bot_mark;
                                    } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                        $bot_mark = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';

                                    if ($res->where('exmset_id', 2)->count() > 0) {
                                        $mot_mark = round($res->where('exmset_id', 2)->first()->mark * round((Exmset::find(2)->set_percentage / 100), 2), 2);
                                        $output .= $mot_mark;
                                    } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                        $mot_mark = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';

                                    if ($res->where('exmset_id', 3)->count() > 0) {

                                        $eot_mark = round(($res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                        $output .= $eot_mark;
                                    } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                        $eot_mark = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';

                                    if ($res->count() > 0) {
                                        $paper_1_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                        $output .= $paper_1_total;
                                    } elseif ($res->count() == 0) {
                                        $paper_1_total = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td rowspan="3">';
                                    if ($res->count() > 0) {
                                        $bot_mark1 = ($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                            : 0);
                                        $mot_mark1 = ($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                            : 0);
                                        $eot_mark1 = ($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                            : 0);
                                        $paper_total1 = round(array_sum(array($bot_mark1, $mot_mark1, $eot_mark1)), 2);
                                    }
                                    if ($res->count() == 0) {
                                        $paper_total1 = 0;
                                        $output .= "";
                                    }
                                    if ($res->count() > 1) {
                                        $bot_mark2 = ($res->where('exmset_id', 1)->where('paper_id', $res[1]->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 1)->where('paper_id', $res[1]->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                            : 0);
                                        $mot_mark2 = ($res->where('exmset_id', 2)->where('paper_id', $res[1]->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 2)->where('paper_id', $res[1]->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                            : 0);
                                        $eot_mark2 = ($res->where('exmset_id', 3)->where('paper_id', $res[1]->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 3)->where('paper_id', $res[1]->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                            : 0);
                                        $paper_total2 = round(array_sum(array($bot_mark2, $mot_mark2, $eot_mark2)), 2);
                                    }
                                    if ($res->count() < 1) {
                                        $paper_total2 = 0;
                                    }
                                    if ($res->count() > 2) {
                                        $bot_mark3 = ($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                            : 0);
                                        $mot_mark3 = ($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                            : 0);
                                        $eot_mark3 = ($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                            : 0);
                                        $paper_total3 = round(array_sum(array($bot_mark3, $mot_mark3, $eot_mark3)), 2);
                                    }
                                    if ($res->count() < 2) {
                                        $paper_total3 = 0;
                                    }
                                    $Subject_final_mark = round(array_sum(array($paper_total1, $paper_total2, $paper_total3)) / 3, 2);
                                    $output .= $Subject_final_mark;


                                    $output .= '</td>
                                        <td rowspan="3">';
                                    if ($Subject_final_mark > 90) {
                                        $Subject_final_grade = "A+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 80 && $Subject_final_mark < 90) {
                                        $Subject_final_grade = "A";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 75 && $Subject_final_mark < 80) {
                                        $Subject_final_grade = "B+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 70 && $Subject_final_mark < 75) {
                                        $Subject_final_grade = "B";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 65 && $Subject_final_mark < 70) {
                                        $Subject_final_grade = "C+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 60 && $Subject_final_mark < 65) {
                                        $Subject_final_grade = "C";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 55 && $Subject_final_mark < 60) {
                                        $Subject_final_grade = "C";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 50 && $Subject_final_mark < 55) {
                                        $Subject_final_grade = "C";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark < 50) {
                                        $Subject_final_grade = "F";
                                        $output .= $Subject_final_grade;
                                    }
                                    $output .= '</td>
                                        <td rowspan="3">
                                        ' . ($Subject_final_grade !== null ? $this->teacherComment($Subject_final_grade) : null) . '
                                        </td>

                                        </tr>
                                        <tr>
                                            <td>';
                                    if ($res->count() > 1) {
                                        $output .= $res[1]->paper->paper_abbrev;
                                    } elseif ($res->count() < 1) {
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 1)->count() > 1) {
                                        $bot_mark = round(($res->where('exmset_id', 1)->nth(2, 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                        $output .= $bot_mark;
                                    } elseif ($res->where('exmset_id', 1)->count() < 1) {
                                        $bot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 2)->count() > 1) {
                                        $mot_mark = round(($res->where('exmset_id', 2)->nth(2, 1)->first()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                        $output .= $mot_mark;
                                    } elseif ($res->where('exmset_id', 2)->count() < 1) {
                                        $mot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 3)->count() > 1) {
                                        $eot_mark = round(($res->where('exmset_id', 3)->nth(2, 1)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                        $output .= $eot_mark;
                                    } elseif ($res->where('exmset_id', 3)->count() < 1) {
                                        $eot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->count() > 1) {
                                        $paper_2_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                        $output .= $paper_2_total;
                                    } elseif ($res->count() < 1) {
                                        $paper_2_total = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        </tr>
                                        <tr>
                                            <td>';
                                    if ($res->count() > 2) {
                                        $output .= $res->last()->paper->paper_abbrev;
                                    } elseif ($res->count() < 2) {
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 1)->count() > 2) {
                                        $bot_mark = round(($res->where('exmset_id', 1)->last()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                        $output .= $bot_mark;
                                    } elseif ($res->where('exmset_id', 1)->count() < 2) {
                                        $bot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 2)->count() > 2) {
                                        $mot_mark = round(($res->where('exmset_id', 2)->last()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                        $output .= $mot_mark;
                                    } elseif ($res->where('exmset_id', 2)->count() < 2) {
                                        $mot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 3)->count() > 2) {
                                        $eot_mark = round(($res->where('exmset_id', 3)->last()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                        $output .= $eot_mark;
                                    } elseif ($res->where('exmset_id', 3)->count() < 2) {
                                        $eot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->count() > 2) {
                                        $paper_3_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                        $output .= $paper_3_total;
                                    } elseif ($res->count() < 2) {
                                        $paper_3_total = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        </tr>
                                        </tr>';
                                }


                                // subject with two papers

                                elseif ($res->where('subject_id', request()->subject_id)->first()->subject->papersIn()->count() == 2 && $res->where('subject_id', request()->subject_id)->first()->paper_id != null) {
                                    $output .= '
                                        <tr>
                                        <tr>
                                        <td rowspan="2">' . $res->where('subject_id', request()->subject_id)->first()->subject->name . '</td>
                                        <td>';
                                    if ($res->count() > 0) {
                                        $output .= $res->first()->paper->paper_abbrev;
                                    } elseif ($res->count() == 0) {
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        <td>';

                                    if ($res->where('exmset_id', 1)->count() > 0) {
                                        $bot_mark = round(($res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                        $output .= $bot_mark;
                                    } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                        $bot_mark = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';

                                    if ($res->where('exmset_id', 2)->count() > 0) {
                                        $mot_mark = round($res->where('exmset_id', 2)->first()->mark * round((Exmset::find(2)->set_percentage / 100), 2), 2);
                                        $output .= $mot_mark;
                                    } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                        $mot_mark = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';

                                    if ($res->where('exmset_id', 3)->count() > 0) {

                                        $eot_mark = round(($res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                        $output .= $eot_mark;
                                    } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                        $eot_mark = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';

                                    if ($res->count() > 0) {
                                        $paper_1_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                        $output .= $paper_1_total;
                                    } elseif ($res->count() == 0) {
                                        $paper_1_total = 0;
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td rowspan="2">';
                                    if ($res->count() > 0) {
                                        $bot_mark1 = ($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                            : 0);
                                        $mot_mark1 = ($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                            : 0);
                                        $eot_mark1 = ($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                            : 0);
                                        $paper_total1 = round(array_sum(array($bot_mark1, $mot_mark1, $eot_mark1)), 2);
                                    }
                                    if ($res->count() == 0) {
                                        $paper_total1 = 0;
                                        $output .= "";
                                    }

                                    if ($res->count() > 1) {
                                        $bot_mark3 = ($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                            : 0);
                                        $mot_mark3 = ($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                            : 0);
                                        $eot_mark3 = ($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                            round(($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                            : 0);
                                        $paper_total3 = round(array_sum(array($bot_mark3, $mot_mark3, $eot_mark3)), 2);
                                    }
                                    if ($res->count() < 2) {
                                        $paper_total3 = 0;
                                    }
                                    $Subject_final_mark = round(array_sum(array($paper_total1, $paper_total2, $paper_total3)) / 2, 2);
                                    $output .= $Subject_final_mark;


                                    $output .= '</td>
                                        <td rowspan="2">';
                                    if ($Subject_final_mark > 90) {
                                        $Subject_final_grade = "A+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 80 && $Subject_final_mark < 90) {
                                        $Subject_final_grade = "A";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 75 && $Subject_final_mark < 80) {
                                        $Subject_final_grade = "B+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 70 && $Subject_final_mark < 75) {
                                        $Subject_final_grade = "B-";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 65 && $Subject_final_mark < 70) {
                                        $Subject_final_grade = "C+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 60 && $Subject_final_mark < 65) {
                                        $Subject_final_grade = "C-";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 55 && $Subject_final_mark < 60) {
                                        $Subject_final_grade = "D+";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark >= 50 && $Subject_final_mark < 55) {
                                        $Subject_final_grade = "D-";
                                        $output .= $Subject_final_grade;
                                    }
                                    if ($Subject_final_mark < 50) {
                                        $Subject_final_grade = "F";
                                        $output .= $Subject_final_grade;
                                    }
                                    $output .= '</td>
                                        <td rowspan="2">
                                           ' . ($Subject_final_grade !== null ? $this->teacherComment($Subject_final_grade) : null) . '

                                        </td>

                                        </tr>

                                        <tr>
                                            <td>';
                                    if ($res->count() > 1) {
                                        $output .= $res->last()->paper->paper_abbrev;
                                    } elseif ($res->count() < 1) {
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 1)->count() > 1) {
                                        $bot_mark = round(($res->where('exmset_id', 1)->last()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                        $output .= $bot_mark;
                                    } elseif ($res->where('exmset_id', 1)->count() < 1) {
                                        $bot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 2)->count() > 1) {
                                        $mot_mark = round(($res->where('exmset_id', 2)->last()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                        $output .= $mot_mark;
                                    } elseif ($res->where('exmset_id', 2)->count() < 1) {
                                        $mot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->where('exmset_id', 3)->count() > 1) {
                                        $eot_mark = round(($res->where('exmset_id', 3)->last()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                        $output .= $eot_mark;
                                    } elseif ($res->where('exmset_id', 3)->count() < 1) {
                                        $eot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                            <td>';
                                    if ($res->count() > 1) {
                                        $paper_3_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                        $output .= $paper_3_total;
                                    } elseif ($res->count() < 1) {
                                        $paper_3_total = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        </tr>
                                        </tr>';
                                } elseif ($res->where('subject_id', request()->subject_id)->first()->subject->papersIn()->count() == 0 && $res->where('subject_id', request()->subject_id)->first()->paper_id != null) {
                                    $output .= '<h3 class="display-1">Still querying [2]</h3>';
                                } elseif ($res->where('subject_id', request()->subject_id)->first()->subject->papersIn()->count() > 0 && $res->where('subject_id', request()->subject_id)->first()->paper_id == null) {

                                    $output .= '<tr><tr>
                                        <td colspan="2">';
                                    if ($res->count() > 0) {
                                        $output .= $res->first()->subject->name;
                                    } elseif ($res->count() < 0) {
                                        $output .= "";
                                    }

                                    $output .= '</td>
                                        <td>';
                                    if ($res->where('exmset_id', 1)->count() > 0) {
                                        $bot_mark = round(($res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                        $output .= $bot_mark;
                                    } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                        $bot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        <td>';
                                    if ($res->where('exmset_id', 2)->count() > 0) {
                                        $mot_mark = round(($res->where('exmset_id', 2)->first()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                        $output .= $mot_mark;
                                    } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                        $mot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        <td>';
                                    if ($res->where('exmset_id', 3)->count() > 0) {
                                        $eot_mark = round(($res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                        $output .= $eot_mark;
                                    } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                        $eot_mark = 0;
                                        $output .= "";
                                    }
                                    $output .= '</td>
                                        <td>';
                                    if ($res->count() > 0) {
                                        $total_mark = round((array_sum(array($bot_mark, $mot_mark, $eot_mark))), 2);
                                        $output .= $total_mark;
                                    }

                                    $output .= '</td>
                                        <td>';
                                    if ($res->count() > 0) {
                                        $total_mark = round((array_sum(array($bot_mark, $mot_mark, $eot_mark))), 2);
                                        $output .= $total_mark;
                                    }

                                    $output .= '</td>
                                        <td>';
                                    if ($res->count() > 0) {
                                        $total_mark = round((array_sum(array($bot_mark, $mot_mark, $eot_mark))), 2);
                                        if ($total_mark > 90) {
                                            $Subject_final_grade = "A+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 80 && $total_mark < 90) {
                                            $Subject_final_grade = "A";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 75 && $total_mark < 80) {
                                            $Subject_final_grade = "B+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 70 && $total_mark < 75) {
                                            $Subject_final_grade = "B-";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 65 && $total_mark < 70) {
                                            $Subject_final_grade = "C+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 60 && $total_mark < 65) {
                                            $Subject_final_grade = "C-";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 55 && $total_mark < 60) {
                                            $Subject_final_grade = "D+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark >= 50 && $total_mark < 55) {
                                            $Subject_final_grade = "D-";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($total_mark < 50) {
                                            $Subject_final_grade = "F";
                                            $output .= $Subject_final_grade;
                                        }
                                    }

                                    $output .= '</td>
                                        <td>' . ($Subject_final_grade !== null ? $this->teacherComment($Subject_final_grade) : null) . '</td>
                                        ';
                                } else {
                                    $output .= '
                                        <tr><tr>
                                        <td colspan="2">' . $res->first()->subject->name . '</td>';
                                    if ($res->where('exmset_id', 1)->count() > 0) {
                                        $bot_mark = $res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100;
                                        $output .= '<td>' . $bot_mark . '</td>';
                                    } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                        $bot_mark = 0;
                                        $output .= '<td>' . null . '</td>';
                                    }
                                    if ($res->where('exmset_id', 2)->count() > 0) {
                                        $mot_mark = $res->where('exmset_id', 2)->first()->mark * Exmset::find(2)->set_percentage / 100;
                                        $output .= '<td>' . $mot_mark . '</td>';
                                    } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                        $mot_mark = 0;
                                        $output .= '<td>' . null . '</td>';
                                    }
                                    if ($res->where('exmset_id', 3)->count() > 0) {
                                        $eot_mark = $res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100;
                                        $output .= '<td>' . $eot_mark . '</td>';
                                    } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                        $eot_mark = 0;
                                        $output .= '<td>' . null . '</td>';
                                    }
                                    $final_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);

                                    $output .= '<td>' . round(array_sum($res->pluck('calculate_mark')->toArray()), 2) . '</td>';
                                    $output .= '<td>' . $final_total . '</td>';
                                    $output .= '<td>';
                                    if ($final_total > 90) {
                                        $final_grade = "A+";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total > 90) {
                                        $final_grade = "A+";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 80 && $final_total < 90) {
                                        $final_grade = "A";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 75 && $final_total < 80) {
                                        $final_grade = "B+";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 70 && $final_total < 75) {
                                        $final_grade = "B-";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 65 && $final_total < 70) {
                                        $final_grade = "C+";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 60 && $final_total < 65) {
                                        $final_grade = "C-";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 55 && $final_total < 60) {
                                        $final_grade = "D+";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total >= 50 && $final_total < 55) {
                                        $final_grade = "D-";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    } elseif ($final_total < 50) {
                                        $final_grade = "F";
                                        $output .= '<span>' . $final_grade . '</span>';
                                    }
                                    $output .= '</td><td>';
                                    $output .= ($final_grade !== null ? $this->teacherComment($final_grade) : null);
                                    $output .= '</td>';

                                    $output .= '</tr></tr>';
                                }
                            } elseif ($res->where('subject_id', request()->subject_id)->count() == 0) {
                                $output . '<tr><h3 class="display-1 text-danger">Subject has No results yet</h3></tr>';
                            }


                            // $output .= '<tr><td>'.$res->first()->student->name.'</td></tr>';
                        }
                    }
                    $output .= '</table>';
                } else {
                    $output .= "<div class='alert alert-warning col-12 my-auto mx-auto'>No class information</div>";
                }
            }
            return $output;
        }
        return response()->json(['action' => $request['action'], 'query' => $request['query']]);
    }

    public function commentSubject(Request $request)
    {
        $output = "";

        if (request()->subject !== null && request()->teacher !== null && request()->student !== null) {
            $output .= '


                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Add Comment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="{{route("paper-comments.store")}}">

                                <div class="modal-body">
                                    <div class="form-group d-block col-12">

                                    </div>
                                    <div class="form-group d-block col-12">

                                    </div>
                                    <div class="form-group d-block col-12">

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>

                            </form>

                        </div>
                    <!-- /.modal-content -->
                    </div>
                <!-- /.modal-dialog -->
                </div>



            ';

            return $output;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        // 0751340462
    }


    public function printPdf()
    {

        $results = Result::orderBy('student_id')->get();
        $pdf = PDF::loadView('pdf.students', compact('results'));
        $pdf->save(public_path('files/') . '_filename.pdf');
        return $pdf->download('results.pdf');
    }

    public function teacherComment($subjectGrade)
    {
        if ($subjectGrade == "A+") {
            $arr = array('Excellent work', 'Keep it Up', "keep aiming higher");
            return $arr[rand(0, 2)];
        } elseif ($subjectGrade == "A") {
            $arr = array('Aim higher', 'You have greater Pontential', "Great hardwork, aim higher", 'Goodwork');
            return $arr[rand(0, 3)];
        } elseif ($subjectGrade == "B+") {
            $arr = array('You could do better', 'You have greater Pontential', "Average", "Good");
            return $arr[rand(0, 3)];
        } elseif ($subjectGrade == "B-") {
            $arr = array('You could do better', 'You have greater Pontential', "Fair work", "Do Better");
            return $arr[rand(0, 3)];
        } elseif ($subjectGrade == "C+") {
            $arr = array('You could do better', 'Give your studies ample time', "Fair work", "Utilize your teacher Well");
            return $arr[rand(0, 3)];
        } elseif ($subjectGrade == "C-") {
            $arr = array('You could do better', 'Give your studies ample time', "Fair work", "Utilize your teacher Well");
            return $arr[rand(0, 3)];
        } elseif ($subjectGrade == "D+" || $subjectGrade == "D-") {
            $arr = array('You are better than this', 'revise you books', "fair try", "Utilize your teacher Well");
            return $arr[rand(0, 3)];
        } elseif ($subjectGrade == "F") {
            $arr = array('Pull up your socks', 'Utilize your teacher Well', 'Read your books', 'Need of hardwork');
            return $arr[rand(0, 3)];
        }
    }

    public function ResultSearch(Request $request)
    {


        return $this->allResultTable(request()->search_class, request()->search_term, request()->search_student);
    }

    public function allResultTable($search_class, $search_term, $search_student)
    {
        // if($search_class==null&& $search_term==null && $search_student==null)
        // {

        // }
        if ($search_class == null || $search_term == null  || $search_student == null) {
            $results = new Result();
            $students = new Student();
            $output = "";
            global $bot_mark, $bot_mark1, $bot_mark2, $bot_mark3,
                $mot_mark, $mot_mark1, $mot_mark2, $mot_mark3,
                $eot_mark, $eot_mark1, $eot_mark2, $eot_mark3,
                $paper_1_total, $paper_total1, $paper_total2, $paper_total3;

            if ($results->get()->count() > 0) {
                $output .= '
                <div class="card-body table-responsive p-0 elevation-2 animated flipInX" style="height: 400px;">
                    <table id="RoleTable" class="table table-bordered table-head-fixed text-nowrap">
                    <thead>
                        <th colspan="2">Subject</th>

                        <th>Bot <br> out of ' . Exmset::find(1)->set_percentage . '</th>
                        <th>Mot<br> out of ' . Exmset::find(2)->set_percentage . '</th>
                        <th>Eot <br>out of ' . Exmset::find(3)->set_percentage . '</th>
                        <th>Total Marks<br> of' . '100' . '</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </thead>
                    <tbody>
                    ';
                if ($results->where('student_id', ($search_student == null ? '' : $search_student))->where('schclass_id', 'like', '%' . ($search_class == null ? '' : $search_class) . '%')->where('term_id', 'like', '%' . ($search_term == null ? '' : $search_term) . '%')->count() > 0) {
                    foreach ($results->where('student_id', ($search_student == null ? '' : $search_student))->where('schclass_id', 'like', '%' . ($search_class == null ? '' : $search_class) . '%')->where('term_id', 'like', '%' . ($search_term == null ? '' : $search_term) . '%')->get()->groupBy('term_id') as $ter_id => $ter_res) {
                        $output .= '<tr class="bg-dark"><td colspan="2">' . $ter_res->where('term_id', $ter_id)->first()->term->name . '</td><td colspan="3">' . $ter_res->first()->schclass->name . '</td><td colspan="4">' . $ter_res->first()->student->name . '</td>
                        .
                        </tr>';

                        // if($ter_res->where('schclass_id','like','%'.($search_class==null?'':$search_class).'%')->count()>0)
                        // {

                        foreach ($ter_res->groupBy('schclass_id') as $class_id => $class_res) {
                            // $output.='<tr><td colspan="9">'.$ter_res->where('schclass_id',$class_id)->first()->schclass->name.'</td></tr>';

                            foreach ($class_res->groupBy('student_id') as $stud => $resul) {



                                // $output.='<tr><td colspan="9">'.$students->find($stud)->name.'</td></tr>';
                                foreach ($resul->groupBy('subject_id') as $sub_id => $res) {

                                    // subject with three papers
                                    if ($res->where('subject_id', $sub_id)->first()->subject->papersIn()->count() == 3 && $res->first()->paper_id != null) {
                                        $output .= '
                                                        <tr>
                                                        <tr>
                                                        <td rowspan="3">' . $res->where('subject_id', $sub_id)->first()->subject->name . '</td>
                                                        <td>';
                                        if ($res->count() > 0) {
                                            $output .= $res->first()->paper->paper_abbrev;
                                        } elseif ($res->count() == 0) {
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        <td>';

                                        if ($res->where('exmset_id', 1)->count() > 0) {
                                            $bot_mark = round(($res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                            $output .= $bot_mark;
                                        } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                            $bot_mark = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';

                                        if ($res->where('exmset_id', 2)->count() > 0) {
                                            $mot_mark = round($res->where('exmset_id', 2)->first()->mark * round((Exmset::find(2)->set_percentage / 100), 2), 2);
                                            $output .= $mot_mark;
                                        } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                            $mot_mark = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';

                                        if ($res->where('exmset_id', 3)->count() > 0) {

                                            $eot_mark = round(($res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                            $output .= $eot_mark;
                                        } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                            $eot_mark = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';

                                        if ($res->count() > 0) {
                                            $paper_1_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                            $output .= $paper_1_total;
                                        } elseif ($res->count() == 0) {
                                            $paper_1_total = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td rowspan="3">';
                                        if ($res->count() > 0) {
                                            $bot_mark1 = ($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                                : 0);
                                            $mot_mark1 = ($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                                : 0);
                                            $eot_mark1 = ($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                                : 0);
                                            $paper_total1 = round(array_sum(array($bot_mark1, $mot_mark1, $eot_mark1)), 2);
                                        }
                                        if ($res->count() == 0) {
                                            $paper_total1 = 0;
                                            $output .= "";
                                        }
                                        if ($res->count() > 1) {
                                            $bot_mark2 = ($res->where('exmset_id', 1)->where('paper_id', $res[1]->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 1)->where('paper_id', $res[1]->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                                : 0);
                                            $mot_mark2 = ($res->where('exmset_id', 2)->where('paper_id', $res[1]->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 2)->where('paper_id', $res[1]->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                                : 0);
                                            $eot_mark2 = ($res->where('exmset_id', 3)->where('paper_id', $res[1]->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 3)->where('paper_id', $res[1]->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                                : 0);
                                            $paper_total2 = round(array_sum(array($bot_mark2, $mot_mark2, $eot_mark2)), 2);
                                        }
                                        if ($res->count() < 1) {
                                            $paper_total2 = 0;
                                        }
                                        if ($res->count() > 2) {
                                            $bot_mark3 = ($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                                : 0);
                                            $mot_mark3 = ($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                                : 0);
                                            $eot_mark3 = ($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                                : 0);
                                            $paper_total3 = round(array_sum(array($bot_mark3, $mot_mark3, $eot_mark3)), 2);
                                        }
                                        if ($res->count() < 2) {
                                            $paper_total3 = 0;
                                        }
                                        $Subject_final_mark = round(array_sum(array($paper_total1, $paper_total2, $paper_total3)) / 3, 2);
                                        $output .= $Subject_final_mark;


                                        $output .= '</td>
                                                        <td rowspan="3">';
                                        if ($Subject_final_mark > 90) {
                                            $Subject_final_grade = "A+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 80 && $Subject_final_mark < 90) {
                                            $Subject_final_grade = "A";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 75 && $Subject_final_mark < 80) {
                                            $Subject_final_grade = "B+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 70 && $Subject_final_mark < 75) {
                                            $Subject_final_grade = "B";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 65 && $Subject_final_mark < 70) {
                                            $Subject_final_grade = "C+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 60 && $Subject_final_mark < 65) {
                                            $Subject_final_grade = "C";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 55 && $Subject_final_mark < 60) {
                                            $Subject_final_grade = "C";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 50 && $Subject_final_mark < 55) {
                                            $Subject_final_grade = "C";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark < 50) {
                                            $Subject_final_grade = "F";
                                            $output .= $Subject_final_grade;
                                        }
                                        $output .= '</td>
                                                        <td rowspan="3">
                                                        ' . ($Subject_final_grade !== null ? $this->teacherComment($Subject_final_grade) : null) . '
                                                        </td>

                                                        </tr>
                                                        <tr>
                                                            <td>';
                                        if ($res->count() > 1) {
                                            $output .= $res[1]->paper->paper_abbrev;
                                        } elseif ($res->count() < 1) {
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 1)->count() > 1) {
                                            $bot_mark = round(($res->where('exmset_id', 1)->nth(2, 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                            $output .= $bot_mark;
                                        } elseif ($res->where('exmset_id', 1)->count() < 1) {
                                            $bot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 2)->count() > 1) {
                                            $mot_mark = round(($res->where('exmset_id', 2)->nth(2, 1)->first()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                            $output .= $mot_mark;
                                        } elseif ($res->where('exmset_id', 2)->count() < 1) {
                                            $mot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 3)->count() > 1) {
                                            $eot_mark = round(($res->where('exmset_id', 3)->nth(2, 1)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                            $output .= $eot_mark;
                                        } elseif ($res->where('exmset_id', 3)->count() < 1) {
                                            $eot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->count() > 1) {
                                            $paper_2_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                            $output .= $paper_2_total;
                                        } elseif ($res->count() < 1) {
                                            $paper_2_total = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>';
                                        if ($res->count() > 2) {
                                            $output .= $res->last()->paper->paper_abbrev;
                                        } elseif ($res->count() < 2) {
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 1)->count() > 2) {
                                            $bot_mark = round(($res->where('exmset_id', 1)->last()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                            $output .= $bot_mark;
                                        } elseif ($res->where('exmset_id', 1)->count() < 2) {
                                            $bot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 2)->count() > 2) {
                                            $mot_mark = round(($res->where('exmset_id', 2)->last()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                            $output .= $mot_mark;
                                        } elseif ($res->where('exmset_id', 2)->count() < 2) {
                                            $mot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 3)->count() > 2) {
                                            $eot_mark = round(($res->where('exmset_id', 3)->last()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                            $output .= $eot_mark;
                                        } elseif ($res->where('exmset_id', 3)->count() < 2) {
                                            $eot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->count() > 2) {
                                            $paper_3_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                            $output .= $paper_3_total;
                                        } elseif ($res->count() < 2) {
                                            $paper_3_total = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        </tr>
                                                        </tr>';
                                    }



                                    // subject with two papers

                                    elseif ($res->where('subject_id', $sub_id)->first()->subject->papersIn()->count() == 2 && $res->where('subject_id', $sub_id)->first()->paper_id != null) {
                                        $output .= '
                                                        <tr>
                                                        <tr>
                                                        <td rowspan="2">' . $res->where('subject_id', $sub_id)->first()->subject->name . '</td>
                                                        <td>';
                                        if ($res->count() > 0) {
                                            $output .= $res->first()->paper->paper_abbrev;
                                        } elseif ($res->count() == 0) {
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        <td>';

                                        if ($res->where('exmset_id', 1)->count() > 0) {
                                            $bot_mark = round(($res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                            $output .= $bot_mark;
                                        } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                            $bot_mark = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';

                                        if ($res->where('exmset_id', 2)->count() > 0) {
                                            $mot_mark = round($res->where('exmset_id', 2)->first()->mark * round((Exmset::find(2)->set_percentage / 100), 2), 2);
                                            $output .= $mot_mark;
                                        } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                            $mot_mark = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';

                                        if ($res->where('exmset_id', 3)->count() > 0) {

                                            $eot_mark = round(($res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                            $output .= $eot_mark;
                                        } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                            $eot_mark = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';

                                        if ($res->count() > 0) {
                                            $paper_1_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                            $output .= $paper_1_total;
                                        } elseif ($res->count() == 0) {
                                            $paper_1_total = 0;
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td rowspan="2">';
                                        if ($res->count() > 0) {
                                            $bot_mark1 = ($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 1)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                                : 0);
                                            $mot_mark1 = ($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 2)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                                : 0);
                                            $eot_mark1 = ($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 3)->where('paper_id', $res->first()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                                : 0);
                                            $paper_total1 = round(array_sum(array($bot_mark1, $mot_mark1, $eot_mark1)), 2);
                                        }
                                        if ($res->count() == 0) {
                                            $paper_total1 = 0;
                                            $output .= "";
                                        }

                                        if ($res->count() > 1) {
                                            $bot_mark3 = ($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 1)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(1)->set_percentage) / 100, 2)
                                                : 0);
                                            $mot_mark3 = ($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 2)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(2)->set_percentage) / 100, 2)
                                                : 0);
                                            $eot_mark3 = ($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->count() > 0 ?
                                                round(($res->where('exmset_id', 3)->where('paper_id', $res->last()->paper_id)->first()->mark * Exmset::find(3)->set_percentage) / 100, 2)
                                                : 0);
                                            $paper_total2 = round(array_sum(array($bot_mark3, $mot_mark3, $eot_mark3)), 2);
                                        }
                                        if ($res->count() < 2) {
                                            $paper_total2 = 0;
                                        }
                                        $Subject_final_mark = round(array_sum(array($paper_total1, $paper_total2)) / 2, 2);
                                        $output .= $Subject_final_mark;


                                        $output .= '</td>
                                                        <td rowspan="2">';
                                        if ($Subject_final_mark > 90) {
                                            $Subject_final_grade = "A+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 80 && $Subject_final_mark < 90) {
                                            $Subject_final_grade = "A";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 75 && $Subject_final_mark < 80) {
                                            $Subject_final_grade = "B+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 70 && $Subject_final_mark < 75) {
                                            $Subject_final_grade = "B-";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 65 && $Subject_final_mark < 70) {
                                            $Subject_final_grade = "C+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 60 && $Subject_final_mark < 65) {
                                            $Subject_final_grade = "C-";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 55 && $Subject_final_mark < 60) {
                                            $Subject_final_grade = "D+";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark >= 50 && $Subject_final_mark < 55) {
                                            $Subject_final_grade = "D-";
                                            $output .= $Subject_final_grade;
                                        }
                                        if ($Subject_final_mark < 50) {
                                            $Subject_final_grade = "F";
                                            $output .= $Subject_final_grade;
                                        }
                                        $output .= '</td>
                                                        <td rowspan="2">
                                                        ' . ($Subject_final_grade !== null ? $this->teacherComment($Subject_final_grade) : null) . '

                                                        </td>

                                                        </tr>

                                                        <tr>
                                                            <td>';
                                        if ($res->count() > 1) {
                                            $output .= $res->last()->paper->paper_abbrev;
                                        } elseif ($res->count() < 1) {
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 1)->count() > 1) {
                                            $bot_mark = round(($res->where('exmset_id', 1)->last()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                            $output .= $bot_mark;
                                        } elseif ($res->where('exmset_id', 1)->count() < 1) {
                                            $bot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 2)->count() > 1) {
                                            $mot_mark = round(($res->where('exmset_id', 2)->last()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                            $output .= $mot_mark;
                                        } elseif ($res->where('exmset_id', 2)->count() < 1) {
                                            $mot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->where('exmset_id', 3)->count() > 1) {
                                            $eot_mark = round(($res->where('exmset_id', 3)->last()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                            $output .= $eot_mark;
                                        } elseif ($res->where('exmset_id', 3)->count() < 1) {
                                            $eot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                            <td>';
                                        if ($res->count() > 1) {
                                            $paper_3_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);
                                            $output .= $paper_3_total;
                                        } elseif ($res->count() < 1) {
                                            $paper_3_total = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        </tr>
                                                        </tr>';
                                    } elseif ($res->where('subject_id', $sub_id)->first()->subject->papersIn()->count() == 0 && $res->where('subject_id', $sub_id)->first()->paper_id != null) {
                                        $output .= '<h3 class="display-1">' . $res->where('subject_id', $sub_id)->first()->subject->name . '</h3>';
                                    } elseif ($res->where('subject_id', $sub_id)->first()->subject->papersIn()->count() > 0 && $res->where('subject_id', $sub_id)->first()->paper_id == null) {

                                        $output .= '<tr><tr>
                                                        <td colspan="2">';
                                        if ($res->count() > 0) {
                                            $output .= $res->first()->subject->name;
                                        } elseif ($res->count() < 0) {
                                            $output .= "";
                                        }

                                        $output .= '</td>
                                                        <td>';
                                        if ($res->where('exmset_id', 1)->count() > 0) {
                                            $bot_mark = round(($res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100), 2);
                                            $output .= $bot_mark;
                                        } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                            $bot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        <td>';
                                        if ($res->where('exmset_id', 2)->count() > 0) {
                                            $mot_mark = round(($res->where('exmset_id', 2)->first()->mark * Exmset::find(2)->set_percentage / 100), 2);
                                            $output .= $mot_mark;
                                        } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                            $mot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        <td>';
                                        if ($res->where('exmset_id', 3)->count() > 0) {
                                            $eot_mark = round(($res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100), 2);
                                            $output .= $eot_mark;
                                        } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                            $eot_mark = 0;
                                            $output .= "";
                                        }
                                        $output .= '</td>
                                                        <td>';
                                        if ($res->count() > 0) {
                                            $total_mark = round((array_sum(array($bot_mark, $mot_mark, $eot_mark))), 2);
                                            $output .= $total_mark;
                                        }

                                        $output .= '</td>
                                                        <td>';
                                        if ($res->count() > 0) {
                                            $total_mark = round((array_sum(array($bot_mark, $mot_mark, $eot_mark))), 2);
                                            $output .= $total_mark;
                                        }

                                        $output .= '</td>
                                                        <td>';
                                        if ($res->count() > 0) {
                                            $total_mark = round((array_sum(array($bot_mark, $mot_mark, $eot_mark))), 2);
                                            if ($total_mark > 90) {
                                                $Subject_final_grade = "A+";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 80 && $total_mark < 90) {
                                                $Subject_final_grade = "A";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 75 && $total_mark < 80) {
                                                $Subject_final_grade = "B+";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 70 && $total_mark < 75) {
                                                $Subject_final_grade = "B-";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 65 && $total_mark < 70) {
                                                $Subject_final_grade = "C+";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 60 && $total_mark < 65) {
                                                $Subject_final_grade = "C-";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 55 && $total_mark < 60) {
                                                $Subject_final_grade = "D+";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark >= 50 && $total_mark < 55) {
                                                $Subject_final_grade = "D-";
                                                $output .= $Subject_final_grade;
                                            }
                                            if ($total_mark < 50) {
                                                $Subject_final_grade = "F";
                                                $output .= $Subject_final_grade;
                                            }
                                        }

                                        $output .= '</td>
                                                        <td>' . ($Subject_final_grade !== null ? $this->teacherComment($Subject_final_grade) : null) . '</td>
                                                        ';
                                    } else {
                                        $output .= '
                                                        <tr><tr>
                                                        <td colspan="2">' . $res->first()->subject->name . '</td>';
                                        if ($res->where('exmset_id', 1)->count() > 0) {
                                            $bot_mark = $res->where('exmset_id', 1)->first()->mark * Exmset::find(1)->set_percentage / 100;
                                            $output .= '<td>' . $bot_mark . '</td>';
                                        } elseif ($res->where('exmset_id', 1)->count() == 0) {
                                            $bot_mark = 0;
                                            $output .= '<td>' . null . '</td>';
                                        }
                                        if ($res->where('exmset_id', 2)->count() > 0) {
                                            $mot_mark = $res->where('exmset_id', 2)->first()->mark * Exmset::find(2)->set_percentage / 100;
                                            $output .= '<td>' . $mot_mark . '</td>';
                                        } elseif ($res->where('exmset_id', 2)->count() == 0) {
                                            $mot_mark = 0;
                                            $output .= '<td>' . null . '</td>';
                                        }
                                        if ($res->where('exmset_id', 3)->count() > 0) {
                                            $eot_mark = $res->where('exmset_id', 3)->first()->mark * Exmset::find(3)->set_percentage / 100;
                                            $output .= '<td>' . $eot_mark . '</td>';
                                        } elseif ($res->where('exmset_id', 3)->count() == 0) {
                                            $eot_mark = 0;
                                            $output .= '<td>' . null . '</td>';
                                        }
                                        $final_total = round(array_sum(array($bot_mark, $mot_mark, $eot_mark)), 2);

                                        $output .= '<td>' . round(array_sum($res->pluck('calculate_mark')->toArray()), 2) . '</td>';
                                        $output .= '<td>' . $final_total . '</td>';
                                        $output .= '<td>';
                                        if ($final_total > 90) {
                                            $final_grade = "A+";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total > 90) {
                                            $final_grade = "A+";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 80 && $final_total < 90) {
                                            $final_grade = "A";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 75 && $final_total < 80) {
                                            $final_grade = "B+";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 70 && $final_total < 75) {
                                            $final_grade = "B-";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 65 && $final_total < 70) {
                                            $final_grade = "C+";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 60 && $final_total < 65) {
                                            $final_grade = "C-";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 55 && $final_total < 60) {
                                            $final_grade = "D+";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total >= 50 && $final_total < 55) {
                                            $final_grade = "D-";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        } elseif ($final_total < 50) {
                                            $final_grade = "F";
                                            $output .= '<span>' . $final_grade . '</span>';
                                        }
                                        $output .= '</td><td>';
                                        $output .= ($final_grade !== null ? $this->teacherComment($final_grade) : null);
                                        $output .= '</td>';

                                        $output .= '</tr></tr>';
                                    }
                                }
                            }
                        }
                        // }
                        // elseif($ter_res->where('schclass_id','like','%'.($search_class==null?'':$search_class).'%')->count()==0)
                        // {
                        //     $output.='<tr>
                        //         <td colspan="9">
                        //             No information for this class
                        //         </td>

                        //     </tr>';
                        // }



                    }
                } elseif ($results->where('term_id', 'like', '%' . ($search_term == null ? '' : $search_term) . '%')->count() == 0) {
                    $output .= '<tr>
                                <td colspan="9">
                                    No information for results of student
                                </td>

                            </tr>';
                }


                $output .= '
                    </tbody>
                    <tfooter>
                        <th colspan="2">Subject</th>
                        <th>Bot <br> out of ' . Exmset::find(1)->set_percentage . '</th>
                        <th>Mot<br> out of ' . Exmset::find(2)->set_percentage . '</th>
                        <th>Eot <br>out of ' . Exmset::find(3)->set_percentage . '</th>
                        <th>Total Marks<br> of' . '100' . '</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </tfooter>
                    </table>
                    </div>
                    ';
            } elseif ($results->get()->count() == 0) {
                $output .= '<div class=""display-1>
                            <p>Student not existing</p>
                        </div>';
            }

            return $output;
        }
    }



    public function vertResults($paper1, $paper2, $paper3)
    {
        return response()->json(compact('paper1', 'paper2', 'paper3'));
    }

    public function papers($one, $two, $three)
    {
        $papers = array();



        if ($one != null && $two != null && $three != null) {
            $one = $this->resultGrade($one);
            $two = $this->resultGrade($two);
            $three = $this->resultGrade($three);
            $papers = array($one[1], $two[1], $three[1]);
            return response()->json($papers);
            // $sum = array_sum($papers);
            // $i=1;
            // while($i<=4)
            // {
            //     if($sum <=7)
            //     {
            //         $grade = "A";
            //         $points = 6;
            //         return response()->json(compact('sum','grade','points'));
            //     }
            //     elseif(in_array(5,$papers))
            //     {
            //         $grade = "B";
            //         $points = 5;
            //         return response()->json(compact('sum','grade','points'));
            //     }
            //     $i++;

            // }



        }

        // return response()->json(compact('one','two','three'));

    }

    public function resultGrade($mark)
    {
        $output_array = array();

        if ($mark > 80) {
            $grade = "D1";
            $aggre = 1;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 75 && $mark < 80) {
            $grade = "D2";
            $aggre = 2;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 70 && $mark < 75) {
            $grade = "C3";
            $aggre = 3;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 65 && $mark < 70) {
            $grade = "C4";
            $aggre = 4;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 60 && $mark < 65) {
            $grade = "C5";
            $aggre = 5;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 55 && $mark < 60) {
            $grade = "C6";
            $aggre = 6;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 45 && $mark < 55) {
            $grade = "P7";
            $aggre = 7;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark >= 35 && $mark < 45) {
            $grade = "P8";
            $aggre = 8;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
        if ($mark < 35) {
            $grade = "F9";
            $aggre = 9;
            array_push($output_array, $grade);
            array_push($output_array, $aggre);
            return $output_array;
        }
    }
}
