<?php

namespace App\Http\Controllers;

use App\Exmset;
use Illuminate\Http\Request;

class ExmsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $sets = Exmset::orderBy('id')->get();
        return view('manage-sets.index',compact('sets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Exmset $exmset)
    {
        $sets = Exmset::orderBy('id')->get();
        return view('manage-sets.form',compact('sets','exmset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'set_name'=>'required',
            'set_percentage'=>'integer'
        ];
        $request->validate($rules);
        $exmset = Exmset::findOrFail($request->set_name);
        $exmset->update(['set_percentage'=>$request->set_percentage]);
        return redirect()->route('sets.index')->with(['message'=>'successfully updated']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exmset  $exmset
     * @return \Illuminate\Http\Response
     */
    public function show(Exmset $exmset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exmset  $exmset
     * @return \Illuminate\Http\Response
     */
    public function edit(Exmset $exmset)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exmset  $exmset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exmset $exmset)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exmset  $exmset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exmset $exmset)
    {
        //
    }
}
