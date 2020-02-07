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
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResultController extends BackendController
{
    public function getBot($term,$set)
    {
        $values = array('term'=>request()->term,'set'=>request()->set);
        return view('manage-results.create-results',compact('values'));
    }

    public function fetchPapers(Request $request)
    {
        if($request['action']!=null)
        {
            $subject = new Subject();
            $schclass = new Schclass();
            $student = new Student();
            $output = null;
            if($request['action']=='schclass'){
                $result = $subject->where('level',$schclass->find($request['query'])->level)->orderBy('name')->get();
                $output.='<option value="">Select Subject</option>';
                foreach($result as $row)
                {
                    $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
            }
            if($request['action']=='subject'){
                $result = $student->where('schclass_id',$schclass->find($request['class_id'])->id)->orderBy('name')->get();
                $output.='<option value="">Select Student</option>';
                foreach($result as $row)
                {
                    $output .= '<option value="'.$row['id'].'">'.$row['name'].'|'.$row['roll_number'].'</option>';
                }
            }
            if($request['action'] =='student'){



            }
            if($request['action']=='has_papers'){
                if($request['subject_id'] != null)
                {
                   if($request['query'])
                   {

                        if($subject->with('papersIn')->find($request['subject_id'])->papersIn()->count()>0)
                        {
                            $result = $subject->with('papersIn')->find($request['subject_id'])->papersIn()->get();
                            foreach($result as $row)
                            {

                                    $output.=
                                    '
                                        <label>'.$row['paper_abbrev'].'</label>
                                        <div class="">
                                            <div class="chosen-select-single mg-b-20">
                                                    <input  type="number" name="'.$row['paper_abbrev'].'" class="marks form-control" id="'.$row['paper_abbrev'].'"/>
                                            </div>
                                        </div>
                                    ';

                            }

                        }
                        else{
                            $output.=
                            '
                            <label>No Paper Assigned Yet</label>
                            '.'
                            <label>Subject Marks</label>
                            <div class="">
                                <div class="chosen-select-single mg-b-20">
                                        <input name="paper_mark" type="number" class="marks form-control" id="paper_mark"/>
                                </div>
                            </div>
                        ';
                        }

                   }
                   else{
                    $output.=
                    '
                        <label>Subject Marks</label>
                        <div class="">
                            <div class="chosen-select-single mg-b-20">
                                    <input name="paper_mark" type="number" class="marks form-control" id="paper_mark"/>
                            </div>
                        </div>
                    ';

                }

                }





                else{
                    $output.="<label>No Subject Selected, Please fill the fields before</label>";
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
        $result_list = Result::orderBy('student_id')->get()->groupBy(function($item){
            return $item->student_id;
        });

        return view('manage-results.report-test', compact('results','subjects','result_list','students'));
    }

    public function storeStudentMarks(Request $request)
    {
        $rule = array(
            'teacher_id'=>'required',
            'subject'=>'required',
            'student'=>'required',
            'term'=>'required',
            'set'=>'required',
            'schclass'=>'required',
            'has_paper'=>'nullable',
            'P1'=>'nullable|integer',
            'P2'=>'nullable|integer',
            'P3'=>'nullable|integer',
            'paper_mark'=>'nullable|integer',
        );

        $term = '';
        $set = '';
        $grade = '';

        $grade_point = '';
        $paper_all_marks = [];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails())
            {
                return response()->json(['errors'=>$validator->messages()]);
            }

        if($request['P1']!=null || $request['paper_mark']!=null){
            if($request['term']=='term-1'){ $term =1;}
            if($request['term']=='term-2'){ $term =2;}
            if($request['term']=='term-3'){ $term =3;}
            if($request['set']=='b-o-t'){ $set =1;}
            if($request['set']=='m-o-t'){ $set =2;}
            if($request['set']=='e-o-t'){ $set =3;}

            $result = new Result();
            $marks = new Mark();
            $subject = new Subject();
            $student = new Student();






            if($request['paper_mark']!=null)
            {
                if($subject->find($request['subject'])->level == 'Advanced Level'){
                    if($request['paper_mark']<=39.9){$grade='F';$grade_point=0;}
                    if($request['paper_mark']>39.9 && $request['paper_mark']<=44.9){$grade='0';$grade_point=0;}
                    if($request['paper_mark']>44.9 && $request['paper_mark']<=49.9){$grade='E';$grade_point=1;}
                    if($request['paper_mark']>49.9 && $request['paper_mark']<=54.9){$grade='D-';$grade_point=2;}
                    if($request['paper_mark']>54.9 && $request['paper_mark']<=59.9){$grade='D+';$grade_point=2.5;}
                    if($request['paper_mark']>59.9 && $request['paper_mark']<=64.9){$grade='C-';$grade_point=3;}
                    if($request['paper_mark']>64.9 && $request['paper_mark']<=69.9){$grade='C+';$grade_point=3.5;}
                    if($request['paper_mark']>69.9 && $request['paper_mark']<=74.9){$grade='B-';$grade_point=4;}
                    if($request['paper_mark']>79.9 && $request['paper_mark']<=84.9){$grade='B+';$grade_point=4.5;}
                    if($request['paper_mark']>84.9 && $request['paper_mark']<=89.9){$grade='A';$grade_point=5;}
                    if($request['paper_mark']>89.9 && $request['paper_mark']<=100){$grade='A+';$grade_point=5.5;}
                }
                if($subject->find($request['subject'])->level == 'Ordinary Level'){
                    if($request['paper_mark']<=39.9){$grade='F';$grade_point=0;}
                    if($request['paper_mark']>39.9 && $request['paper_mark']<=44.9){$grade='0';$grade_point=0;}
                    if($request['paper_mark']>44.9 && $request['paper_mark']<=49.9){$grade='E';$grade_point=1;}
                    if($request['paper_mark']>49.9 && $request['paper_mark']<=54.9){$grade='D-';$grade_point=2;}
                    if($request['paper_mark']>54.9 && $request['paper_mark']<=59.9){$grade='D+';$grade_point=2.5;}
                    if($request['paper_mark']>59.9 && $request['paper_mark']<=64.9){$grade='C-';$grade_point=3;}
                    if($request['paper_mark']>64.9 && $request['paper_mark']<=69.9){$grade='C+';$grade_point=3.5;}
                    if($request['paper_mark']>69.9 && $request['paper_mark']<=74.9){$grade='B-';$grade_point=4;}
                    if($request['paper_mark']>79.9 && $request['paper_mark']<=84.9){$grade='B+';$grade_point=4.5;}
                    if($request['paper_mark']>84.9 && $request['paper_mark']<=89.9){$grade='A';$grade_point=5;}
                    if($request['paper_mark']>89.9 && $request['paper_mark']<=100){$grade='A+';$grade_point=5.5;}
                }





                Result::create(array(
                    'user_id'=>$request['teacher_id'],
                    'student_id'=>$request['student'],
                    'schclass_id'=>$request['schclass'],
                    'subject_id'=>$request['subject'],
                    'paper_id'=>null,
                    'term_id'=>$term,
                    'exmset_id'=>$set,
                    'mark'=>$request['paper_mark'],
                    'grade'=>$grade,
                    'comments'=>null,
                    'year'=>null
                ));
                // $marks->save();
                Mark::create(array(
                    'student_id'=>$request['student'],
                    'subject_id'=>$request['subject'],
                    'grade'=>$grade,
                    'final_mark'=>$request['paper_mark'],
                    'teacher_comment'=>null,
                    'points'=>$grade_point
                ));

                return response()->json(['success'=>'Saved Successfully']);
            }

            if($request['P1']!=null)
            {
                foreach($subject->with('papersIn')->find($request['subject'])->papersIn()->get() as $sub)
                {
                    if($subject->find($request['subject'])->level == 'Advanced Level')
                    {
                        if($request[$sub['paper_abbrev']]<=39.9){$grade='F';$grade_point=0;}
                        if($request[$sub['paper_abbrev']]>39.9 && $request[$sub['paper_abbrev']]<=44.9){$grade='0';$grade_point=0;}
                        if($request[$sub['paper_abbrev']]>44.9 && $request[$sub['paper_abbrev']]<=49.9){$grade='E';$grade_point=1;}
                        if($request[$sub['paper_abbrev']]>49.9 && $request[$sub['paper_abbrev']]<=54.9){$grade='D-';$grade_point=2;}
                        if($request[$sub['paper_abbrev']]>54.9 && $request[$sub['paper_abbrev']]<=59.9){$grade='D+';$grade_point=2.5;}
                        if($request[$sub['paper_abbrev']]>59.9 && $request[$sub['paper_abbrev']]<=64.9){$grade='C-';$grade_point=3;}
                        if($request[$sub['paper_abbrev']]>64.9 && $request[$sub['paper_abbrev']]<=69.9){$grade='C+';$grade_point=3.5;}
                        if($request[$sub['paper_abbrev']]>69.9 && $request[$sub['paper_abbrev']]<=74.9){$grade='B-';$grade_point=4;}
                        if($request[$sub['paper_abbrev']]>79.9 && $request[$sub['paper_abbrev']]<=84.9){$grade='B+';$grade_point=4.5;}
                        if($request[$sub['paper_abbrev']]>84.9 && $request[$sub['paper_abbrev']]<=89.9){$grade='A';$grade_point=5;}
                        if($request[$sub['paper_abbrev']]>89.9 && $request[$sub['paper_abbrev']]<=100){$grade='A+';$grade_point=5.5;}
                    }

                    if($subject->find($request['subject'])->level == 'Ordinary Level')
                    {
                        if($request[$sub['paper_abbrev']]<=39.9){$grade='F';$grade_point=0;}
                        if($request[$sub['paper_abbrev']]>39.9 && $request[$sub['paper_abbrev']]<=44.9){$grade='0';$grade_point=0;}
                        if($request[$sub['paper_abbrev']]>44.9 && $request[$sub['paper_abbrev']]<=49.9){$grade='E';$grade_point=1;}
                        if($request[$sub['paper_abbrev']]>49.9 && $request[$sub['paper_abbrev']]<=54.9){$grade='D-';$grade_point=2;}
                        if($request[$sub['paper_abbrev']]>54.9 && $request[$sub['paper_abbrev']]<=59.9){$grade='D+';$grade_point=2.5;}
                        if($request[$sub['paper_abbrev']]>59.9 && $request[$sub['paper_abbrev']]<=64.9){$grade='C-';$grade_point=3;}
                        if($request[$sub['paper_abbrev']]>64.9 && $request[$sub['paper_abbrev']]<=69.9){$grade='C+';$grade_point=3.5;}
                        if($request[$sub['paper_abbrev']]>69.9 && $request[$sub['paper_abbrev']]<=74.9){$grade='B-';$grade_point=4;}
                        if($request[$sub['paper_abbrev']]>79.9 && $request[$sub['paper_abbrev']]<=84.9){$grade='B+';$grade_point=4.5;}
                        if($request[$sub['paper_abbrev']]>84.9 && $request[$sub['paper_abbrev']]<=89.9){$grade='A';$grade_point=5;}
                        if($request[$sub['paper_abbrev']]>89.9 && $request[$sub['paper_abbrev']]<=100){$grade='A+';$grade_point=5.5;}
                    }

                    Result::create(array(
                        'user_id'=>$request['teacher_id'],
                        'student_id'=>$request['student'],
                        'schclass_id'=>$request['schclass'],
                        'subject_id'=>$request['subject'],
                        'paper_id'=>$sub['id'],
                        'term_id'=>$term,
                        'exmset_id'=>$set,
                        'mark'=>$request[$sub['paper_abbrev']],
                        'grade'=>$grade,
                        'comments'=>null,
                        'year'=>null
                    ));


                    $paper_all_marks = array_merge($paper_all_marks,[$request[$sub['paper_abbrev']]]);

                }


                    $paper_all_marks_final_mark =array_sum($paper_all_marks)/count($paper_all_marks);


                    if($subject->find($request['subject'])->level == 'Advanced Level')
                    {

                        if( $paper_all_marks_final_mark<=39.9){$grade='F';$grade_point=0;}
                        if( $paper_all_marks_final_mark>39.9 &&  $paper_all_marks_final_mark<=44.9){$grade='0';$grade_point=0;}
                        if( $paper_all_marks_final_mark>44.9 &&  $paper_all_marks_final_mark<=49.9){$grade='E';$grade_point=1;}
                        if( $paper_all_marks_final_mark>49.9 &&  $paper_all_marks_final_mark<=54.9){$grade='D-';$grade_point=2;}
                        if( $paper_all_marks_final_mark>54.9 &&  $paper_all_marks_final_mark<=59.9){$grade='D+';$grade_point=2.5;}
                        if( $paper_all_marks_final_mark>59.9 &&  $paper_all_marks_final_mark<=64.9){$grade='C-';$grade_point=3;}
                        if( $paper_all_marks_final_mark>64.9 &&  $paper_all_marks_final_mark<=69.9){$grade='C+';$grade_point=3.5;}
                        if( $paper_all_marks_final_mark>69.9 &&  $paper_all_marks_final_mark<=74.9){$grade='B-';$grade_point=4;}
                        if( $paper_all_marks_final_mark>79.9 &&  $paper_all_marks_final_mark<=84.9){$grade='B+';$grade_point=4.5;}
                        if( $paper_all_marks_final_mark>84.9 &&  $paper_all_marks_final_mark<=89.9){$grade='A';$grade_point=5;}
                        if( $paper_all_marks_final_mark>89.9 &&  $paper_all_marks_final_mark<=100){$grade='A+';$grade_point=5.5;}

                    }
                    if($subject->find($request['subject'])->level == 'Ordinary Level'){

                        if( $paper_all_marks_final_mark<=39.9){$grade='F';$grade_point=0;}
                        if( $paper_all_marks_final_mark>39.9 &&  $paper_all_marks_final_mark<=44.9){$grade='0';$grade_point=0;}
                        if( $paper_all_marks_final_mark>44.9 &&  $paper_all_marks_final_mark<=49.9){$grade='E';$grade_point=1;}
                        if( $paper_all_marks_final_mark>49.9 &&  $paper_all_marks_final_mark<=54.9){$grade='D-';$grade_point=2;}
                        if( $paper_all_marks_final_mark>54.9 &&  $paper_all_marks_final_mark<=59.9){$grade='D+';$grade_point=2.5;}
                        if( $paper_all_marks_final_mark>59.9 &&  $paper_all_marks_final_mark<=64.9){$grade='C-';$grade_point=3;}
                        if( $paper_all_marks_final_mark>64.9 &&  $paper_all_marks_final_mark<=69.9){$grade='C+';$grade_point=3.5;}
                        if( $paper_all_marks_final_mark>69.9 &&  $paper_all_marks_final_mark<=74.9){$grade='B-';$grade_point=4;}
                        if( $paper_all_marks_final_mark>79.9 &&  $paper_all_marks_final_mark<=84.9){$grade='B+';$grade_point=4.5;}
                        if( $paper_all_marks_final_mark>84.9 &&  $paper_all_marks_final_mark<=89.9){$grade='A';$grade_point=5;}
                        if( $paper_all_marks_final_mark>89.9 &&  $paper_all_marks_final_mark<=100){$grade='A+';$grade_point=5.5;}

                        }



                Mark::create(array(
                    'student_id'=>$request['student'],
                    'subject_id'=>$request['subject'],
                    'grade'=>$grade,
                    'final_mark'=>$paper_all_marks_final_mark,
                    'teacher_comment'=>null,
                    'points'=>$grade_point
                ));





                return response()->json(['success'=>'Saved Successfully']);
            }




            return response()->json(['data'=>$request->all(),'term'=>$term,'set'=>$set]);
        }
        else
        {
            return response()->json(['errors'=>'Please Full Marks Field']);
        }

    }

    public function getManageMarks()
    {
        $users = new User();

      $id = Auth::user()->id;
      $term = Term::orderBy('id','asc')->get();
      $sets = Exmset::orderBy('id','asc')->get();
      $results = Result::orderBy('student_id','asc')->get();
      $students = Student::orderBy('id','asc')->get();
      $subjects = $users->with('subjects','schclasses')->where('id',$id)->first()->subjects()->get();
      $subjs = Subject::get();
      $schclasses = $users->with('subjects','schclasses')->where('id',$id)->first()->schclasses()->get();

        return view('manage-results.manage-marks',compact('subjs','subjects','schclasses','sets','term','results','students'));
    }
    public function fetchManageMarks(Request $request)
    {
        if($request['action']!=null){
            $output='';
            $subjects = new Subject();
            $students = new Student();
            $result = new Result();
            $users = new User();
            $id = Auth::user()->id;
            if($request['action']=='schclass')
            {
                $results = $users->with('subjects')->where('id',$id)->first()->subjects()->where('level',Subject::find($request['query'])->level)->get();

                $output.='<option value="">Select Subject</option>';
                foreach($results as $row)
                {
                    $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
            }
            if($request['action']=='term' && $request['class_id']!=null)
            {
                $results =$result->where('schclass_id',$request['class_id'])->get();


                foreach($results as $row)
                {
                    $output .= '<tr><td>'.$row['name'].'</td><td>'.$row['name'].'</td><td>'.$row['name'].'</td><td>'.$row['name'].'</td></tr>';
                }
            }
            return $output;
        }
        return response()->json(['action'=>$request['action'],'query'=>$request['query']]);
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


    public function printPdf(){

       $results= Result::orderBy('student_id')->get();
       $pdf = PDF::loadView('pdf.students',compact('results'));
       $pdf->save(public_path('files/').'_filename.pdf');
       return $pdf->download('results.pdf');



    }
}
