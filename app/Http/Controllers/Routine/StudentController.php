<?php

namespace App\Http\Controllers\Routine;

use App\Combination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Backend\BackendController;
use App\Subject;

class StudentController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $students = Student::orderBy('created_at','desc')->where('updated_at','LIKE','%'.'2020'.'%')->get();
        $level=null;
        return view('manage-students.index',compact('students','level'));
    }
    public function searchStudent(Request $request){
      if($request->keywords != null)  $students = Student::where('name','like','%'.$request->keywords.'%')->paginate(5);
      if($request->keywords == '' || !isset($request->keywords))  $students = Student::get();
        return response()->json($students);
    }
    public function indexOlevel()
    {
        $students = Student::where('roll_number','like','O%')->orderBy('created_at','desc')->get();
        $level='O';
        return view('manage-students.index',compact('students','level'));
    }
    public function indexAlevel()
    {
        $level='A';

        $students = Student::where('roll_number','like','A%')->orderBy('created_at','desc')->get();

        return view('manage-students.index',compact('students','level'));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('manage-students.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $studentSubject = $student->subjects;
        $subjects = Subject::get();
        $combinations = Combination::get();
        return view('manage-students.edit-optional-subject',compact('student','subjects','studentSubject','combinations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        // dd($request->all(),$student);
        $subjects= new Subject();


        if($student->schclass_id >=3 && $student->schclass_id <=4)
        {
            // $student->subjects()->detach($subjects->find(explode(",",$request['opt_id'])));
            $student->subjects()->detach();
            $student->subjects()->attach($subjects->find(explode(",",$request['opt_id'])));
        }
        if($student->schclass_id >=5 && $student->schclass_id <=6)
        {
                    // dd($request->all(),$student);

            $student->update(array("combination_id"=>$request['combination']));
        }
        return redirect()->route('students.index');

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
