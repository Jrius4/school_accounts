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
        $subjects = Subject::get();
        return view('manage-subjects.assign-papers',compact('subjects'));
    }
    public function storeAssignPaper(Request $request)
    {
        $rules = [
            'paper_name'=>'nullable',
            // 'paper_name'=>'required|unique:papers',
            'subject_name'=>'required',
            'paper_abbrev'=>'required',
            'paper_percentage'=>'integer',
        ];
        // dd($request->all());
        $request->validate($rules);
        // $validator = Validator::make($request->all(),$rules);
        // if($validator->fails()){
        //     return response()->json(['errors'=>$validator->messages()]);
        // }

        $papers = new Paper();

        if($papers->where('subject_id',$request['subject_name'])->where('paper_abbrev',$request['paper_abbrev'])->count()>0)
        {
            $papers->where('subject_id',$request['subject_name'])->where('paper_abbrev',$request['paper_abbrev'])->first()->update(
                array(
                    'paper_name'=>$request['paper_name'],
                    'paper_abbrev'=>$request['paper_abbrev'],
                    'subject_id'=>$request['subject_name'],
                    'paper_percentage'=>$request['paper_percentage'],
                )
            );
        }
        else{
            Paper::create(array(
            'paper_name'=>$request['paper_name'],
            'paper_abbrev'=>$request['paper_abbrev'],
            'subject_id'=>$request['subject_name'],
            'paper_percentage'=>$request['paper_percentage'],
        ));
        }


        return redirect()->route('subjects.index')->with(['message'=>'Paper created successfully']);
        // Paper::create(['paper_name'=>$request['paper_name'],''=>$request]);
        // Paper::where('paper_name',$request['paper_name'])->first()->subjects()->detach(Subject::find(explode(',',$request['subject_name_hidden'])));
        // Paper::where('paper_name',$request['paper_name'])->first()->subjects()->attach(Subject::find(explode(',',$request['subject_name_hidden'])));


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
    $request->validate($rules);
       $subject->create($request->all());
    return redirect()->route('subjects.index')->with(['message'=>'Subject created successfully']);
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
        return view('manage-subjects.edit',compact('subject'));

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
        $rules = [
            'level'=>'required',
            'name'=>'required',
            'subject_code'=>'required',
            'subject_compulsory'=>'required',
        ];
     $request->validate($rules);
     $subject->update($request->all());
     return redirect()->route('subjects.index')->with(['message'=>'Subject updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with(['message'=>'Subject deleted successfully']);

    }
}
