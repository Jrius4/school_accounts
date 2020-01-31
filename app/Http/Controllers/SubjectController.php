<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
use App\Paper;
use App\Subject;
use Dotenv\Regex\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Exporter\Exporter;

class SubjectController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view('manage-subjects.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subject $subject)
    {
        return view('manage-subjects.create',compact('subject'));
    }
    public function getAssignPaper(){
        return view('manage-subjects.assign-papers');
    }
    public function storeAssignPaper(Request $request)
    {
        $rules = [
            'paper_name'=>'required|unique:papers',
            'subject_name'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->messages()]);
        }
        Paper::create(['paper_name'=>$request['paper_name']]);
        Paper::where('paper_name',$request['paper_name'])->first()->subjects()->detach(Subject::find(explode(',',$request['subject_name_hidden'])));
        Paper::where('paper_name',$request['paper_name'])->first()->subjects()->attach(Subject::find(explode(',',$request['subject_name_hidden'])));


        return response()->json(['success'=>$request->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function fetchSubjects(Request $request)
    {
        $subjects = new Subject();
        if($request['action']!=null)
        {
            $output = '';
            if($request['action']=='level')
            {
                $result = $subjects->orderBy('name')->where('level',$request['query'])->get();

                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
                if($request['query']=='Both')
                {
                    $result = $subjects->orderBy('name')->get();

                    foreach($result as $row)
                    {
                        $output .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                    }
                }
            }
            return $output;
        }

        return response()->json(['success'=>$request->all()]);



    }

    public function store(Request $request)
    {
       $subject = new Subject();
       $rules = [
           'level'=>'required',
           'name'=>'required|unique:subjects',
           'subject_code'=>'required|unique:subjects',
           'subject_compulsory'=>'required',
       ];
       $validator = Validator::make($request->all(),$rules);
       if($validator->fails())
       {
           return response()->json(['errors'=>$validator->messages()]);
       }
       $subject->create($request->all());
       return response()->json('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
