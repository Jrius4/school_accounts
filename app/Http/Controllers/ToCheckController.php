<?php

namespace App\Http\Controllers;

use App\Model\SchoolClass;
use App\Subject;
use App\User;
use Illuminate\Http\Request;

class ToCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_list = User::pluck('name','id');
        $users = User::latest()->get();
        $subjects= Subject::with('schoolClasses')->latest()->get();

        return view('manage-tests.index',compact('user_list','users','subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subject $subject)
    {
        $user_list = User::pluck('name','id');
        $users = User::latest()->get();
        $classes = SchoolClass::orderBy('id','desc')->get();
        $subjects= Subject::latest()->get();
        return view('manage-tests.create')->with(['user_list'=>$user_list,'users'=>$users,'subjects'=>$subjects,'subject'=>$subject,'classes'=>$classes]);
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
            'name'=>'required|unique:subjects',
        ];
        $subject= new Subject();
        $this->validate($request,$rules);
        $subject->create($request->all());

        return redirect(route('to-checks.index'))->with(['message'=>'subject created']);

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
