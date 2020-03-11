<?php

namespace App\Http\Controllers;

use App\DeclareResults;
use App\Exmset;
use App\Http\Controllers\Backend\BackendController;
use App\Models\Student;
use App\ResultEntry;
use App\Schclass;
use App\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeclareResultsController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years =[];
        for ($i=0; $i < 6; $i++) {
            array_push($years,['year'=>Carbon::now()->modify('-'.$i.' year')->year]);
        }
        $declares = DeclareResults::orderBy('updated_at','asc')->get();
        $entryStatus = ResultEntry::findOrFail(1)->status;
        $terms = Term::orderBy('id','asc')->get();
        $sets = Exmset::orderBy('id','asc')->get();
        $students = Student::orderBy('name','asc')->get();
        $classes = Schclass::orderBy('id','asc')->get();
        return view('manage-declare-results.index',compact('declares','years','terms','sets','students','classes','entryStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DeclareResults $declareResults)
    {
        return view('manage-declare-results.create',compact('declareResults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'year'=>'required',
            'term_id'=>'required',
            'student_id'=>'nullable',
            'schclass_id'=>'nullable',
            'status'=>'required'
        );
        $request->validate($rules);

        $class = new DeclareResults();
        $class->create($request->all());

        return redirect()->route('declares.index')->with(['message'=>'declare action']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeclareResults  $declareResults
     * @return \Illuminate\Http\Response
     */
    public function show(DeclareResults $declareResults)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeclareResults  $declareResults
     * @return \Illuminate\Http\Response
     */
    public function edit(DeclareResults $declareResults)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeclareResults  $declareResults
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeclareResults $declareResults)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeclareResults  $declareResults
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeclareResults $declareResults)
    {
        //
    }

    public function allowEntryStatus(Request $request)
    {
        $entryStatus = ResultEntry::findOrFail(1);
        if($request['resultEntry']){
            $entryStatus->update(array('status'=>1));
            return response()->json(['status'=>'results entry enabled']);
        }
        if(!$request['resultEntry']){
            $entryStatus->update(array('status'=>0));
            return response()->json(['status'=>'results entry disabled']);
        }
        return response()->json(['data'=>$request->all()]);
    }
}
