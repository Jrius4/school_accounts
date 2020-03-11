<?php

namespace App\Http\Controllers;

use App\Exmset;
use App\Models\Student;
use App\Result;
use App\Schclass;
use App\Subject;
use App\Term;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function registerStudent(Request $request)
    {
        // return response()->json(['response'=>$request->all()]);
        $rules = array(
            'student_name'=>'required',
            'rollno'=>'required',
            'class'=>'required',
            'paid_fees'=>'required',
            'stream'=>'required',
            'gender'=>'required',
            'password'=>'required|confirmed',
            'passport_photo'=>'required|image',
            'admission_form'=>'required|file',
            'medical_form'=>'required|file',
        );

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);
        }

        $filename1=null;
        $filename2=null;
        $filename3=null;

        $student = new Student();

        if($request->file('passport_photo') !=null)
        {
            $extension1 = Input::file('passport_photo')->getClientOriginalExtension();
            $filename1 = str_slug($request['student_name'],'_').'_picture'. '.' . $extension1;
            $request->file('passport_photo')->move(public_path(config('cms.image.directory')),$filename1);
            $student->image = $filename1;

        }
        if($request->file('medical_form') !=null)
        {
            $extension2 = Input::file('medical_form')->getClientOriginalExtension();
            $filename2 = str_slug($request['student_name'],'_').'_medical'. '.' . $extension2;

            $request->file('medical_form')->move(public_path(config('cms.file.directory')),$filename2);
            $student->medical_form = $filename2;



        }
        if($request->file('admission_form') !=null)
        {
            $extension3 = Input::file('admission_form')->getClientOriginalExtension();
            $filename3 = str_slug($request['student_name'],'_').'_admission'. '.' . $extension3;
            $request->file('admission_form')->move(public_path(config('cms.file.directory')),$filename3);
            $student->admission_form = $filename3;


        }
        $student->name = request()->student_name;
        $student->roll_number = request()->rollno;
        $student->schclass_id = request()->class;
        $student->schstream_id = request()->stream;
        $student->gender = request()->gender;
        $student->amount_paid = request()->paid_fees;
        $student->password = bcrypt(request()->password);
        if(request()->combination !== null)
        {
            $student->combination_id = request()->combination;

        }

        if($student->save())
        {
            if(request()->hidden_optional_subjects!==null)
            {
                $student->where('roll_number',request()->rollno)->first()->subjects()->attach(Subject::find(explode(",",request()->hidden_optional_subjects)));
            }


            return response()->json(['message'=>'student registration successfully']);
        }
        else
        {
            return response()->json(['errors'=>'student registration fails']);

        }

        return response()->json(['data'=>['requests'=>$request->all(),'admission'=>$filename3,'medical'=>$filename2,'pictures'=>$filename1]]);

    }

    public function indexStudent()
    {
        $student = Auth::guard('students')->user();
        return view('student.index',compact('student'));
    }
    public function studentResults()
    {
        $class = new Schclass();
        $term = new Term();
        $subject = new Subject();
        $set = new Exmset();
        $faker = Factory::create();

        global $bot_mark,$bot_mark1,$bot_mark2,$bot_mark3,
                    $mot_mark,$mot_mark1,$mot_mark2,$mot_mark3,
                    $eot_mark,$eot_mark1,$eot_mark2,$eot_mark3,
                    $paper_1_total,$paper_total1,$paper_total2,$paper_total3;

        $student = Auth::guard('students')->user();
        $id = Auth::guard('students')->user()->id;
        // $results = DB::table('results')->paginate(2)->groupBy('year');
        $results = Result::where('student_id',$id)->orderBy('created_at','asc')->paginate(3);
        // $results = Result::where('student_id',$id)->orderBy('created_at','asc')->groupBy('term_id');
        // $results = $results->toArray();
        // $results = $this->paginate($results,20);
        // return response()->json([$results]);
        // $results = $student->results();
        // return response()->json([$student,$results]);
        return view('student.results',compact('student','results','class','term','subject','set'
            ,'bot_mark','bot_mark1','bot_mark2','bot_mark3'
            ,'mot_mark','mot_mark1','mot_mark2','mot_mark3'
            ,'eot_mark','eot_mark1','eot_mark2','eot_mark3'
            ,'paper_1_total','paper_total1','paper_total2','paper_total3','faker'
    ));
    }
    public function index()
    {

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function ResultSearch(Request $request)
    {


        return $this->allResultTable(request()->search_class,request()->search_term,request()->search_student);


    }

    public function allResultTable($search_class,$search_term,$search_student)
    {
        // if($search_class==null&& $search_term==null && $search_student==null)
        // {

        // }
        if($search_class==null || $search_term==null  || $search_student==null)
        {
            $results = new Result();
            $students = new Student();
            $output="";
            global $bot_mark,$bot_mark1,$bot_mark2,$bot_mark3,
                    $mot_mark,$mot_mark1,$mot_mark2,$mot_mark3,
                    $eot_mark,$eot_mark1,$eot_mark2,$eot_mark3,
                    $paper_1_total,$paper_total1,$paper_total2,$paper_total3;

            if($results->get()->count()>0)
            {
                $output.='
                <div class="card-body table-responsive p-0 elevation-2 animated flipInX" style="height: 400px;">
                    <table id="RoleTable" class="table table-bordered table-head-fixed text-nowrap">
                    <thead>
                        <th colspan="2">Subject</th>

                        <th>Bot <br> out of '.Exmset::find(1)->set_percentage.'</th>
                        <th>Mot<br> out of '.Exmset::find(2)->set_percentage.'</th>
                        <th>Eot <br>out of '.Exmset::find(3)->set_percentage.'</th>
                        <th>Total Marks<br> of'.'100'.'</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </thead>
                    <tbody>
                    ';
                if($results->where('student_id',($search_student==null?'':$search_student))->where('schclass_id','like','%'.($search_class==null?'':$search_class).'%')->where('term_id','like','%'.($search_term==null?'':$search_term).'%')->count()>0)
                {
                    foreach($results->where('student_id',($search_student==null?'':$search_student))->where('schclass_id','like','%'.($search_class==null?'':$search_class).'%')->where('term_id','like','%'.($search_term==null?'':$search_term).'%')->get()->groupBy('term_id') as $ter_id=>$ter_res)
                    {
                        $output.='<tr><td colspan="9">'.$ter_res->where('term_id',$ter_id)->first()->term->name.'</td></tr>';

                        // if($ter_res->where('schclass_id','like','%'.($search_class==null?'':$search_class).'%')->count()>0)
                        // {

                            foreach($ter_res->groupBy('schclass_id') as $class_id=>$class_res)
                            {
                                $output.='<tr><td colspan="9">'.$ter_res->where('schclass_id',$class_id)->first()->schclass->name.'</td></tr>';

                                foreach($class_res->groupBy('student_id') as $stud=>$resul)
                                {



                                    $output.='<tr><td colspan="9">'.$students->find($stud)->name.'</td></tr>';
                                    foreach($resul->groupBy('subject_id') as $sub_id=>$res)
                                    {

                                                    // subject with three papers
                                                    if ($res->where('subject_id',$sub_id)->first()->subject->papersIn()->count()==3 && $res->first()->paper_id!=null)
                                                    {
                                                        $output.='
                                                        <tr>
                                                        <tr>
                                                        <td rowspan="3">'.$res->where('subject_id',$sub_id)->first()->subject->name.'</td>
                                                        <td>';
                                                        if($res->count()>0)
                                                        {
                                                            $output.= $res->first()->paper->paper_abbrev;
                                                        }
                                                        elseif($res->count()==0){
                                                            $output.="";
                                                        }
                                                        $output.='</td>
                                                        <td>';

                                                        if($res->where('exmset_id',1)->count()>0)
                                                        {
                                                            $bot_mark = round(($res->where('exmset_id',1)->first()->mark*Exmset::find(1)->set_percentage/100),2);
                                                            $output.= $bot_mark;
                                                        }
                                                        elseif($res->where('exmset_id',1)->count()==0){
                                                            $bot_mark = 0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';

                                                        if($res->where('exmset_id',2)->count()>0)
                                                        {
                                                            $mot_mark = round($res->where('exmset_id',2)->first()->mark*round((Exmset::find(2)->set_percentage/100),2),2);
                                                            $output.= $mot_mark;
                                                        }
                                                        elseif($res->where('exmset_id',2)->count()==0){
                                                            $mot_mark = 0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';

                                                        if($res->where('exmset_id',3)->count()>0)
                                                        {

                                                            $eot_mark = round(($res->where('exmset_id',3)->first()->mark*Exmset::find(3)->set_percentage/100),2);
                                                            $output.= $eot_mark;
                                                        }
                                                        elseif($res->where('exmset_id',3)->count()==0){
                                                            $eot_mark=0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';

                                                        if($res->count()>0)
                                                        {
                                                            $paper_1_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2);
                                                            $output.= $paper_1_total;
                                                        }
                                                        elseif($res->count()==0){
                                                            $paper_1_total=0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td rowspan="3">';
                                                        if($res->count()>0)
                                                        {
                                                            $bot_mark1=($res->where('exmset_id',1)->where('paper_id',$res->first()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',1)->where('paper_id',$res->first()->paper_id)->first()->mark*Exmset::find(1)->set_percentage)/100,2)
                                                            :0);
                                                            $mot_mark1=($res->where('exmset_id',2)->where('paper_id',$res->first()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',2)->where('paper_id',$res->first()->paper_id)->first()->mark*Exmset::find(2)->set_percentage)/100,2)
                                                            :0);
                                                            $eot_mark1=($res->where('exmset_id',3)->where('paper_id',$res->first()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',3)->where('paper_id',$res->first()->paper_id)->first()->mark*Exmset::find(3)->set_percentage)/100,2)
                                                            :0);
                                                            $paper_total1 = round(array_sum(array($bot_mark1,$mot_mark1,$eot_mark1)),2);
                                                        }
                                                        if($res->count()==0)
                                                        {
                                                            $paper_total1 = 0;
                                                            $output.="";
                                                        }
                                                        if($res->count()>1)
                                                        {
                                                            $bot_mark2=($res->where('exmset_id',1)->where('paper_id',$res[1]->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',1)->where('paper_id',$res[1]->paper_id)->first()->mark*Exmset::find(1)->set_percentage)/100,2)
                                                            :0);
                                                            $mot_mark2=($res->where('exmset_id',2)->where('paper_id',$res[1]->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',2)->where('paper_id',$res[1]->paper_id)->first()->mark*Exmset::find(2)->set_percentage)/100,2)
                                                            :0);
                                                            $eot_mark2=($res->where('exmset_id',3)->where('paper_id',$res[1]->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',3)->where('paper_id',$res[1]->paper_id)->first()->mark*Exmset::find(3)->set_percentage)/100,2)
                                                            :0);
                                                            $paper_total2 = round(array_sum(array($bot_mark2,$mot_mark2,$eot_mark2)),2);
                                                        }
                                                        if($res->count()<1)
                                                        {
                                                            $paper_total2 = 0;
                                                        }
                                                        if($res->count()>2)
                                                        {
                                                            $bot_mark3=($res->where('exmset_id',1)->where('paper_id',$res->last()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',1)->where('paper_id',$res->last()->paper_id)->first()->mark*Exmset::find(1)->set_percentage)/100,2)
                                                            :0);
                                                            $mot_mark3=($res->where('exmset_id',2)->where('paper_id',$res->last()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',2)->where('paper_id',$res->last()->paper_id)->first()->mark*Exmset::find(2)->set_percentage)/100,2)
                                                            :0);
                                                            $eot_mark3=($res->where('exmset_id',3)->where('paper_id',$res->last()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',3)->where('paper_id',$res->last()->paper_id)->first()->mark*Exmset::find(3)->set_percentage)/100,2)
                                                            :0);
                                                            $paper_total3 = round(array_sum(array($bot_mark3,$mot_mark3,$eot_mark3)),2);
                                                        }
                                                        if($res->count()<2)
                                                        {
                                                            $paper_total3 = 0;
                                                        }
                                                        $Subject_final_mark=round(array_sum(array($paper_total1,$paper_total2,$paper_total3))/3,2);
                                                        $output.=$Subject_final_mark;


                                                        $output.='</td>
                                                        <td rowspan="3">';
                                                        if($Subject_final_mark>90)
                                                        {
                                                            $Subject_final_grade = "A+";
                                                            $output.=$Subject_final_grade;
                                                        }
                                                        if($Subject_final_mark>=80 && $Subject_final_mark<90)
                                                        {
                                                            $Subject_final_grade = "A";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=75 && $Subject_final_mark<80)
                                                        {
                                                            $Subject_final_grade = "B+";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=70 && $Subject_final_mark<75)
                                                        {
                                                            $Subject_final_grade = "B";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=65 && $Subject_final_mark<70)
                                                        {
                                                            $Subject_final_grade = "C+";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=60 && $Subject_final_mark<65)
                                                        {
                                                            $Subject_final_grade = "C";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=55 && $Subject_final_mark<60)
                                                        {
                                                            $Subject_final_grade = "C";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=50 && $Subject_final_mark<55)
                                                        {
                                                            $Subject_final_grade = "C";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark<50)
                                                        {
                                                            $Subject_final_grade = "F";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        $output.='</td>
                                                        <td rowspan="3">
                                                        '.($Subject_final_grade !== null ?$this->teacherComment($Subject_final_grade):null).'
                                                        </td>

                                                        </tr>
                                                        <tr>
                                                            <td>';
                                                            if($res->count()>1)
                                                            {
                                                            $output.= $res[1]->paper->paper_abbrev;
                                                            }
                                                            elseif($res->count()<1)
                                                            {
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                                if($res->where('exmset_id',1)->count()>1)
                                                                {
                                                                    $bot_mark = round(($res->where('exmset_id',1)->nth(2,1)->first()->mark*Exmset::find(1)->set_percentage/100),2);
                                                                    $output.= $bot_mark;
                                                                }
                                                                elseif($res->where('exmset_id',1)->count()<1){
                                                                    $bot_mark = 0;
                                                                    $output.="";
                                                                }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',2)->count()>1)
                                                            {
                                                                $mot_mark = round(($res->where('exmset_id',2)->nth(2,1)->first()->mark*Exmset::find(2)->set_percentage/100),2);
                                                                $output.= $mot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',2)->count()<1){
                                                                $mot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',3)->count()>1)
                                                            {
                                                                $eot_mark = round(($res->where('exmset_id',3)->nth(2,1)->first()->mark*Exmset::find(3)->set_percentage/100),2);
                                                                $output.= $eot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',3)->count()<1){
                                                                $eot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->count()>1)
                                                            {
                                                                $paper_2_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2);
                                                                $output.= $paper_2_total;
                                                            }
                                                            elseif($res->count()<1){
                                                                $paper_2_total=0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                        </tr>
                                                        <tr>
                                                            <td>';
                                                            if($res->count()>2)
                                                            {
                                                                $output.=$res->last()->paper->paper_abbrev;

                                                            }
                                                            elseif($res->count()<2){
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',1)->count()>2)
                                                            {
                                                                $bot_mark = round(($res->where('exmset_id',1)->last()->mark*Exmset::find(1)->set_percentage/100),2);
                                                                $output.= $bot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',1)->count()<2){
                                                                $bot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',2)->count()>2)
                                                            {
                                                                $mot_mark = round(($res->where('exmset_id',2)->last()->mark*Exmset::find(2)->set_percentage/100),2);
                                                                $output.= $mot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',2)->count()<2){
                                                                $mot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',3)->count()>2)
                                                            {
                                                                $eot_mark = round(($res->where('exmset_id',3)->last()->mark*Exmset::find(3)->set_percentage/100),2);
                                                                $output.= $eot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',3)->count()<2){
                                                                $eot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->count()>2)
                                                            {
                                                                $paper_3_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2);
                                                                $output.= $paper_3_total;
                                                            }
                                                            elseif($res->count()<2){
                                                                $paper_3_total=0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                        </tr>
                                                        </tr>';

                                                    }



                                                    // subject with two papers

                                                    elseif($res->where('subject_id',$sub_id)->first()->subject->papersIn()->count()==2 && $res->where('subject_id',$sub_id)->first()->paper_id!=null)
                                                    {
                                                        $output.='
                                                        <tr>
                                                        <tr>
                                                        <td rowspan="2">'.$res->where('subject_id',$sub_id)->first()->subject->name.'</td>
                                                        <td>';
                                                        if($res->count()>0)
                                                        {
                                                            $output.= $res->first()->paper->paper_abbrev;
                                                        }
                                                        elseif($res->count()==0){
                                                            $output.="";
                                                        }
                                                        $output.='</td>
                                                        <td>';

                                                        if($res->where('exmset_id',1)->count()>0)
                                                        {
                                                            $bot_mark = round(($res->where('exmset_id',1)->first()->mark*Exmset::find(1)->set_percentage/100),2);
                                                            $output.= $bot_mark;
                                                        }
                                                        elseif($res->where('exmset_id',1)->count()==0){
                                                            $bot_mark = 0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';

                                                        if($res->where('exmset_id',2)->count()>0)
                                                        {
                                                            $mot_mark = round($res->where('exmset_id',2)->first()->mark*round((Exmset::find(2)->set_percentage/100),2),2);
                                                            $output.= $mot_mark;
                                                        }
                                                        elseif($res->where('exmset_id',2)->count()==0){
                                                            $mot_mark = 0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';

                                                        if($res->where('exmset_id',3)->count()>0)
                                                        {

                                                            $eot_mark = round(($res->where('exmset_id',3)->first()->mark*Exmset::find(3)->set_percentage/100),2);
                                                            $output.= $eot_mark;
                                                        }
                                                        elseif($res->where('exmset_id',3)->count()==0){
                                                            $eot_mark=0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';

                                                        if($res->count()>0)
                                                        {
                                                            $paper_1_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2);
                                                            $output.= $paper_1_total;
                                                        }
                                                        elseif($res->count()==0){
                                                            $paper_1_total=0;
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td rowspan="2">';
                                                        if($res->count()>0)
                                                        {
                                                            $bot_mark1=($res->where('exmset_id',1)->where('paper_id',$res->first()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',1)->where('paper_id',$res->first()->paper_id)->first()->mark*Exmset::find(1)->set_percentage)/100,2)
                                                            :0);
                                                            $mot_mark1=($res->where('exmset_id',2)->where('paper_id',$res->first()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',2)->where('paper_id',$res->first()->paper_id)->first()->mark*Exmset::find(2)->set_percentage)/100,2)
                                                            :0);
                                                            $eot_mark1=($res->where('exmset_id',3)->where('paper_id',$res->first()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',3)->where('paper_id',$res->first()->paper_id)->first()->mark*Exmset::find(3)->set_percentage)/100,2)
                                                            :0);
                                                            $paper_total1 = round(array_sum(array($bot_mark1,$mot_mark1,$eot_mark1)),2);
                                                        }
                                                        if($res->count()==0)
                                                        {
                                                            $paper_total1 = 0;
                                                            $output.="";
                                                        }

                                                        if($res->count()>1)
                                                        {
                                                            $bot_mark3=($res->where('exmset_id',1)->where('paper_id',$res->last()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',1)->where('paper_id',$res->last()->paper_id)->first()->mark*Exmset::find(1)->set_percentage)/100,2)
                                                            :0);
                                                            $mot_mark3=($res->where('exmset_id',2)->where('paper_id',$res->last()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',2)->where('paper_id',$res->last()->paper_id)->first()->mark*Exmset::find(2)->set_percentage)/100,2)
                                                            :0);
                                                            $eot_mark3=($res->where('exmset_id',3)->where('paper_id',$res->last()->paper_id)->count()>0?
                                                            round(($res->where('exmset_id',3)->where('paper_id',$res->last()->paper_id)->first()->mark*Exmset::find(3)->set_percentage)/100,2)
                                                            :0);
                                                            $paper_total2 = round(array_sum(array($bot_mark3,$mot_mark3,$eot_mark3)),2);
                                                        }
                                                        if($res->count()<2)
                                                        {
                                                            $paper_total2 = 0;
                                                        }
                                                        $Subject_final_mark=round(array_sum(array($paper_total1,$paper_total2))/2,2);
                                                        $output.=$Subject_final_mark;


                                                        $output.='</td>
                                                        <td rowspan="2">';
                                                        if($Subject_final_mark>90)
                                                        {
                                                            $Subject_final_grade = "A+";
                                                            $output.=$Subject_final_grade;
                                                        }
                                                        if($Subject_final_mark>=80 && $Subject_final_mark<90)
                                                        {
                                                            $Subject_final_grade = "A";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=75 && $Subject_final_mark<80)
                                                        {
                                                            $Subject_final_grade = "B+";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=70 && $Subject_final_mark<75)
                                                        {
                                                            $Subject_final_grade = "B-";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=65 && $Subject_final_mark<70)
                                                        {
                                                            $Subject_final_grade = "C+";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=60 && $Subject_final_mark<65)
                                                        {
                                                            $Subject_final_grade = "C-";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=55 && $Subject_final_mark<60)
                                                        {
                                                            $Subject_final_grade = "D+";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark>=50 && $Subject_final_mark<55)
                                                        {
                                                            $Subject_final_grade = "D-";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        if($Subject_final_mark<50)
                                                        {
                                                            $Subject_final_grade = "F";
                                                            $output.=$Subject_final_grade;

                                                        }
                                                        $output.='</td>
                                                        <td rowspan="2">
                                                        '.($Subject_final_grade !== null ?$this->teacherComment($Subject_final_grade):null).'

                                                        </td>

                                                        </tr>

                                                        <tr>
                                                            <td>';
                                                            if($res->count()>1)
                                                            {
                                                                $output.=$res->last()->paper->paper_abbrev;

                                                            }
                                                            elseif($res->count()<1){
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',1)->count()>1)
                                                            {
                                                                $bot_mark = round(($res->where('exmset_id',1)->last()->mark*Exmset::find(1)->set_percentage/100),2);
                                                                $output.= $bot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',1)->count()<1){
                                                                $bot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',2)->count()>1)
                                                            {
                                                                $mot_mark = round(($res->where('exmset_id',2)->last()->mark*Exmset::find(2)->set_percentage/100),2);
                                                                $output.= $mot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',2)->count()<1){
                                                                $mot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->where('exmset_id',3)->count()>1)
                                                            {
                                                                $eot_mark = round(($res->where('exmset_id',3)->last()->mark*Exmset::find(3)->set_percentage/100),2);
                                                                $output.= $eot_mark;
                                                            }
                                                            elseif($res->where('exmset_id',3)->count()<1){
                                                                $eot_mark = 0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                            <td>';
                                                            if($res->count()>1)
                                                            {
                                                                $paper_3_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2);
                                                                $output.= $paper_3_total;
                                                            }
                                                            elseif($res->count()<1){
                                                                $paper_3_total=0;
                                                                $output.="";
                                                            }
                                                            $output.='</td>
                                                        </tr>
                                                        </tr>';

                                                    }




                                                    elseif($res->where('subject_id',$sub_id)->first()->subject->papersIn()->count() == 0 && $res->where('subject_id',$sub_id)->first()->paper_id!=null)
                                                    {
                                                        $output.='<h3 class="display-1">'.$res->where('subject_id',$sub_id)->first()->subject->name.'</h3>';
                                                    }

                                                    elseif($res->where('subject_id',$sub_id)->first()->subject->papersIn()->count()>0 && $res->where('subject_id',$sub_id)->first()->paper_id == null)
                                                    {

                                                        $output.='<tr><tr>
                                                        <td colspan="2">';
                                                        if($res->count()>0)
                                                        {
                                                            $output.=$res->first()->subject->name;
                                                        }
                                                        elseif($res->count()<0)
                                                        {
                                                            $output.="";
                                                        }

                                                        $output.='</td>
                                                        <td>';
                                                        if($res->where('exmset_id',1)->count()>0)
                                                        {
                                                            $bot_mark = round(($res->where('exmset_id',1)->first()->mark*Exmset::find(1)->set_percentage/100),2);
                                                        $output.=$bot_mark;

                                                        }

                                                        elseif($res->where('exmset_id',1)->count()==0)
                                                        {
                                                            $bot_mark = 0;
                                                            $output.="";

                                                        }
                                                        $output.='</td>
                                                        <td>';
                                                        if($res->where('exmset_id',2)->count()>0)
                                                        {
                                                            $mot_mark = round(($res->where('exmset_id',2)->first()->mark*Exmset::find(2)->set_percentage/100),2);
                                                        $output.=$mot_mark;

                                                        }

                                                        elseif($res->where('exmset_id',2)->count()==0)
                                                        {
                                                            $mot_mark = 0;
                                                            $output.="";

                                                        }
                                                        $output.='</td>
                                                        <td>';
                                                        if($res->where('exmset_id',3)->count()>0)
                                                        {
                                                            $eot_mark = round(($res->where('exmset_id',3)->first()->mark*Exmset::find(3)->set_percentage/100),2);
                                                        $output.=$eot_mark;

                                                        }

                                                        elseif($res->where('exmset_id',3)->count()==0)
                                                        {
                                                            $eot_mark = 0;
                                                            $output.="";

                                                        }
                                                        $output.='</td>
                                                        <td>';
                                                        if($res->count()>0){
                                                                $total_mark = round((array_sum(array($bot_mark,$mot_mark,$eot_mark))),2);
                                                                $output.=$total_mark;
                                                        }

                                                        $output.='</td>
                                                        <td>';
                                                        if($res->count()>0){
                                                                $total_mark = round((array_sum(array($bot_mark,$mot_mark,$eot_mark))),2);
                                                                $output.=$total_mark;
                                                        }

                                                        $output.='</td>
                                                        <td>';
                                                        if($res->count()>0){
                                                                $total_mark = round((array_sum(array($bot_mark,$mot_mark,$eot_mark))),2);
                                                                    if($total_mark>90)
                                                                    {
                                                                        $Subject_final_grade = "A+";
                                                                        $output.=$Subject_final_grade;
                                                                    }
                                                                    if($total_mark>=80 && $total_mark<90)
                                                                    {
                                                                        $Subject_final_grade = "A";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark>=75 && $total_mark<80)
                                                                    {
                                                                        $Subject_final_grade = "B+";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark>=70 && $total_mark<75)
                                                                    {
                                                                        $Subject_final_grade = "B-";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark>=65 && $total_mark<70)
                                                                    {
                                                                        $Subject_final_grade = "C+";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark>=60 && $total_mark<65)
                                                                    {
                                                                        $Subject_final_grade = "C-";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark>=55 && $total_mark<60)
                                                                    {
                                                                        $Subject_final_grade = "D+";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark>=50 && $total_mark<55)
                                                                    {
                                                                        $Subject_final_grade = "D-";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                                    if($total_mark<50)
                                                                    {
                                                                        $Subject_final_grade = "F";
                                                                        $output.=$Subject_final_grade;

                                                                    }
                                                        }

                                                        $output.='</td>
                                                        <td>'.($Subject_final_grade !== null ?$this->teacherComment($Subject_final_grade):null).'</td>
                                                        ';

                                                    }


                                                    else
                                                    {
                                                        $output.='
                                                        <tr><tr>
                                                        <td colspan="2">'.$res->first()->subject->name.'</td>';
                                                        if($res->where('exmset_id',1)->count()>0)
                                                        {
                                                            $bot_mark = $res->where('exmset_id',1)->first()->mark*Exmset::find(1)->set_percentage/100;
                                                        $output.='<td>'.$bot_mark.'</td>';
                                                        }
                                                        elseif($res->where('exmset_id',1)->count()==0)
                                                        {
                                                            $bot_mark = 0;
                                                            $output.='<td>'.null.'</td>';
                                                        }
                                                        if($res->where('exmset_id',2)->count()>0)
                                                        {
                                                            $mot_mark = $res->where('exmset_id',2)->first()->mark*Exmset::find(2)->set_percentage/100;
                                                            $output.='<td>'.$mot_mark.'</td>';
                                                        }
                                                        elseif($res->where('exmset_id',2)->count()==0)
                                                        {
                                                            $mot_mark = 0;
                                                            $output.='<td>'.null.'</td>';
                                                        }
                                                        if($res->where('exmset_id',3)->count()>0)
                                                        {
                                                            $eot_mark = $res->where('exmset_id',3)->first()->mark*Exmset::find(3)->set_percentage/100;
                                                            $output.='<td>'.$eot_mark.'</td>';
                                                        }
                                                        elseif($res->where('exmset_id',3)->count()==0)
                                                        {
                                                            $eot_mark = 0;
                                                            $output.='<td>'.null.'</td>';
                                                        }
                                                        $final_total = round(array_sum(array($bot_mark,$mot_mark,$eot_mark)),2);

                                                        $output.='<td>'.round(array_sum($res->pluck('calculate_mark')->toArray()),2).'</td>';
                                                        $output.='<td>'.$final_total.'</td>';
                                                        $output.='<td>';
                                                        if($final_total>90)
                                                        {
                                                            $final_grade = "A+";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>90)
                                                        {
                                                            $final_grade = "A+";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>=80 && $final_total<90)
                                                        {
                                                            $final_grade = "A";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>=75 && $final_total<80)
                                                        {
                                                            $final_grade = "B+";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>=70 && $final_total<75)
                                                        {
                                                            $final_grade = "B-";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>=65 && $final_total<70)
                                                        {
                                                            $final_grade = "C+";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>=60 && $final_total<65)
                                                        {
                                                            $final_grade = "C-";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }

                                                        elseif($final_total>=55 && $final_total<60)
                                                        {
                                                            $final_grade = "D+";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total>=50 && $final_total<55)
                                                        {
                                                            $final_grade = "D-";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        elseif($final_total<50)
                                                        {
                                                            $final_grade = "F";
                                                            $output.='<span>'.$final_grade.'</span>';
                                                        }
                                                        $output.='</td><td>';
                                                        $output.=($final_grade !== null ?$this->teacherComment($final_grade):null);
                                                        $output.='</td>';

                                                        $output.='</tr></tr>';

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
                }

                elseif($results->where('term_id','like','%'.($search_term==null?'':$search_term).'%')->count() == 0)
                {
                    $output.='<tr>
                                <td colspan="9">
                                    No information for results of student
                                </td>

                            </tr>';
                }


                $output.='
                    </tbody>
                    <tfooter>
                        <th colspan="2">Subject</th>
                        <th>Bot <br> out of '. Exmset::find(1)->set_percentage.'</th>
                        <th>Mot<br> out of '.Exmset::find(2)->set_percentage.'</th>
                        <th>Eot <br>out of '.Exmset::find(3)->set_percentage.'</th>
                        <th>Total Marks<br> of'.'100'.'</th>
                        <th>Final Mark</th>
                        <th>Final Grade</th>
                        <th>Teacher Comment</th>
                    </tfooter>
                    </table>
                    </div>
                    ';
            }
            elseif($results->get()->count()==0)
            {
                $output.='<div class=""display-1>
                            <p>Student not existing</p>
                        </div>';
            }

            return $output;
        }
    }


    function paginate($items, $perPage)
{
    if(is_array($items)){
        $items = collect($items);
    }


    return new LengthAwarePaginator(
        $items->forPage(Paginator::resolveCurrentPage() , $perPage),
        $items->count(), $perPage,
        Paginator::resolveCurrentPage(),
        ['path' => Paginator::resolveCurrentPath()]
    );
}



}
