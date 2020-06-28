<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SecretaryController extends Controller
{
    public function registerStudent(Request $request)
    {
        // dd($request->all());

        $rules = array(
            'student_name'=>'required',
            'rollno'=>'required',
            'class'=>'required',
            'fees_to_be_paid'=>'required',
            'paid_fees'=>'required',
            'stream'=>'required',
            'gender'=>'required',
            'password'=>'required|confirmed',
            'passport_photo'=>'required|image|max:1024',
            'admission_form'=>'required|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:1024',
            'medical_form'=>'required|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:1024'
        );

        // $request->validate($rules);
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $output = "";
            if($request['submit12']!=null)$output.="fails12";
            if($request['submit34']!=null)$output.="fails34";
            if($request['submit56']!=null)$output.="fails56";

            $errors = $validator->errors()->add($output,'something is wrong');
            // dd($errors);
            return redirect()->back()->with(compact('errors'));
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
        $student->fees_to_be_paid = request()->fees_to_be_paid;
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


            // return response()->json(['message'=>'student registration successfully']);
            return redirect()->back()->with('message','student registration successfully');
        }
        else
        {
            return response()->json(['errors'=>'student registration fails']);

        }

        return response()->json(['data'=>['requests'=>$request->all(),'admission'=>$filename3,'medical'=>$filename2,'pictures'=>$filename1]]);
    }



    public function getStudents12(Request $request)
    {
        $students = new Student();

        $students = $students->latest()->where('schclass_id','<','3')->where('schclass_id','>=','1')->get();

        return view('secretary.1-2-students',compact('students'));
    }

    public function getStudents34(Request $request)
    {
        $students = new Student();

        $students = $students->latest()->where('schclass_id','<','5')->where('schclass_id','>=','3')->get();

        return view('secretary.3-4-students',compact('students'));
    }

    public function getStudents56(Request $request)
    {
        $students = new Student();

        $students = $students->latest()->where('schclass_id','>=','5')->where('schclass_id','<=','6')->get();

        return view('secretary.5-6-students',compact('students'));
    }
}
