<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Subject;
use Illuminate\Http\Request;
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
    public function index()
    {
        //
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
}
