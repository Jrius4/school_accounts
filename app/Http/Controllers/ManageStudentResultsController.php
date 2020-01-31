<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Result;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class ManageStudentResultsController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = Result::latest()->get();

        if ($request->ajax()) {

            $data = Result::latest()->get();

            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){



                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';



                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';



                            return $btn;

                    })
                    ->rawColumns(['action'])

                    ->make(true);

        }


        return view('manage-student-results.index',compact('results'));
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
        $rules = [
            'subject_name'=>'required',
            'teacher_id'=>'required',
            'marks'=>'required|integer',
            'student_regno'=>'required',
            'comments'=>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->messages()]);

        }
        $student = new Student();

        if($student->where('roll_number',$request['student_regno'])->count()>0){
           $studentName = $student->where('roll_number',$request['student_regno'])->first()->name;
        }else{
            return response()->json(['error-short'=>'student does not exist enter with the right Registration Number']);
        }
        $results = array(
            'teacher_id'=>$request->teacher_id,
            'student_regno'=>$request->student_regno,
            'student_name'=>$studentName,
            'subject_name'=>$request->subject_name,
            'marks'=>$request->marks,
            'comments'=>$request->comments
        );

        Result::updateOrCreate(['id' => $request->result_id],$results);



        return response()->json(['success'=>'result saved successfully.']);
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
        $result = Result::find($id);

        return response()->json($result);
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
        Result::find($id)->delete();



        return response()->json(['success'=>'result deleted successfully.']);
    }
}
