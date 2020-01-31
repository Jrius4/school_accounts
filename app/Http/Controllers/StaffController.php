<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendController;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::get();

        return view('manage-staffs.index',compact('staffs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Staff $staff)
    {
        return view('manage-staffs.create',compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =[
            'name'=>'required'
        ];



        // $this->validate($request,[
        //     'name' => 'required',
        //     'author' => 'required',
        //     'file' => 'required',
        //     'image'=>'required|image'
        // ]);

        $this->validate($request,$rules);
        $staff = new Staff();

        $staff->name = $request->name;
        $staff->slug = str_slug($request->name);
        $staff->save();



        return redirect(route('staffs.index'))->with('message','staff created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
